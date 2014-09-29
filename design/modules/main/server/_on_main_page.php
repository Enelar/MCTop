
    <div class="server">

        <div class="left_block">

            <div class="name">
                <a onclick="display_page_with_id('projects_rating','project/server', '<?php echo $server->id?>')"><?php echo $server->name?></a>
            </div>

            <div class="avatar">
                <a onclick="display_page_with_id('projects_rating','project', '<?php echo $server->id?>')">
                </a>
            </div>

        </div>

        <div class="right_block">

            <div class="score">
                Голосов: <?php echo $server->votes;?>
            </div>

        </div>

    </div>