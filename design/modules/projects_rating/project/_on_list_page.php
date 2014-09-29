<div class="project">

    <div class="name"><?php echo $project->name;?></div>
    <div class="votes">Голосов: <?php echo $project->score;?></div>

    <?php
    foreach ($project->servers as $server)
    {
        require ('_server_on_list_page.php');
    }
    ?>
</div>