<?php
Class Votes extends API
{
    protected function vote($server_id)
    {
        $servers = LoadModule('api', 'Servers');
        $server = $servers->info($server_id);

        $trans = Core::get_db()->Begin();

        phoxy_protected_assert($servers->is_server_subscriber($server->id), ["error" => "You should be subscribed to vote"]);
        phoxy_protected_assert(!$this->is_user_have_voted_today($server->id), ["error" => "You do not have votes today"]);

        $this->add_vote($server_id);
        return $trans->Commit();
    }

    private function add_vote($server_id)
    {
        $servers = LoadModule('api', 'Servers');
        $server = $servers->info($server_id);

        $trans = Core::get_db()->Begin();

        Core::get_db()->Query("update main.projects set score = score + 1 where id = $1", [$server->project]);
        Core::get_db()->Query("update main.servers set votes = votes + 1 where id = $1", [$server->id]);

        $last_vote = Core::get_db()->Query("insert into votes.main (server_id, user_id, time, project_id) values ($1, $2, now(), $3) RETURNING *",
          [$server->id, LoadModule('api', 'Users')->uid(), $server->project], true);

        global $_SERVER;
        Core::get_db()->Query("insert into votes.info (vote_id, ip, user_agent, country) values ($1, $2, $3, $4)",
          [$last_vote->id, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], 'RUSSIA']);

        $trans->Commit();
    }

    protected function is_user_have_voted_today($server_id, $user_id = null)
    {
        if (!$user_id)
            $user_id = LoadModule('api', 'Users')->uid();

        $server = LoadModule('api', 'Servers')->info($server_id);
        $project = LoadModule('api', 'Projects')->info($server->project);

        $last_vote = 
            Core::get_db()->Query("
                select (now() - time < '1 day'::interval) as today
                    from votes.main
                    where project_id = $1
                      and user_id = $2
                    order by time desc
                    limit 1", [$project->id, $user_id], true);

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
                'have_vote' => $this->is_user_have_voted_today($id),
            ]
        ];
    }
}