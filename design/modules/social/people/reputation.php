
    <?php $user = User::get_user_info($_GET['id']);?>
    <?php $reputation = Reputation_api::get_user_reputation_history($_GET['id']);?>
    <h1><span class="glyphicon glyphicon-adjust"></span> Репутация пользователя <a class="btn btn-primary" onclick="show_profile('<?php echo $user->id;?>')"><?php echo $user->name. ' '.$user->lastname;?></a></h1><hr>
    <?php

        if(is_array($reputation) && sizeof($reputation)>0)
        foreach ($reputation as $mark)
            echo $mark->type.': '.$mark->description.'<br>';
            echo '<hr>';
    ?>
