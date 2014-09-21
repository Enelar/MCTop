<?php
Class Votes extends API
{
    static function is_user_have_voted_today($project_id, $user_id = null)
    {
        if(is_null($user_id))
            $user_id = $_GET['id'];

        $last_vote = Core::$db->Query("select * from votes.main where project_id = $1 and user_id = $2", [$project_id, $user_id], true);
        if(!$last_vote)
            return false;


        return true;
    }

    function register_vote()
    {
        self::is_user_authorized_and_is_not_empty_post_request();

        if(self::is_user_have_voted_today($_POST['project_id']))
            return ['message' => 'user_already_has_voted_today'];

        $nickname = RatingServers::get_user_nickname_on_server($_POST['server_id']);
        $server = Servers::get_server($_POST['server_id']);
        $project = Projects::get_project($server->project);

        if($this->is_needs_to_give_bonus($server))
            $this->give_bonus_for_vote($server, $nickname);

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