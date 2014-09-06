
<?php $server = Servers::get_server($_GET['id']);?>

<ol class="breadcrumb">
    <li><a onclick="display_page('control_panel', 'index')">Контрольная панель</a></li>
    <li><a onclick="display_page_with_id('control_panel', 'projects/view', '<?php echo $server->project_info->id;?>')"><?php echo $server->project_info->name;?></a></li>
    <li class="active"><?php echo $server->name;?></li>
</ol>

<h1> Обновление сервера: <?php echo $server->name;?></h1> <hr>

<form method="POST" id="formx" action="javascript:void(null);" onsubmit="server_update('<?php echo $server->id?>', '<?php echo Core::get_current_user_profile()->id?>')">

    <div class="form-group">
        <label>Адрес сервера (ip или домен сайта [пример: s1.mctop.ru])</label>
        <input name="address" type="text" class="form-control" placeholder="Название" value="<?php echo $server->address;?>"/>
    </div>

    <div class="form-group">
        <label>Port сервера</label>
        <input name="port" type="text" class="form-control" placeholder="По умолчанию: 25565" value="<?php echo $server->port;?>"/>
    </div>

    <hr>

    <div class="form-group">
        <label>Название сервера</label>
        <input name="name" type="text" class="form-control" placeholder="Название" value="<?php echo $server->name;?>"/>
    </div>

    <div class="form-group">
        <label>Описание сервера</label>
        <textarea name="description" type="text" class="form-control" placeholder="Описание"><?php echo $server->description;?></textarea>
    </div>

    <hr>

    <div class="form-group">
        <span class="label label-default">New</span> <label>Преимущества сервера</label><br><br>
        <textarea name="features" type="text" class="form-control" placeholder="Преимущества"><?php echo $server->features;?></textarea>
    </div>

    <hr>

    <div class="form-group">
        <span class="label label-default">New</span> <label>Ссылка на карту сервера</label>
        <input name="map_url" type="text" class="form-control" placeholder="Карта сервера" value="<?php echo $server->map_url;?>"/>
    </div>

    <hr>
    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>

<div class="message"></div>