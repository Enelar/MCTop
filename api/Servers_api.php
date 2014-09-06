<?php

class Servers_api extends API
{

    function update()
    {

        API::is_user_authorized_and_is_not_empty_post_request();

        $server = Servers::get_server(intval($_POST['id']));

        $fields = explode(', ', $server->fields_to_edit);
        $changed_fields = [];


        foreach ($fields as $key => $field) {
            if ($field != 'owner' && $server->$field != $_POST[$field])
                $changed_fields[$field] = 1;
        }

        if(sizeof($changed_fields) == 0)
            return true;

        $query = 'UPDATE main.servers set ';

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
        $query .= ' where id = ' . $server->id;

        return Core::get_db()->Query($query, $params);
    }

}
