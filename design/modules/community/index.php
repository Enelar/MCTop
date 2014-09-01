
    <h1> <span class="<?php echo Core::get_settings()->modules['community']->icon?>"></span> <?php echo Core::get_settings()->application['site_name'];?>: Сообщество</h1><hr>

    <div class="contacts">
        <?php
            $users = User::get_users_for_community_page(1, 10);
            if(sizeof($users)>0)
                foreach($users as $user)
                    require('index/user.php');
        ?>
    </div>