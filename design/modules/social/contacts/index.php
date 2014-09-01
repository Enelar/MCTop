

    <?php
        $friends_ids = Core::$redis_db->sMembers('user:'.Core::get_current_user_profile()->id.':contacts:ids');
    ?>

    <h1> <span class="glyphicon glyphicon-envelope"></span>  Контакты</h1>
    <hr>

    <div class="contacts">

        <div class="tabs">
            <ul class="nav nav-pills">
                <li><a href="#">Онлайн</a></li>
                <li class="active"><a href="#">Друзья</a></li>
                <li><a href="#">Группы</a></li>
                <li><a href="#">Из моего города</a></li>
            </ul>
        </div>

        <hr>

        <?php

            $user = new User(Core::get_db());

            if(empty($friends_ids))
                echo 'У тебя еще нет людей в этом списке контактов';
            else
                foreach($friends_ids as $id)
                {
                    $user->get_user($id);
                    require('contact_body.php');
                }

        ?>


    </div>