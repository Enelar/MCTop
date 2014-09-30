<h1><span class="glyphicon glyphicon-star"></span> Избранное </h1>

<?php
    $check = Core::$db->Query('select * from users.servers_favorite where user_id = $1', [Core::get_current_user_profile()->id]);
    if(sizeof($check)>0)
    {
        foreach ($check as $server)
        {
            $server = Servers::get_server($server['server_id']);
            echo '<a class="btn btn-primary" onclick="display_page_with_id(\'projects_rating\', \'project/server\', '.$server->id.')">'.htmlspecialchars($server->name).'</a><br>';
        }
    }

?>