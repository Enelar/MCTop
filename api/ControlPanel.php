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
        $info = Core::get_db()->Query('select * from main.projects where owner = $1 and id = $2', [LoadModule('api', 'Users')->get_uid(), $id], true);
        $servers = LoadModule('api', 'Projects')->get_servers($id);

        return
            [
                "design" => "control_panel/project/info",
                "data"   => [
                    "info" => $info,
                    "servers" => $servers['servers']
            ]
        ];
    }

    protected function server_info($id)
    {
        $info = Core::get_db()->Query('select * from main.servers where id = $1', [$id], true);
        LoadModule('api', 'Projects')->require_owner($info->project);

        return
            [
                "design" => "control_panel/server/info",
                "data"   => [
                    "info" => $info,
                ]
            ];
    }

    protected function server_update($id)
    {
        return
        [
            "design" => "control_panel/server/update"
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
        return
        [
            "design" => "control_panel/project/update"
        ];
    }

    protected function project_create()
    {
        return
        [
            "design" => "control_panel/project/create"
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