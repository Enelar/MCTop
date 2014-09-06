<?php

class Projects_api extends API
{

    function create()
    {

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

}
