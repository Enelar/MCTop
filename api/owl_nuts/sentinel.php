<?php

class sentinel extends api
{
    private function DoRequest($addr, $port)
    {
        $socket = fsockopen($addr, $port, $errno, $errstr, 5);

        if (!$socket)
        {
            echo "$errstr ($errno)<br />\n";
            return;
        }

        fwrite($fp, "\xFE\x01\xFA");
        fwrite($fp, "\x00\x0B");
        $mcping = mb_convert_encoding("MC|PingHost", "UTF-16");
        fwrite($fp, $mcping);
        $res = "";
        while (!feof($fp))
        $res .= fgets($fp, 128);
        fclose($fp);
        return $res;
    }

    public function QueryServer($id)
    {
       $server = LoadModule('api', 'Servers')->info($id);
       $res = $this->DoRequest($server->addr, $server->port);
       $res = Core::get_db()->Query("INSERT INTO owl_nuts.\"mc.ping\" (id, res, ip, port) VALUES ($1, $2, $3, $4) RETURNING id",
            [$id, $res, $server->addr, $server->port]);
       return $res();
    }

    public function QueryNext()
    {
        $trans = Core::get_db()->Begin();
        $task = Core::get_db()->Query("SELECT * FROM owl_nuts.\"mc.ping.board\" WHERE now() - last_sync < $1::interval ORDER BY last_try ASC NULLS FIRST LIMIT 1",
            [Core::get_settings()->mcping->delay], true);
        
        if (!$task())
            return;
        
        $res = $this->QueryServer($task->id);
        return $trans->Finish($res());
    }

    public function FillTheBoard()
    {
        $trans = Core::get_db()->Begin();
        $rows = Core::get_db()->Query("SELECT a.id FROM main.servers as a LEFT OUTER JOIN owl_nuts.\"mc.ping.board\" as b ON a.id=b.id WHERE b.id IS NULL");
        foreach ($rows as $row)
            Core::get_db()->Query("INSERT INTO owl_nuts.\"mc.ping.board\"(id) VALUES ($1)", [$row->id]);
        $trans->Commit();
        return $rows();
    }

    protected function ServerStatus($id)
    {
        $res = Core::get_db()->Query("SELECT * FROM owl_nuts.\"mc.ping\" WHERE id = $1 AND now() - snap < $2::interval",
            [$id, Core::get_settings()->application->mcping->delay]);

        if (!$res())
            return null;
        return $res['res'];
    }
}