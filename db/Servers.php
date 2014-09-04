<?php

class Servers extends X
{

    public $cl_name = 'Servers';

    public $id, $name, $description, $owner, $position, $score, $minus_score, $plus_score, $avatar;
    public $vkontakte_public, $facebook_public, $twitter_account;

    static function get_server($id, $for_what_purposes = null)
    {
        $sth = Core::get_db()->prepare("select * from servers where id = '$id'");
        $sth->execute()
        or
        self::abort($sth);

        $result = $sth->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            if (is_null($for_what_purposes))
                Core::oups_sorry_404('Сервер не найден');
            else
                return array('data' => null);
        }

        $idle_server = new Servers();
        foreach ($result as $key => $value)
            $idle_server->$key = $value;

        $idle_server->position = 1;
        $idle_server->score = 1;

        $sth = Core::get_db()->prepare("select * from servers_additional where id = '$id'");
        $sth->execute()
        or
        self::abort($sth);

        $result = $sth->fetch(PDO::FETCH_ASSOC);

        if ($result) {

            if (isset($result['vkontakte']))
                $idle_server->vkontakte_public = $result['vkontakte'];

            if (isset($result['facebook']))
                $idle_server->facebook_public = $result['facebook'];

            if (isset($result['twitter']))
                $idle_server->twitter_account = $result['twitter'];
        }

        return $idle_server;
    }

    function update_server()
    {

    }

    function delete_server()
    {

    }

    function get_servers_for_rating_page($page, $limit = 10)
    {
        return 'oups';
        $_offset = $page * 10;

        $sth = Core::get_db()->prepare("select * from servers limit $limit");
        $sth->execute()
        or
        self::abort($sth);

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        $servers = [];

        foreach ($result as $server) {
            $idle_server = new Servers();

            foreach ($server as $key => $value)
                $idle_server->$key = $value;

            $idle_server->position = 1;
            $idle_server->score = 1;

            $servers[] = $idle_server;
        }

        return $servers;
    }

}
