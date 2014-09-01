
    <div id="member_<?php echo $user->id?>" onclick="show_profile('<?php echo $user->id?>')">
        <div class="user">

            <div class="avatar">
                <img src="/static/ava.png"/>
            </div>

            <div class="name"> <?php echo $user->name;?> <?php echo $user->lastname;?></div>
            <div class="status"> <?php echo $user->status;?> </div>

            <?php if($club->owner == $user->id):?>
                <div class="member_rang">
                    <span class="label label-primary"> Основатель клуба </span>
                </div>
            <?php endif;?>

        </div>
        <hr>
    </div>

    <?php if($club->owner == Core::get_current_user_profile()->id and $club->owner != $user->id) :?>
        <div class="delete_are_button" id="delete_are_button_<?php echo $user->id?>">
            <br>
            <a class="btn_<?php echo $user->id;?> btn btn-danger" onclick="club_dismember('<?php echo $user->id;?>','<?php echo $club->id?>','<?php echo Core::get_current_user_profile()->id?>')">Выгнать из клуба</a>
            <div class = "message_<?php echo $user->id;?>"></div>
        </div>
    <?php endif;?>





