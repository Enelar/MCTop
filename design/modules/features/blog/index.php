
    <?php

    $current_user_profile = Core::get_current_user_profile();

    if(isset($_GET['id']))
        $posts = new Blog_Posts('get_all:notes_from_user:'.intval($_GET['id']));
    else
        $posts = new Blog_Posts('get_all:notes_from_user:'.$current_user_profile->id);

    if(isset($_GET['id']))
    {
        if($current_user_profile->id != $_GET['id'])
        {
            $blog_user_profile = new User(Core::get_db());
            $blog_user_profile->get_user($_GET['id']);
        }
        else
            $blog_user_profile = $current_user_profile;
    }
    else
        $blog_user_profile = $current_user_profile;



    ?>

    <h1> <span class="glyphicon glyphicon-asterisk"></span> Блог пользователя <a onclick="show_profile(<?php echo $blog_user_profile->id;?>)"><?php echo $blog_user_profile->name?> <?php echo $blog_user_profile->lastname?></a></h1><hr>

    <div class="blogs">

        <?php if($current_user_profile->id == intval($_GET['id']) or !isset($_GET['id'])):?>

            <form method="POST" id="formx" action="javascript:void(null);" onsubmit="blog_post_record()">
                <textarea class="form-control" rows="3" name="content"></textarea>
                <br>
                <input class="btn btn-success" type="submit" value="Отправить"/>
            </form>

            <hr>

        <?php endif;?>

        <?php
            if(!empty($posts))
            {
                if(is_object($posts->storage))
                    echo 'Блог пользователя пока пустует :(';
                else
                    foreach($posts->storage as $redis_key => $post)
                        require('record.php');
            }




        ?>

    </div>

    <script>
        $("form").keypress(function(event) {
            if (event.which == 13 && event.shiftKey) {
                event.preventDefault();
                $("form").submit();
            }
        });
    </script>