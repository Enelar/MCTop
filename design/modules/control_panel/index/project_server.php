
    <div class="server">

        <div class="name">
            Server: <?php echo $server->name;?>
        </div>

        <?php $server->map_url()?>
        <?php $server->address()?>

        <a onclick="display_page_with_id('control_panel', 'servers/update', '<?php echo $server->id?>')" class="btn btn-primary">Обновить сведения</a>
        <a onclick="display_page_with_id('control_panel', 'servers/gallery', '<?php echo $server->id?>')" class="btn btn-success">Галерея сервера</a>
        <a onclick="display_page_with_id('control_panel', 'servers/remove', '<?php echo $server->id?>')" class="btn btn-primary">Удаление</a>

    </div>