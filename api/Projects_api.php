<?php

class Projects_api extends API
{

    function update()
    {
        global $core;
        API::is_user_authorized_and_is_not_empty_post_request();

        $project = Projects::get_project(intval($_POST['id']));

        $fields = explode(', ', $project->fields_to_edit);
        $changed_fields = [];


        foreach ($fields as $key => $field) {
            if ($field != 'owner')
                if ($project->$field != $_POST[$field] and $field != 'owner') {
                    $changed_fields[$field] = 1;
                }
        }

        $query = 'UPDATE projects set ';

        foreach ($changed_fields as $key => $field)
            $query .= "$key = '{$_POST[$key]}', ";

        $query = substr($query, 0, strlen($query) - 2);
        $query .= ' where id = ' . $project->id;

        $sth = Core::get_db()->prepare($query);
        $status = $sth->execute()
        or
        self::abort($sth);
        return $status;
    }

}
