
    <?php $categories = Forum_api::get_categories();?>
    <h1> <span class="<?php echo Core::get_settings()->modules['forum']->icon;?>"></span> Форум </h1><hr>

    <a onclick="display_page('forum','pages/team')" class = "btn btn-success"> <span class="glyphicon glyphicon-eye-open"></span> Команда сайта и форума</a> <hr>

    <div class="forum">

        <?php
            foreach($categories as $category)
                require('index/category.php');
        ?>

    </div>