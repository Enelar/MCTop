<?php

class Projects extends api
{
    protected function reserve($page = 1)
    {
        if($page <= 0)
            return ['error' => 'Хакер, уровень: mctop v.1'];
        $res = Core::get_db()->Query('select * from main.projects where active = 1 order by score limit 10 offset $1', [$page*10]);
        $projects_count = Core::get_db()->Query('select count (*) from main.projects where active = 1', [], true);
        return [
            'design' => 'rating/projects_list',
            'data' => [
              'projects' => $res,
              'projects_count' => $projects_count['count'],
              'current_page' => $page
            ],
        ];
    }

    protected function info($id)
    {
        return
        [
            "data" => [
                "info" => Core::get_db()->Query('select * from main.projects where owner = $1 and id = $2', [LoadModule('api', 'Users')->get_uid(), $id], true)
            ]
        ];
    }

    protected function get_servers($id)
    {
        $res = Core::get_db()->Query('select * from main.servers where project = $1 order by id', [$id]);

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

    protected function update($id)
    {
        global $_POST;
        Core::get_db()->Query("
            update main.projects set
            name = $2,
            description =$3,
            secret_key = $4,
            secret_url = $5,
            site_url = $6,
            vk_group = $7,
            fb_public = $8,
            twitter_account = $9
            where id = $1
        ", [
            $id,
            $_POST['name'],
            $_POST['description'],
            $_POST['secret_key'],
            $_POST['secret_url'],
            $_POST['site_url'],
            $_POST['vk_group'],
            $_POST['fb_public'],
            $_POST['twitter_account']
        ]);
    }
}


