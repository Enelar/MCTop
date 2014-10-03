<?php

class Social extends api
{
    // перепишешь потом как нужно
    protected function InFavorite($server)
    {
        $uid = LoadModule('api', 'Users')->uid();
        $ret = Core::get_db()->Query('select * from users.servers_favorite where user_id = $1 and server_id = $2', [$uid, $server], true);
        return !!$ret;
    }

    protected function SetFavorite($server, $status = true)
    {
        // todo
    }
}