<?php

class Servers extends X
{

    public $cl_name = 'Servers';

    public $id, $name, $description, $features, $project, $map_url, $address, $port, $project_info;

    public $fields_to_edit = 'name, description, features, map_url, address, port';

    static function get_server($id, $for_what_purposes = null)
    {
        $result = Core::get_db()->Query("select * from main.servers where id = $1", [$id], true);

        if (!$result) {
            if (is_null($for_what_purposes))
                Core::throw_error('Сервер не найден');
            else
                return array('data' => null);
        }

        $idle_server = new Servers();
        foreach ($result as $key => $value)
            $idle_server->$key = $value;

        $idle_server->project_info = Projects::get_project($idle_server->project);

        return $idle_server;
    }

    static function transform_array_server_info_to_object()
    {

    }

    function update_server()
    {

    }

    function delete_server()
    {

    }

    static function get_servers_for_rating_page($page, $limit = 10)
    {
        $_offset = $page * 10;
        $result = Core::get_db()->Query("select * from main.servers limit $1", [$limit]);
        $servers = [];

        foreach ($result as $server) {
            $idle_server = new Servers();

            foreach ($server as $key => $value)
                $idle_server->$key = $value;

            $idle_server->project_info = Projects::get_project($idle_server->project);

            $servers[] = $idle_server;

        }

        return $servers;
    }

    function map_url()
    {
        if(strlen($this->map_url)>0)
            echo 'Адрес карты: '.$this->map_url.'<br>';
    }

    function address()
    {
        echo $this->address.':'.$this->port.'<br><br>';
    }

}
