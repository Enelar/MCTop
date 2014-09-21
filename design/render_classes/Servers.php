<?php

class Servers_render_class
{

    static function display_vk_button(Servers $server)
    {
        $project = Projects::get_project($server->project);
        if (!empty($project->vk_group))
            echo '<a target="_blank" href="http://vk.com/' . $project->vk_group . '" class="btn btn-primary">Группа проекта ВКонтакте</a>';
    }

    static function display_facebook_button(Servers $server)
    {
        $project = Projects::get_project($server->project);
        if (!empty($project->fb_public))
            echo '<a target="_blank" href="http://facebook.com/' . $project->fb_public . '" class="btn btn-primary">Группа проекта в Facebook</a>';
    }

    static function display_twitter_button(Servers $server)
    {
        $project = Projects::get_project($server->project);
        if (!empty($project->twitter_account))
            echo '<a target="_blank" href="http://twitter.com/' . $project->twitter_account . '" class="btn btn-primary">Аккаунт проекта в Twitter</a>';
    }

    static function display_photo_gallery_button(Servers $server)
    {
        //todo
    }

}
