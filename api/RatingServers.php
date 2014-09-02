<?php

class RatingServers extends Api
{

    function vote()
    {
        global $core;

        Api::check_for_post_request();

        $server = Servers::get_server($_POST['server_id'], 'for_api');

        return [
            'message' => $server
        ];
    }

}
