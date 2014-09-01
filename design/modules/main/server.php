
    <?php $server = Servers::get_server($_GET['id']);?>

    <h1><span class="glyphicon glyphicon-align-justify"></span> Сервер <?php echo $server->name;?></h1><hr>
    <p>Описание: <?php echo $server->description;?></p><hr>

    <?php Servers_render_class::display_photo_gallery_button($server);?>
    <?php Servers_render_class::display_vk_button($server);?>
    <?php Servers_render_class::display_facebook_button($server);?>
    <?php Servers_render_class::display_twitter_button($server);?>