<?php

class Projects extends API
{

    function create()
    {
        API::is_user_authorized_and_is_not_empty_post_request();

        return ['result' => Core::get_db()->Query("INSERT INTO main.projects(name, owner) VALUES ($1, $2)", ['Название проекта', $_POST['user']])];
    }

    function update()
    {

        API::is_user_authorized_and_is_not_empty_post_request();

        $project = Projects::get_project(intval($_POST['id']));

        $fields = explode(', ', $project->fields_to_edit);
        $changed_fields = [];


        foreach ($fields as $key => $field) {
            if ($field != 'owner' && $project->$field != $_POST[$field])
                $changed_fields[$field] = 1;
        }

        if(sizeof($changed_fields) == 0)
            return true;

        $query = 'UPDATE main.projects set ';

        $i = 1;
        $params = [];
        foreach ($changed_fields as $key => $field)
        {
            $prebind_param = '$'.$i;
            $query .= "$key = $prebind_param, ";
            $params[$i-1] = $_POST[$key];
            $i++;
        }

        $query = substr($query, 0, strlen($query) - 2);
        $query .= ' where id = ' . $project->id;

        return Core::get_db()->Query($query, $params);
    }

    function delete()
    {

    }

    function get($id = null)
    {
        if(!is_null($id))
            $_GET['id'] = $id;
        return new Projects_api_object(Projects::get_project(intval($_GET['id'])));
    }

}

class Projects_api_object
{
    public $name, $description, $avatar, $servers, $score, $minus_score, $plus_score, $position;

    public function __construct(Projects $project)
    {
        foreach($project as $key => $value)
        {
            if(array_key_exists($key, get_class_vars('Projects_api_object')))
                if($key == 'servers')
                    $this->$key = Projects_api_server_object::get_servers($value);
                else
                    $this->$key = $value;
        }
    }
}

class Projects_api_server_object
{
    public $name, $description, $project, $features, $map_url, $address;

    public static function get_servers($servers = null, $behaviour = null)
    {

        $servers_to_callback = [];

        foreach($servers as $server)
        {
            $_server_to_callback = new Projects_api_server_object();

            foreach($server as $key => $value)
            {
                if(array_key_exists($key, get_class_vars('Projects_api_server_object')))
                    $_server_to_callback->$key = $value;
            }

            $servers_to_callback[] = $_server_to_callback;
        }

        return $servers_to_callback;
    }
}