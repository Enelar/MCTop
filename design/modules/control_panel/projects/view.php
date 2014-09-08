
<?php $project = Projects::get_project($_GET['id'])?>

    <div class="control_panel">
        <h1><?php echo $project->name;?></h1><hr>

        <div class="projects">

            <div class="project">

                <div class="name">
                    <span class = "glyphicon glyphicon-folder-close"></span> <?php echo $project->name?>
                </div>

                <a onclick="display_page_with_id('control_panel', 'projects/update', '<?php echo $project->id?>')" class="btn btn-primary">Обновить сведения</a>
                <a onclick="display_page_with_id('control_panel', 'projects/access_settings', '<?php echo $project->id?>')" class="btn btn-primary">Настройки доступа</a>
                <a onclick="display_page_with_id('control_panel', 'projects/buttons', '<?php echo $project->id?>')" class="btn btn-primary">Кнопки для проекта</a>
                <a onclick="display_page_with_id('control_panel', 'servers/create', '<?php echo $project->id?>')" class="btn btn-success">Добавить сервер</a>
                <a onclick="display_page_with_id('control_panel', 'projects/remove', '<?php echo $project->id?>')" class="btn btn-primary">Удаление проекта</a>


                <div class="servers">
                    <?php
                    if(sizeof($project->servers>0))
                        foreach($project->servers as $server)
                            require('/../index/project_server.php');
                    ?>
                </div>

            </div>

        </div>

    </div>
