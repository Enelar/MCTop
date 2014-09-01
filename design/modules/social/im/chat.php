

    <?php
        $user = new User(Core::get_db());
        $user->get_user($_GET['id']);
        if(is_null($user->id))
        {
            echo 'Пользователя не существует';
            die();
        }
    ?>
    <h1>Чат с пользователем <?php echo $user->name?> <?php echo $user->lastname?></h1><hr>

    <form method="POST" id="formx" action="javascript:void(null);" onsubmit="send_message('<?php echo Core::get_current_user_profile()->id?>', '<?php echo $user->id?>')">
        <textarea id="message_input" name="message" class="form-control" rows="4"></textarea>
        <br>
        <input type="submit" class="btn btn-default" value="Готово">
    </form>

    <?php
        //$messages_ids = Core::$redis_db->keys('user:'.Core::get_current_user_profile()->id.':chat_with_user:'.$user->id.':message:*');
        // юзать листы, чтобы нормик работал список сообщений, в плане сортировки сообщений
        $messages_ids = Core::$redis_db->zRange('user:'.Core::get_current_user_profile()->id.':chat_with_user:'.$user->id.':messages', 0, -1);
        foreach($messages_ids as $key => $message_id)
        {
            var_dump($message_id);
            //$message = Core::$redis_db->hGetAll($message_id);
            //require('_message.php');
        }
    ?>

    <script>
        $("form").keypress(function(event) {
            if (event.which == 13 && event.shiftKey) {
                event.preventDefault();
                $("form").submit();
            }
        });
    </script>