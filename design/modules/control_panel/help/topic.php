<?php
    $category_and_topic_ids = explode('.', $_GET['id']);
    $topic = Help_Topic::get_topic($category_and_topic_ids[0], $category_and_topic_ids[1]);
?>

<h1><span class="glyphicon glyphicon-leaf"></span> Помощь по сайту</h1> <hr>


<?php echo $topic->name;?><hr>
<?php echo $topic->text;?>