<?php

class Achievements_api extends API
{

    public $id, $name, $description, $points, $time;

    function create()
    {
    }

    function delete()
    {
    }

    static function get($id = null)
    {
        if(!is_null($id) && is_null($_GET['id']))
            $_GET['id'] = $id;

        $result = Core::$db->Query("select * from main.achievements where id = $1", [$_GET['id']], true);

        if(!$result)
            return ['message' => 'Достижение не найдено'];

        $achievement = new Achievements_api();

            foreach ($result as $key => $value)
                $achievement->$key = $value;

        return $achievement;
    }

    static function get_for_user_profile($id)
    {
        $result = Core::$db->Query("select * from main.achievements where id = $1", [$id], true);

        $achievement = new Achievements_api();

        foreach ($result as $key => $value)
            $achievement->$key = $value;

        return $achievement;
    }

    static function give($user, $achievement_id)
    {
         if(Core::$redis_db->zScore('user:'.$user.':site_achievements', $achievement_id) != 0)
            return false;

        $achievement = Achievements_api::get($achievement_id);

        Core::$redis_db->zAdd('user:'.$user.':site_achievements', $achievement->points, $achievement_id);
        Core::$redis_db->hSet('user:'.$user.':site_achievements:'.$achievement_id, 'time', time());
    }

}