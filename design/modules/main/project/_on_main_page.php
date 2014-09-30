
<div class="project">

    <div class="left_block">

        <div class="position">
            1
        </div>

        <div class="name">
            <a onclick="display_page_with_id('main','project', '<?php echo $project->id?>')"><?php echo htmlspecialchars($project->name)?></a>
        </div>

        <div class="avatar">
            <a onclick="display_page_with_id('main','project', '<?php echo $server->id?>')">
                <img src="<?php echo $project->avatar;?>"/>
            </a>
        </div>

    </div>

    <div class="right_block">

        <div class="score">
            Престиж: <?php echo $project->score?>
        </div>

        <div class="vote">
            <a onclick="vote_for_project('+', '<?php echo $project->id;?>')" class="btn btn-default"><span class="glyphicon glyphicon-thumbs-up"></span> </a>
            <a onclick="vote_for_project('-', '<?php echo $project->id;?>')" class="btn btn-default"><span class="glyphicon glyphicon-thumbs-down"></span></a>
        </div>

    </div>

</div>