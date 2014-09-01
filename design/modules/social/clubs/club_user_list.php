
    <div class="club" onclick="display_page_with_id('social','clubs/body','<?php echo $club->id?>')">

        <div class="name">
            <?php if($club->access_privacy == 'private_club') echo '<span class="glyphicon glyphicon-lock"></span> '?><?php echo $club->name;?>
        </div>

        <div class="description">
            <?php echo $club->description;?>
        </div>

    </div>