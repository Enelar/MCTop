<?php

class Contacts extends API
{

    function remove()
    {
        API::is_user_authorized_and_is_not_empty_post_request();

        $result = Core::$redis_db->sRem('user:' . $_POST['from'] . ':contacts:ids', $_POST['who_wants_to_remove']);

        return [
            'message' => $result == 1 ? 'success' : 'fail'
        ];
    }

    function add()
    {
        API::is_user_authorized_and_is_not_empty_post_request();

        $result = Core::$redis_db->sAdd('user:' . $_POST['from'] . ':contacts:ids', $_POST['who_wants_to_add']);

        return [
            'message' => $result == 1 ? 'success' : 'fail'
        ];
    }


}
