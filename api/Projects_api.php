<?php

class Projects_api extends API
{

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

        $query = 'UPDATE main.projects set ';

        foreach ($changed_fields as $key => $field)
            $query .= "$key = '{$_POST[$key]}', ";

        $query = substr($query, 0, strlen($query) - 2);
        $query .= ' where id = ' . $project->id;

        return Core::get_db()->Query($query);
    }

}
