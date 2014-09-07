
<?php $posts = News::get_posts_for_news_page(0,10);?>

<h1><span class="<?php echo Core::get_settings()->modules['news']->icon?>"></span> Новости <?php echo Core::get_settings()->application['game'];?></h1><hr>

<div class="projects_rating">

    <?php
    foreach($posts as $key => $post)
    {
        require('news/_on_list_page.php');
    }
    ?>

</div>