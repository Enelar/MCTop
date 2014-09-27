<?php

class Servers_api extends API
{

    function create()
    {
        API::is_user_authorized_and_is_not_empty_post_request();
        $project = Projects::get_project($_POST['project']);
        if(!$_POST['user'] == $project->owner)
            Core::abort("Oups");

        return $project->add_new_server();
    }

    function update()
    {

        API::is_user_authorized_and_is_not_empty_post_request();

        $server = Servers::get_server(intval($_POST['id']));

        if($server->project_info->owner != Core::get_current_user_profile()->id)
            Core::abort("Oups");

        $fields = explode(', ', $server->fields_to_edit);
        $changed_fields = [];


        if(isset($_POST['tags']))
        {
            $tags = explode(',',strtolower($_POST['tags']));

            $tags_string = '';

            if(sizeof($tags)>0)
                foreach($tags as $tag)
                    $tags_string .= ':'.$tag.': ';

            Core::$db->Query("update main.servers set tags = $1 where id = $2", [$tags_string, $server->id]);
        }

        foreach ($fields as $key => $field) {
            if(isset($_POST[$field]))
                if ($field != 'owner' && $server->$field != $_POST[$field] && $field != 'tags')
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
        //return new Object(array($params, $query));
        return Core::get_db()->Query($query, $params);
    }

    function delete()
    {

    }

}
