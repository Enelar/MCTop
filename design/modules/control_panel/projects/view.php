<?php $project = Projects::get_project($_GET['id'])?>

<ol class="breadcrumb">
    <li>
        <a onclick="display_page('control_panel', 'index')">Панель управления</a>
    </li>
    <li class="active">
        Проект <?php echo $project->name?>
    </li>
</ol>


    <div class="control_panel">
        <h1><?php echo $project->name;?></h1><hr>

        <div class="projects">

            <div class="project">

                <div class="name">
                    <span class = "glyphicon glyphicon-folder-close"></span> <?php echo $project->name?>
                </div>

                <a onclick="display_page_with_id('control_panel', 'projects/update', '<?php echo $project->id?>')" class="btn btn-primary">Обновить сведения</a>
                <?php if(!empty($project->secret_key) && !empty($project->secret_url)):?>
                    <a href="/mctb.php" target="_blank">Скрипт для выдачи бонуса</a>
                <?php endif;?>
                <a onclick="display_page_with_id('control_panel', 'projects/buttons', '<?php echo $project->id?>')" class="btn btn-primary">Кнопки для проекта</a>
                <a onclick="display_page_with_id('control_panel', 'servers/create', '<?php echo $project->id?>')" class="btn btn-success">Добавить сервер</a>


                <div class="servers">
                    <?php
                    if(sizeof($project->servers>0))
                        foreach($project->servers as $server)
                            require('project_server.php');
                    ?>
                </div>

            </div>

        </div>

    </div>
