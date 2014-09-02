<?php

class Projects extends X
{

    public $cl_name = 'Projects';

    public $id, $name, $description, $owner, $position, $score, $minus_score, $plus_score, $avatar;
    public $vkontakte_public, $facebook_public, $twitter_account;
    public $fields_to_edit = 'name, description';

    static function get_project($id, $for_what_purposes = null)
    {
        $sth = Core::get_db()->prepare("select * from projects where id = '$id'");
        $sth->execute()
        or
        self::abort($sth);

        $result = $sth->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            if (is_null($for_what_purposes))
                Core::oups_sorry_404('Проект не найден');
            else
                return array('data' => null);
        }

        $idle_project = new Projects();
        foreach ($result as $key => $value)
            $idle_project->$key = $value;


        return $idle_project;
    }

    function update_project()
    {

    }

    function delete_project()
    {

    }

    static function get_projects_for_rating_page($page, $limit = 10)
    {
        $_offset = $page * 10;

        $sth = Core::get_db()->prepare("select * from projects limit $limit");
        $sth->execute()
        or
        self::abort($sth);

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        $projects = [];

        foreach ($result as $project) {
            $idle_project = new Projects();

            foreach ($project as $key => $value)
                $idle_project->$key = $value;

            $projects[] = $idle_project;
        }

        return $projects;
    }

    static function get_user_projects($user, $page = 0, $limit = 10)
    {
        $_offset = $page * 10;

        $sth = Core::get_db()->prepare("select * from projects where owner = '$user' limit $limit");
        $sth->execute()
        or
        self::abort($sth);

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        $projects = [];

        foreach ($result as $project) {
            $idle_project = new Projects();

            foreach ($project as $key => $value)
                $idle_project->$key = $value;

            $projects[] = $idle_project;
        }

        return $projects;
    }

}
