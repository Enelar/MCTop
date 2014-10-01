<?php

class Reputation extends API
{
    public $user, $type, $from, $description, $time;

    static function get_user_reputation_score ($user)
    {
        $pluses = Core::$redis_db->hGet('user:'.$user.':reputation:stats', 'pluses');
        $minuses = Core::$redis_db->hGet('user:'.$user.':reputation:stats', 'minuses');
        $reputation = $pluses+$minuses;

        if(!$reputation)
            $reputation = 0;

        return $reputation;
    }

    static function get_user_reputation_history ($id)
    {
        if($id == null)
            $id = Core::get_current_user_profile()->id;

        $count = Core::$redis_db->zSize('user:'.$id.':reputation');
        if($count == 0)
            return 0;

        $marks_ids = Core::$redis_db->zRange('user:'.$id.':reputation', 0, -1, false);
        $marks = [];

        $idle_mark = new Reputation_api();

        foreach($marks_ids as $key => $mark_id)
        {
            $mark = Core::$redis_db->hGetAll('user:'.$id.':reputation:'.$mark_id);
            foreach ($mark as $key => $value)
                $idle_mark->$key = $value;

            $idle_mark->user = $id;
            $idle_mark->from = $mark_id;

            $marks[] = $idle_mark;
        }

        return $marks;

    }

    static function add_plus_to_user_reputation($user = null, $from = null, $description = null)
    {

        if(is_null($user) && is_null($from) && is_null($description))
        {
            $user = $_POST['to'];
            $from = $_POST['from'];
            $description = $_POST['description'];
        }

        if(Core::$redis_db->zScore('user:'.$user.':reputation', $from) != 0)
            return false;

        $id = Core::$redis_db->zSize('user:'.$user.':reputation')+1;
        $pluses_count = Core::$redis_db->hGet('user:'.$user.':reputation:stats', 'pluses');
        Core::$redis_db->hSet('user:'.$user.':reputation:stats', 'pluses', $pluses_count+1);

        Core::$redis_db->zAdd('user:'.$user.':reputation', $id, $from);
        Core::$redis_db->hSet('user:'.$user.':reputation:'.$from, 'time', time());
        Core::$redis_db->hSet('user:'.$user.':reputation:'.$from, 'description', $description);
        Core::$redis_db->hSet('user:'.$user.':reputation:'.$from, 'type', 'plus');
        return ['message' => 'success'];
    }

    static function add_minus_to_user_reputation($user, $from, $description)
    {

        if(is_null($user) && is_null($from) && is_null($description))
        {
            $user = $_POST['to'];
            $from = $_POST['from'];
            $description = $_POST['description'];
        }

        if(Core::$redis_db->zScore('user:'.$user.':reputation', $from) != 0)
            return false;

        $id = Core::$redis_db->zSize('user:'.$user.':reputation')+1;
        $minuses_count = Core::$redis_db->hGet('user:'.$user.':reputation:stats', 'minuses');
        Core::$redis_db->hSet('user:'.$user.':reputation:stats', 'minuses', $minuses_count+1);

        Core::$redis_db->zAdd('user:'.$user.':reputation', $id, $from);
        Core::$redis_db->hSet('user:'.$user.':reputation:'.$from, 'time', time());
        Core::$redis_db->hSet('user:'.$user.':reputation:'.$from, 'description', $description);
        Core::$redis_db->hSet('user:'.$user.':reputation:'.$from, 'type', 'minuse');
        return ['message' => 'success'];
    }

    static function can_change_user_reputation($user, $to)
    {
        if(Core::$redis_db->zScore('user:'.$to.':reputation', $user) != 0)
            return false;
    }

}