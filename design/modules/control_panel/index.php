
    <?php $projects = Projects::get_user_projects(Core::get_current_user_profile()->id, 0, 100);?>

    <h1><span class="glyphicon glyphicon-plane"></span> Панель управления</h1><hr>

    <div class="control_panel">

        <a onclick="display_page('control_panel', 'projects/register')" class="btn btn-primary"> <span class="glyphicon glyphicon-folder-close"></span> Регистрация проекта</a>
        <a onclick="display_page('control_panel', 'servers/register')" class="btn btn-primary"> <span class="glyphicon glyphicon-th-large"></span> Регистрация сервера</a>
        <!--<a onclick="display_page('control_panel', 'site/register')" class="btn btn-primary"> <span class="glyphicon glyphicon-file"></span> Регистрация сайта</a>-->
        <a onclick="display_page('control_panel', 'help/index')" class="btn btn-primary"> <span class="glyphicon glyphicon-leaf"></span> Помощь по сайту</a>
        <!--<a onclick="display_page('control_panel', 'support/index')" class="btn btn-primary"> <span class="glyphicon glyphicon-envelope"></span> Online поддержка</a>-->
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