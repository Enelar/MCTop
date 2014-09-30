<?php

class API
{

    public static function answer($object)
    {
        echo Core::json_encode_cyr($object);
        if(sizeof($_POST)>0)
            Core::log_post_request();
    }

    public static function check_for_post_request()
    {
        if (count($_POST) == 0) {
            self::answer(['message' => 'Empty post request']);
            die();
        }
    }

    public static function is_user_authorized_and_is_not_empty_post_request()
    {
        if (!Core::is_user_authorized())
            die();

        self::check_for_post_request();
    }

    public static function abort($object)
    {
        self::answer($object);
        die();
    }

}
