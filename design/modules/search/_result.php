<?php $server_version = Core::$db->Query('select * from main.servers_versions where id = $1', [$server->version_id], true);?>

<!-- Modal -->
<div class="modal fade" id="server_<?php echo $server->id?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $server->name?></h4>
            </div>
            <div class="modal-body">
                <div id="test_<?php echo $server->id;?>"></div>

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
            </div>
            <div class="modal-footer">
                <button type="button" onclick="display_page_with_id('projects_rating', 'project/server', '<?php echo $server->id;?>')" class="btn btn-success" data-dismiss="modal">Перейти на страницу сервера</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
<a class="btn btn-default"  data-toggle="modal" data-target="#server_<?php echo $server->id?>"><?php echo $server->name;?> </a> <kbd>Голосов: <?php echo $server->votes;?></kbd>
<br><br>
<?php
    $only_tags = [];

    $server_tags = explode(':',$server->tags);

    foreach($server_tags as $tag)
        if(strlen($tag) != 0 & $tag != ' ')
            $only_tags[] = $tag;

    foreach ($only_tags as $tag)
    {
        if(in_array($tag, $tags))
            echo '<a class="btn-xs btn btn-primary">'.$tag.'</a> ';
        else
            echo '<a class="btn-xs btn btn-default">'.$tag.'</a> ';
    }
?>

<hr>