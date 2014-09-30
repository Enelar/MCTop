<?php

class RatingServers extends API
{

    function vote()
    {
        API::is_user_authorized_and_is_not_empty_post_request();

        $server = Servers::get_server($_POST['server_id']);
        $nickname_info = Core::$db->Query("select * from main.servers_subscribers where user_id = $1 and server_id = $2", [Core::get_current_user_profile()->id, $_POST['server_id']], true);

        require('Votes.php');
        $votes = new Votes();

        $project = Projects::get_project($server->project);
        $votes_count = Core::$db->Query("select count(*) from votes.main where project_id = $1", [$project->id], true);
        $votes_count = $votes_count['count'];
        $votes_count++;

        Core::$db->Query("update main.projects set score = $1 where id = $2", [$votes_count, $project->id]);

        $votes_count = Core::$db->Query("select count(*) from votes.main where server_id = $1", [$server->id], true);
        $votes_count = $votes_count['count'];
        $votes_count++;
        Core::$db->Query("update main.servers set votes = $1 where id = $2", [$votes_count, $server->id]);
        if(!$votes->is_user_have_voted_today($server->project, Core::get_current_user_profile()->id))
        {
            $time = date('Y-m-d H:i:s', time());
            Core::$db->Query("insert into votes.main (server_id, user_id, time, project_id) values ($1, $2, $3, $4)", [$server->id, Core::get_current_user_profile()->id, $time, $server->project]);
            $last_vote = Core::$db->Query("select * from votes.main where project_id = $1 and user_id = $2 order by time desc limit 1", [$server->project, Core::get_current_user_profile()->id], true);
            Core::$db->Query("insert into votes.info (vote_id, ip, user_agent, country) values ($1, $2, $3, $4)", [$last_vote['id'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], 'RUSSIA']);
        }

        $votes_count = Core::$db->Query('select count (*) from votes.main where user_id = $1', [Core::get_current_user_profile()->id], true);

        if(!empty($project->secret_url) && !empty($project->secret_key))
        {
            if( $curl = curl_init() ) {
                curl_setopt($curl, CURLOPT_URL, $project->secret_url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "server_id={$_POST['server_id']}&nickname=".$nickname_info['nickname']."&token=".md5($project->secret_key));
                $out = curl_exec($curl);
                curl_close($curl);
            }
        }

        if($votes_count['count'] == 1)
            return [
                'message' => 'is_first_vote'
            ];

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

        if(strlen($nickname) == 0)
            Core::$db->Query('delete from main.servers_subscribers where user_id = $1 and server_id = $2', [Core::get_current_user_profile()->id, $server_id]);
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
