
    <?php $project = Projects::get_project($_GET['id']);?>

    <ol class="breadcrumb">
        <li>
            <a onclick="display_page('control_panel', 'index')">Панель управления</a>
        </li>
        <li>
            <a onclick="display_page_with_id('control_panel', 'projects/view', <?php echo $project->id?>)">Проект <?php echo $project->name?></a>
        </li>
        <li class="active">
            Добавление сервера в проект
        </li>
    </ol>

    <a onclick="server_create('<?php echo $project->id;?>', '<?php echo Core::get_current_user_profile()->id?>')" class="btn btn-lg btn-success">Добавить новый сервер в проект</a>