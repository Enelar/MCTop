
    <?php $user = User::get_user_info($_GET['id']);?>
    <h1><span class="glyphicon glyphicon-adjust"></span> Репутация пользователя <a class="btn btn-primary" onclick="show_profile('<?php echo $user->id;?>')"><?php echo $user->name. ' '.$user->surname;?></a></h1><hr>