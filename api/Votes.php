<?php
Class Votes extends API
{
    static function is_user_have_voted_today($project_id, $user_id = null)
    {
        if(is_null($user_id))
            $user_id = $_GET['id'];

        $last_vote = Core::$db->Query("select * from votes.main where project_id = $1 and user_id = $2 order by time desc limit 1", [$project_id, $user_id], true);
        if(!$last_vote)
            return false;

        $day = date('d', strtotime($last_vote['time']));
        $today_day = date('d', time());

        if($day<$today_day)
        {
            //todo проверка на месяц голосования
            return false;
        }

        return true;
    }

    function recount_project_score()
    {

    }

    function is_needs_to_give_bonus(Servers $server)
    {
        return $server->give_bonus? true : false;
    }

    function give_bonus_for_vote (Servers $server, $nick)
    {
        //$server->bonus_script_url
        //$server->bonus_secret_word
    }
}