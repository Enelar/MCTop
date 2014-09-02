<?php

class Servers_render_class
{

    static function display_vk_button(Servers $server)
    {
        if (!empty($server->vkontakte_public))
            echo '<a target="_blank" href="http://vk.com/' . $server->vkontakte_public . '" class="btn btn-primary">Группа ВКонтакте</a>';
    }

    static function display_facebook_button(Servers $server)
    {
        if (!empty($server->facebook_public))
            echo '<a target="_blank" href="http://facebook.com/' . $server->facebook_public . '" class="btn btn-primary">Группа в Facebook</a>';
    }

    static function display_twitter_button(Servers $server)
    {
        if (!empty($server->twitter_account))
            echo '<a target="_blank" href="http://twitter.com/' . $server->twitter_account . '" class="btn btn-primary">Twitter</a>';
    }

    static function display_photo_gallery_button(Servers $server)
    {
        //todo
    }

}
