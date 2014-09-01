
<div class="club invite" onclick="display_page_with_id('social','clubs/body','<?php echo $invite_to_club['id']?>')">

    <div class="name">
        <?php if($invite_to_club->access_privacy == 'private_club') echo '<span class="glyphicon glyphicon-lock"></span> '?><?php echo $invite_to_club['name'];?>
    </div>

    <div class="btn_join">
        <a onclick="club_join('<?php echo $invite_to_club['id']?>','<?php echo Core::get_current_user_profile()->id?>')" class="btn-sm btn-primary">Присоединиться</a>
    </div>
</div>
