<?php $server = Servers::get_server($_GET['id'])?>

<h1><?php echo $server->name;?></h1><hr>

<?php if(! $subscribe = RatingServers::is_server_subscriber($server->id)):?>
    <a class="btn btn-primary" onclick="display_page_with_id('projects_rating', 'project/server_subscribe', '<?php echo $server->id;?>')">Для голосования за сервере тебе нужно @Подписаться_на_сервер</a>
<?php else:?>
    Вы подписаны на сервер как <a onclick="display_page_with_id('projects_rating', 'project/server_subscribe_change_nick', '<?php echo $server->id?>')"><?php echo $subscribe->nickname;?></a>
<?php endif?>
