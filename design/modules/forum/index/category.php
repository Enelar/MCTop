<div class="section">

    <div class="name">
        <span class="glyphicon glyphicon-link"></span> <?php echo $category->name;?>
    </div>
    <p><?php echo $category->description;?></p>

    <div class="topics">

        <?php
            foreach($category->topics as $topic)
                require('topic.php')
        ?>

    </div>

</div>