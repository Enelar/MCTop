
    <div class="user">

        <div class="avatar">
            <img src="/static/ava.png"/>
        </div>

        <div class="name"> <?php echo $user->name;?> <?php echo $user->lastname;?></div>
        <div class="status"> <?php echo $user->status;?> </div>


    </div>
    <br>
    <a class="btn_<?php echo $user->id;?> btn btn-primary" onclick="club_invite('<?php echo $club->id;?>','<?php echo $user->id?>','<?php echo Core::get_current_user_profile()->id?>')">Пригласить в клуб</a>
    <div class = "message_<?php echo $user->id;?>"></div>
    <hr>


