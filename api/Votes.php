<?php
Class Votes extends API
{
    protected function vote($server_id)
    {
        $servers = LoadModule('api', 'Servers');
        $server = $servers->info($server_id);

        $trans = db::Begin();

        phoxy_protected_assert($servers->is_server_subscriber($server->id), ["error" => "You should be subscribed to vote"]);
        phoxy_protected_assert($this->is_user_have_voted_today($server->project), ["error" => "You do not have votes today"]);

        $this->add_vote($server_id);
        return $trans->Commit();
    }

    private function add_vote($server_id)
    {
        $servers = LoadModule('api', 'Servers');
        $server = $servers->info($server_id);

        Core::get_db()->Query("
            update main.projects set score = score + 1 where id = $1;
            update main.servers set votes = votes + 1 where id = $2;", [$server->project, $server->id]);

        $last_vote = Core::$db->Query("insert into votes.main (server_id, user_id, time, project_id) values ($1, $2, now(), $3) RETURNING *",
          [$server->uid, LoadModule('api', 'Users')->uid(), $server->project]);
        global $_SERVER;
        Core::$db->Query("insert into votes.info (vote_id, ip, user_agent, country) values ($1, $2, $3, $4)",
          [$last_vote->id, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], 'RUSSIA']);
    }

    public function is_user_have_voted_today($project_id, $user_id = null)
    {
        if (!$user_id)
            $user_id = LoadModule('api', 'Users')->uid();

        $last_vote = 
            Core::get_db()->Query("
                select (now() - time < '1 day'::interval) as today
                    from votes.main
                    where project_id = $1
                      and user_id = $2
                    order by time desc
                    limit 1", [$project_id, $user_id], true);

        return isset($last_vote['today']) && $last_vote['today'] == 't';
    }

    protected function is_server_subscriber($id)
    {
        return 
        [
            'design' => 'rating/server/vote_info',
            'data' => [
                'id' => (int)$id,
                'is_server_subscriber' => LoadModule('api', 'Servers')->is_server_subscriber($id),
            ]
        ];
    }
}