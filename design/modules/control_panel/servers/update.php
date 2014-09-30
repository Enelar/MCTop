
<?php $server = Servers::get_server($_GET['id']);?>

<ol class="breadcrumb">
    <li>
        <a onclick="display_page('control_panel', 'index')">Панель управления</a>
    </li>
    <li>
        <a onclick="display_page_with_id('control_panel', 'projects/view', <?php echo $server->project_info->id?>)">Проект <?php echo $server->project_info->name?></a>
    </li>
    <li class="active">
        Обновление сведений о сервере <?php echo $server->name;?>
    </li>
</ol>


<script src="/js/chosen.jquery.js"></script>
<link type="text/css" rel="stylesheet" href="/css/chosen.css"/>
<script src="/js/_libs/tinymce/tinymce.min.js"></script>

<script>
    tinymce.init({
            selector:'#description',
            language : 'ru',
            plugins : 'advlist autolink link image lists charmap print preview',
            rows: 15
        }
    );

    tinymce.init({
            selector:'#features',
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

<h1> Обновление сервера: <?php echo $server->name;?></h1> <hr>

<form method="POST" id="formx" action="javascript:void(null);" onsubmit="server_update('<?php echo $server->id?>', '<?php echo Core::get_current_user_profile()->id?>')">

    <div class="form-group">
        <label>Адрес сервера (ip или домен сайта [пример: s1.mctop.su])</label>
        <input name="address" type="text" class="form-control" placeholder="Название" value="<?php echo $server->address;?>"/>
    </div>

    <div class="form-group">
        <label>Port сервера</label>
        <input name="port" type="text" class="form-control" placeholder="По умолчанию: 25565" value="<?php echo $server->port;?>"/>
    </div>
    <hr>

    <div class="form-group">
        <p><label>Версия игры</label></p>
        <select id="version_id" name="version_id" data-placeholder="Версия игры..." class="chosen-select" style="width:350px;" tabindex="2">
            <option value=""></option>
            <?php
            $servers_versions = Core::$db->Query('select * from main.servers_versions');
            foreach ($servers_versions as $version)
            {
                if($server->version_id == $version['id'])
                    echo '<option selected value="'.$version['id'].'">'.$version['name'].'</option>';
                else
                    echo '<option value="'.$version['id'].'">'.$version['name'].'</option>';
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <p><label>Whitelist</label></p>
        <select id="whitelist" name="whitelist" data-placeholder="Наличие Whitelist" class="chosen-select" style="width:350px;" tabindex="2">
            <option value=""></option>
            <option <?php if ($server->whitelist == 1) echo 'selected'?> value="1">Включен</option>
            <option <?php if ($server->whitelist == 0) echo 'selected'?> value="0">Выключен</option>
        </select>
    </div>

    <div class="form-group">
        <p><label>Тип доступа</label></p>
        <select id="license" name="license" data-placeholder="Тип доступа..." class="chosen-select" style="width:350px;" tabindex="2">
            <option value=""></option>
            <option <?php if ($server->license_type == 1) echo 'selected'?> value="1">Только с лицензионным клиентом</option>
            <option <?php if ($server->license_type == 0) echo 'selected'?> value="0">Лицензия + не лицензия</option>
        </select>
    </div>

    <div class="form-group">
        <p><label>Вход на сервер</label></p>
        <select id="client_type" name="client_type" data-placeholder="Тип доступа..." class="chosen-select" style="width:350px;" tabindex="2">
            <option value=""></option>
            <option <?php if ($server->client_type == 1) echo 'selected'?> value="1">Только с лицензионным клиентом</option>
            <option <?php if ($server->client_type == 2) echo 'selected'?> value="2">У моего проекта свой лаунчер</option>
            <option <?php if ($server->client_type == 3) echo 'selected'?> value="3">Любой лаунчер</option>
        </select>
    </div>

    <hr>

    <div class="form-group">
        <label>Название сервера</label>
        <input name="name" type="text" class="form-control" placeholder="Название" value="<?php echo $server->name;?>"/>
    </div>

    <div class="form-group">
        <label>Описание сервера</label>
        <textarea id="description" name="description" type="text" class="form-control" placeholder="Описание"><?php echo $server->description;?></textarea>
    </div>

    <hr>

    <div class="form-group">
        <span class="label label-default">New</span> <label>Преимущества сервера</label><br><br>
        <textarea id="features" name="features" type="text" class="form-control" placeholder="Преимущества"><?php echo $server->features;?></textarea>
    </div>

    <hr>

    <div class="form-group">
        <span class="label label-default">New</span> <label>Ссылка на карту сервера</label>
        <input name="map_url" type="text" class="form-control" placeholder="Карта сервера" value="<?php echo $server->map_url;?>"/>
    </div>

    <div class="form-group">
        <span class="label label-default">New</span> <label>Трейлер сервера. Id видео в YouTube (http://www.youtube.com/watch?v=JkxaA9Mif7c - после знака = id видео)</label>
        <input name="video_trailer_url" type="text" class="form-control" placeholder="ID видео" value="<?php echo $server->video_trailer_url;?>"/>
    </div>


    <hr>

    <?php
        $string = '';

        $tags = explode(':',$server->tags);
        foreach($tags as $tag)
            if(strlen($tag)>0)
                $string .= $tag.',';

    ?>

    <label>Теги сервера (после ввода каждого - Enter)</label>
    <input name="tags" id="tags" value="<?php echo $string;?>" />

    <hr>

    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>

<div class="message"></div>

<script type="text/javascript">
    var config = {
        '.chosen-select'           : {},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Упс, ничего не найдено'},
        '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>