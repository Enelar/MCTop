<script src="/js/_libs/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
            selector:'#test',
            language : 'ru',
            plugins : 'advlist autolink link image lists charmap print preview',
            rows: 15
        }
    );
</script>
<script src="/js/jquery.tagsinput.js"></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.tagsinput.css" />
<script>
    $('#tags').tagsInput(
        {
            'defaultText':'+',
            'width':'40%'
        }
    );
</script>

<?php $server = Servers::get_server($_GET['id']);?>

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
        <textarea id="test" name="description" type="text" class="form-control" placeholder="Описание"><?php echo $server->description;?></textarea>
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

    <?php
        $string = '';

        $tags = explode(':',$server->tags);
        foreach($tags as $tag)
            if(strlen($tag)>0)
                $string .= $tag.',';

    ?>
    <input name="tags" id="tags" value="<?php echo $string;?>" />

    <!--<div class="form-group">
        <span class="label label-default">New</span> <label>Плагины сервера</label>
        <input name="plugins" type="text" class="form-control" placeholder="Название плагинов" value="<?php echo $server->plugins;?>"/>
    </div>

    <div class="form-group">
        <span class="label label-default">New</span> <label>Моды сервера</label>
        <input name="mods" type="text" class="form-control" placeholder="Название модов" value="<?php echo $server->mods;?>"/>
    </div>

    <div class="form-group">
        <span class="label label-default">New</span> <label>Теги сервера</label>
        <input name="tags" type="text" class="form-control" placeholder="Теги для поиска" value="<?php echo $server->tags;?>"/>
    </div>-->


    <hr>

    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>

<div class="message"></div>