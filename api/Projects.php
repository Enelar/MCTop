<?php

class Projects extends api
{
    protected function reserve($page = 1)
    {
        $res = Core::get_db()->Query('select * from main.projects where active = 1 order by score limit 10 offset $1', [$page*10]);

        return [
            'design' => 'rating/projects_list',
            'data' => [
              'projects' => $res,
            ],
        ];
    }

    protected function get_servers($id)
    {
        $res = Core::get_db()->Query('select * from main.servers where project = $1', [$id]);

        return [
            'design' => 'rating/project_servers',
            'data' => [
                'servers' => $res,
            ]
        ];
    }

    protected function owner($id)
    {
        $row = Core::get_db()->Query('select * from main.projects where id=$1', [$id], true);
        return $row->owner == LoadModule('api', 'Users')->uid();
    }

    protected function require_owner($id)
    {
        phoxy_protected_assert($this->owner($id), ["error" => "You should be project owener"]);
    }

    protected function set_banner($id, $name)
    {
        $this->require_owner($id);

        $image = LoadModule('api/utils', 'Image');
        $image->require_owner($name);

        $res = db::Query("UPDATE main.projects SET banner=$2 WHERE id=$1 RETURNING id", [$id, $name]);
        return !!$res;
    }
}


