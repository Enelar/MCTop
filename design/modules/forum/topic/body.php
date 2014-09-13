
    <?php $topic = Forum_api::get_topic($_GET['id'], 15, 0);?>
    <?php require('head.php');?>
    <hr>

    <form method="POST" id="formx" action="javascript:void(null);" onsubmit="forum_topic_leave_message('<?php echo $topic->id?>', '<?php echo Core::get_current_user_profile()->id?>')">
        <textarea class="form-control" rows="3" name="message"></textarea>
        <br>
        <input class="btn btn-success" type="submit" value="Отправить"/>
    </form>

    <?php
        foreach ($topic->messages as $message)
        {
            require('message.php');
        }
    ?>