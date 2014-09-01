
    <?php $projects = Projects::get_user_projects(Core::get_current_user_profile()->id, 0, 100);?>

    <h1><span class="glyphicon glyphicon-plane"></span> Контрольная панель</h1><hr>

    <div class="control_panel">

        <a onclick="display_page('control_panel', 'projects/register')" class="btn btn-primary">Регистрация проекта</a>
        <a onclick="display_page('control_panel', 'servers/register')" class="btn btn-primary">Регистрация сервера</a>
        <a onclick="display_page('control_panel', 'site/register')" class="btn btn-primary">Регистрация сайта</a>
        <hr>

        <div class="projects">
            <h1>Проекты</h1><hr>

            <?php if(sizeof(($projects)>0)):?>

                <?php
                    foreach($projects as $project)
                        require('index/project.php');
                ?>

            <?php endif;?>
        </div>

    </div>