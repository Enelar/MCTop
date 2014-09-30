<?php $project = Projects::get_project($_GET['id'])?>

<h1><span class="glyphicon glyphicon-star"></span> Голосование за проект <?php echo $project->name;?></h1>
<hr>
<?php

    foreach ($project->servers as $server)
    {
        echo '<p><a class="btn btn-success" onclick="display_page_with_id(\'projects_rating\', \'project/server\', '.$server->id.')"> Перейти на страницу сервера '.$server->name.'</a> </p>';
    }
?>