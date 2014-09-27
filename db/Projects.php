<?php

class Projects extends X
{

    public $cl_name = 'Projects';

    public $id, $name, $description, $owner, $position, $score, $minus_score, $plus_score, $avatar, $servers, $site_url;
    public $vk_group, $fb_public, $twitter_account;
    public $fields_to_edit = 'name, description, site_url, vk_group, fb_public, twitter_account';

    static function get_project($id, $for_what_purposes = null)
    {
        $result = Core::get_db()->Query("select * from main.projects where id = $1", [$id], true);

        if (!$result) {
            if (is_null($for_what_purposes))
                Core::throw_error('Проект не найден');
            else
                return array('data' => null);
        }

        $idle_project = new Projects();
        foreach ($result as $key => $value)
            $idle_project->$key = $value;

        $idle_project->servers = self::get_project_servers($idle_project->id);

        return $idle_project;
    }

    static function get_projects_for_rating_page($page, $limit = 10)
    {
        $_offset = $page * 10;

        $result = Core::get_db()->Query("select * from main.projects where active = 1 order by score desc limit $1 ", [$limit]);
        $projects = [];

        foreach ($result as $project) {
            $idle_project = new Projects();

            foreach ($project as $key => $value)
                $idle_project->$key = $value;
            $idle_project->servers = Projects::get_project_servers($idle_project->id);

            $projects[] = $idle_project;
        }

        return $projects;
    }

    static function get_user_projects($user, $page = 0, $limit = 10)
    {
        $_offset = $page * 10;

        $result = Core::get_db()->Query("select * from main.projects where owner = $1 limit $2", [$user, $limit]);

        $projects = [];

        foreach ($result as $project) {
            $idle_project = new Projects();

            foreach ($project as $key => $value)
                $idle_project->$key = $value;

            $idle_project->servers = self::get_project_servers($idle_project->id);

            $projects[] = $idle_project;
        }

        return $projects;
    }

    static function get_project_servers($project)

    {
        $servers = [];
        $result = Core::get_db()->Query("select * from main.servers where project = $1", [$project]);
        foreach ($result as $server) {
            $idle_server = new Servers();

            foreach ($server as $key => $value)
                $idle_server->$key = $value;

            $servers[] = $idle_server;
        }
        return $servers;
    }

    function add_new_server()
    {
        return Core::get_db()->Query("INSERT INTO main.servers(project) VALUES ($1)", [$this->id]);
    }

}
