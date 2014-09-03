<?php

class RatingServers extends API
{

    function vote()
    {
        global $core;

        API::check_for_post_request();

        $server = Servers::get_server($_POST['server_id'], 'for_api');

        return [
            'message' => $server
        ];
    }

}
