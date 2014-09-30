<?php $server = Servers::get_server($_GET['id'])?>
<?php $server_version = Core::$db->Query('select * from main.servers_versions where id = $1', [$server->version_id], true);?>
<h1>
    <span class="glyphicon glyphicon-align-justify"></span> Сервер <?php echo htmlspecialchars($server->name);?>
    <div class="btn_favorite">
        <a class="btn-sm btn btn-success" onclick="add_server_to_favorite(<?php echo $server->id?>)">
            <?php
            $check = Core::$db->Query('select * from users.servers_favorite where user_id = $1 and server_id = $2', [Core::get_current_user_profile()->id, $server->id], true);

            if(sizeof($check)>0 and is_array($check))
                echo 'Удалить из избранного';
            else
                echo 'В избранное';
            ?>
        </a>
    </div>
</h1>
<hr>
<p><?php echo htmlspecialchars($server->description);?></p><hr>


<div class="full_server">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#home" role="tab" data-toggle="tab">Основные сведения</a></li>
        <li><a href="#features" role="tab" data-toggle="tab">Преимущества</a></li>
        <?php
        if(!empty($server->map_url)):
        ?>
        <li><a href="#map" role="tab" data-toggle="tab">Карта сервера</a></li>
        <?php endif;?>
        <?php
        if(!empty($server->video_trailer_url)):
            ?>
            <li><a href="#trailer" role="tab" data-toggle="tab">Трейлер сервера</a></li>
        <?php endif;?>

        <!--<li><a href="#gallery" role="tab" data-toggle="tab">Галерея сервера</a></li>-->
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="home">
            <br>

            <a target="_blank" href="<?php echo htmlspecialchars($server->project_info->site_url)?>" class="btn btn-primary">Сайт проекта</a><hr>
            <?php
            $only_tags = [];

            $tags = explode(':',$server->tags);

            foreach($tags as $tag)
                if(strlen($tag) != 0 & $tag != ' ')
                    $only_tags[] = $tag;

            ?>
            <p>Адрес сервера: <kbd><?php echo $server->address.':'.$server->port;?></kbd></p>
            <p>Версия игры: <kbd><?php echo $server_version['name'];?></kbd></p>

            <p>Наличие Whitelist: <kbd><?php echo $server->whitelist == 't'? 'Включен' : 'Выключен';?></kbd></p>
            <p>Доступ на сервер: <kbd><?php echo $server->license_type == 1? 'Только с лицензионным клиентом' : 'Лицензия + не лицензия';?></kbd></p>

            <p>
                Вход на сервер: <kbd>
                <?php
                    if($server->client_type == 1)
                        echo 'Только с лицензионным клиентом';

                    if($server->client_type == 2)
                        echo 'Свой лаунчер';

                    if($server->client_type == 3)
                        echo 'Любой лаунчер';
                ?></kbd>
            </p>
            <?php Servers_render_class::display_photo_gallery_button($server);?>
            <?php Servers_render_class::display_vk_button($server);?>
            <?php Servers_render_class::display_facebook_button($server);?>
            <?php Servers_render_class::display_twitter_button($server);?>
            <hr>

            <?php if(sizeof($only_tags)>0):?>
                <div class="tags">
                    Теги: <?php foreach ($only_tags as $tag) echo '<span class="label label-primary">'.$tag.'</span> ';?>
                </div>
            <?php endif;?>

            <?php if(Core::is_user_authorized()):?>
                <?php if(! $subscribe = RatingServers::is_server_subscriber($server->id)):?>
                    <a class="btn btn-primary" onclick="display_page_with_id('projects_rating', 'project/server_subscribe', '<?php echo $server->id;?>')">Для голосования за сервере тебе нужно @Подписаться_на_сервер</a>
                <?php else:?>
                    Вы сохранили ник <a onclick="display_page_with_id('projects_rating', 'project/server_subscribe_change_nick', '<?php echo $server->id?>')"><?php echo htmlspecialchars($subscribe->nickname);?></a> на сервере
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
        <?php
            if(!empty($server->map_url)):
        ?>
        <div class="tab-pane" id="map"><iframe class="dynmap" src="<?php echo htmlspecialchars($server->map_url)?>"></iframe></div>
        <?php
            endif;
        ?>
        <div class="tab-pane" id="features"><br><?php echo htmlspecialchars($server->features);?></div>
        <div class="tab-pane" id="trailer">
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="//www.youtube.com/embed/<?php echo htmlspecialchars($server->video_trailer_url)?>"></iframe>
            </div>
        </div>
    </div>



</div>
