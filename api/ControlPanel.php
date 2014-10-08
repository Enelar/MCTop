<?php
class ControlPanel extends api
{
    //todo проверка на то, залогинен ли юзер, если нет - пшел нах##

    protected function reserve()
    {
        return
        [
            "design" => "control_panel/index",
            "data"   => [
                "user_projects" => Core::get_db()->Query('select * from main.projects where owner = $1', [LoadModule('api', 'Users')->get_uid()]),
            ]
        ];
    }

    protected function project_info($id)
    {
        $servers = LoadModule('api', 'Projects')->get_servers($id);

        return
            [
                "design" => "control_panel/project/info",
                "data"   => [
                    "info" => LoadModule('api','Projects')->info($id),
                    "servers" => $servers['servers']
            ]
        ];
    }

    protected function server_update($id)
    {
        $server = LoadModule('api','Servers')->info($id);
        $project = LoadModule('api', 'Projects')->info($server['info']['project']);
        LoadModule('api', 'Projects')->require_owner($server['info']['project']);
        return
        [
            "design" => "control_panel/server/update",
            "script" => ["libs/chosen.jquery", "libs/jquery.tagsinput"],
            "data"   =>
            [
                "info" => $server['info'],
                "project" => $project,
                "server_versions" => Core::get_db()->Query('select * from main.servers_versions')
            ]
        ];
    }

    protected function server_update_query($id)
    {
        $server = Core::get_db()->Query("select * from main.servers WHERE id=$1", [$id], true);;
        LoadModule('api', 'Projects')->require_owner($server->project);
        LoadModule('api', 'Servers')->update($id);
        return
            [
                "reset" => "/ControlPanel/project_info&id=$server->project",
            ];
    }

    protected function server_create($project, $mode)
    {
        LoadModule('api', 'Projects')->require_owner($project);
        phoxy_protected_assert($mode, [
            'error' => 'Ты че хочешь?'
        ]);

        Core::get_db()->Query("insert into main.servers (project) values ($1)", [$project]);
        return
            [
                "reset" => "/ControlPanel/project_info&id=$project",
            ];
    }

    protected function server_delete($id)
    {

    }

    protected function project_update($id)
    {
        LoadModule('api', 'Projects')->require_owner($id);
        return
        [
            "design" => "control_panel/project/update",
            "data"   => LoadModule('api','Projects')->info($id)
        ];
    }

    protected function project_update_query($id)
    {
        LoadModule('api', 'Projects')->require_owner($id);
        LoadModule('api', 'Projects')->update($id);
        return
            [
                "reset" => "/ControlPanel/project_info&id=$id",
            ];
    }

    protected function project_create($mode = null)
    {
        phoxy_protected_assert($mode, [
            'error' => 'Ты че хочешь?'
        ]);

        Core::get_db()->Query("insert into main.projects (owner) values ($1)", [LoadModule('api', 'Users')->uid()]);
        return
        [
            "reset" => '/ControlPanel',
        ];
    }

    protected function project_buttons($id)
    {
         return
            [
                "design" => "control_panel/project/buttons",
                "data"   =>
                [
                    "info" => LoadModule('api','Projects')->info($id),
                ],
            ];
    }

    protected function project_delete($id)
    {

    }

    protected function help_index()
    {
        return
        [
            "design" => "control_panel/help/index"
        ];
    }

    protected function help_page($id)
    {
        return
            [
                "design" => "control_panel/help/page"
            ];
    }
}