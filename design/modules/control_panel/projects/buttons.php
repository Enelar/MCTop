    <?php $project = Projects::get_project($_GET['id']);?>

    <h1>Кнопки для проекта</h1><hr>

    <ol class="breadcrumb">
        <li>
            <a onclick="display_page('control_panel', 'index')">Панель управления</a>
        </li>
        <li>
            <a onclick="display_page_with_id('control_panel', 'projects/view', <?php echo $project->id?>)">Проект <?php echo $project->name?></a>
        </li>
        <li class="active">
            Кнопки для проекта
        </li>
    </ol>

    <form role="form">
        <?php
            for($i=1; $i<=10; $i++)
                require('buttons/small_banner.php');
        ?>
    </form>