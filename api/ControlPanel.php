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
        $project = LoadModule('api', 'Projects')->info($server->project);
        LoadModule('api', 'Projects')->require_owner($server->project);
        return
        [
            "design" => "control_panel/server/update",
            "scripts" => ["chosen.jquery", "jquery.tagsinput"],
            "data"   =>
            [
                "info" => $server,
                "project" => $project,
                "server_versions" => Core::get_db()->Query('select * from main.servers_versions')
            ]
        ];
    }

    protected function server_create($project)
    {
        return
        [
            "design" => "control_panel/server/create"
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

    protected function project_create()
    {
        return
        [
            "design" => "control_panel/project/create"
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