<?php

class Projects extends api
{
    protected function reserve($page = 1)
    {
        $res = Core::get_db()->Query('select * from main.projects where active = 1 order by score limit 10 offset $1', [$page*10]);

        return [
            'design' => 'rating/index',
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
}


