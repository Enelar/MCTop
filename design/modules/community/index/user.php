
<div class="contact" onclick="show_profile(<?php echo $user->id?>)">

    <div class="avatar">
        <img src="/static/ava.png"/>
    </div>

    <div class="availability_status <?php if(User::is_user_online($user->id)) echo 'status_in_vay'?>"></div>
    <div class="name"> <?php $user->display_nickname();?> <?php echo htmlspecialchars($user->name);?> <?php echo htmlspecialchars($user->lastname);?></div>
    <div class="status"> <?php echo $user->status;?> </div>
</div>
<hr>

