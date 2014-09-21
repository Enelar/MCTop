<h2><?php echo $project->name;?></h2>
Голосов: <?php echo $project->score;?><br>

<?php
    foreach ($project->servers as $server)
    {
        require ('_server_on_list_page.php');
    }
?>

<hr>