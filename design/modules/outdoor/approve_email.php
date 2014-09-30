<?php
    if(Core::is_user_authorized())
    {
        $hash = Core::$db->Query('select * from users.email_approving where hash = $1 and user_id = $2', [$_GET['hash'], Core::get_current_user_profile()->id], true);
        if(sizeof($hash)>0 && is_array($hash))
        {
            Core::$db->Query('delete from users.email_approving where hash = $1 and user_id = $2', [$_GET['hash'], Core::get_current_user_profile()->id]);
            echo '<div class="alert alert-success" role="alert">Благодарим вам! <br><br> Email и голос был подтвержден</div>';
        }

    }
?>