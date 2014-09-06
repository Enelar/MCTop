
    <?php $projects = Projects::get_projects_for_rating_page(0,10);?>

    <h1><span class="<?php echo Core::get_settings()->modules['projects_rating']->icon?>"></span> Рейтинг проектов <?php echo Core::get_settings()->application['game'];?></h1><hr>

    <div class="projects_rating">

        <?php
            foreach($projects as $key => $project)
            {
                require('project/_on_list_page.php');
            }
        ?>

    </div>