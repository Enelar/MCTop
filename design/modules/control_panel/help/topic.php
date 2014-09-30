<?php
$category_and_topic_ids = explode('.', $_GET['id']);
$topic = Help_Topic::get_topic($category_and_topic_ids[0], $category_and_topic_ids[1]);
?>

<ol class="breadcrumb">
    <li>
        <a href="/static/control_panel/index">Панель управления</a>
    </li>
    <li>
        <a onclick="display_page('control_panel','help/index')">Помощь по сайту</a>
    </li>
    <li class="active">
        <?php echo $topic->name;?>
    </li>
</ol>


<h1><span class="glyphicon glyphicon-leaf"></span> Помощь по сайту</h1> <hr>


<?php echo $topic->name;?><hr>
<?php echo $topic->text;?>