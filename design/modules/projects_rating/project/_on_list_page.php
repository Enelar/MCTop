<h2>Project: <?php echo $project->name;?></h2><br>
Description: <?php echo $project->name;?><br>
Owner: <?php echo $project->owner;?><br>
Servers:<br>
<?php
    foreach ($project->servers as $server)
    {
        require ('_server_on_list_page.php');
    }
?>

<hr>