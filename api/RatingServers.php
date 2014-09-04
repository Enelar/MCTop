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

}
