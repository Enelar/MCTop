
    <?php $project = Projects::get_project($_GET['id']);?>

    <a onclick="server_create('<?php echo $project->id;?>', '<?php echo Core::get_current_user_profile()->id?>')" class="btn btn-lg btn-success">Добавить новый сервер в проект</a>