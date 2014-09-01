

    <?php $friends_ids = Core::$redis_db->sMembers('user:'.Core::get_current_user_profile()->id.':contacts:ids');?>
    <hr>

    Контакты в сети

    <hr>

    <div class="contacts">
        <?php

        $user = new User(Core::get_db());

        if(empty($friends_ids))
            echo 'Нет контактов в сети';
        else
            foreach($friends_ids as $id)
            {
                $user->get_user($id);
                if($user->is_user_online($id))
                    echo '
                    <a class="home_contact_link" onclick="show_profile('.$user->id.')">'.$user->name.' '.$user->lastname.'</a>
                    <a class="btn btn-primary" onclick="display_page_with_id(\'social\', \'im/chat\', \''.$user->id.'\')">Чат</a>
                    <hr>';
            }

        ?>
    </div>