
    <h1>Сообщество Vay</h1><hr>

    <div class="contacts">
        <?php

        $users = User::get_all_users(20);

        foreach($users as $key => $user)
        {
            require('list/_user_in_list.php');
        }

        ?>
    </div>
