<div class="full_server">
    <?php $server = Servers::get_server($_GET['id'])?>
    <?php
    $only_tags = [];

    $tags = explode(':',$server->tags);

    foreach($tags as $tag)
        if(strlen($tag) != 0 & $tag != ' ')
            $only_tags[] = $tag;

    ?>
    <h1><?php echo $server->name;?></h1><hr>
    <div class="tags">
        Теги: <?php foreach ($only_tags as $tag) echo '<span class="label label-primary">'.$tag.'</span> ';?>
    </div>

    <?php if(Core::is_user_authorized()):?>
        <?php if(! $subscribe = RatingServers::is_server_subscriber($server->id)):?>
            <a class="btn btn-primary" onclick="display_page_with_id('projects_rating', 'project/server_subscribe', '<?php echo $server->id;?>')">Для голосования за сервере тебе нужно @Подписаться_на_сервер</a>
        <?php else:?>
            Вы подписаны на сервер как <a onclick="display_page_with_id('projects_rating', 'project/server_subscribe_change_nick', '<?php echo $server->id?>')"><?php echo $subscribe->nickname;?></a>
            <hr>
            <?php
            if(Votes::is_user_have_voted_today($server->project, Core::get_current_user_profile()->id))
                echo 'Вы уже голосовали сегодня за сервера этого проекта';
            else
                echo '<a class="btn btn-primary" onclick="display_page_with_id(\'projects_rating\', \'vote\', \''.$server->id.'\')">Голосовать за сервер</a>';
            ;?>
        <?php endif?>
    <?php endif?>

</div>