<?php

class RatingServers extends API
{

    function vote()
    {
        API::check_for_post_request();

        return [
            'message' => Servers::get_server($_POST['server_id'], 'for_api')
        ];
    }

    function subscribe()
    {
        API::is_user_authorized_and_is_not_empty_post_request();

        $nickname = $_POST['nickname'];
        $server_id = $_POST['server_id'];
        $check = Core::$db->Query("select * from main.servers_subscribers where user_id = $1 and server_id = $2", [Core::get_current_user_profile()->id, $server_id]);

        if(!$check)
        {
            Core::$db->Query("INSERT INTO main.servers_subscribers(server_id, user_id, nickname) VALUES ($1, $2, $3)", [$server_id, Core::get_current_user_profile()->id, $nickname]);
            return ['message' => 'success'];
        }

        return ['message' => 'fail'];
    }

    function subscriber_change_nickname()
    {
        API::is_user_authorized_and_is_not_empty_post_request();

        $nickname = $_POST['nickname'];
        $server_id = $_POST['server_id'];
        $check = Core::$db->Query("select * from main.servers_subscribers where user_id = $1 and server_id = $2", [Core::get_current_user_profile()->id, $server_id]);

        if($check)
        {
            Core::$db->Query("UPDATE main.servers_subscribers set nickname = $1 where server_id = $2 and user_id = $3", [$nickname, $server_id, Core::get_current_user_profile()->id]);
            return ['message' => 'success'];
        }

        return ['message' => 'fail'];
    }

    static function is_server_subscriber($server_id, $user_id = null)
    {
        if(is_null($user_id))
            $user_id = Core::get_current_user_profile()->id;

        $check = Core::$db->Query("select * from main.servers_subscribers where user_id = $1 and server_id = $2", [$user_id, $server_id]);
        if(sizeof($check) == 0 && is_array($check))
            return 0;
        else
            return new Object($check[0]);
    }

    static function get_user_nickname_on_server($server_id, $user = null)
    {
        if(is_null($user))
            $user = Core::get_current_user_profile()->id;

        return Core::$db->Query("select nickname from main.servers_subscribers where user_id = $1 and server_id = $2", [$user, $server_id]);
    }


}
