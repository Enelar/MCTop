<?php

class Forum_render_class
{
    static function get_site_team()
    {
        $site_team_array = Users::get_site_team_users();

        $site_team_to_render = [];

        foreach($site_team_array as $member)
        {
            $member_object = new Object(
                [
                    'user' => User::get_user_info($member['user_id']),
                    'post' => $member['post'],
                ]
            );
            $site_team_to_render[] = $member_object;
        }

        return $site_team_to_render;

    }
}