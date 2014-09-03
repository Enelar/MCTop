<div class="category">

    <div class="name">
        <a title="<?php echo $category->description;?>"> <?php echo $category->name;?></a>
    </div>

    <div class="topics">

        <?php
            if(sizeof($category->topics)>0)
                foreach ($category->topics as $key => $topic)
                    require('_category_topic.php');
        ?>

    </div>

</div>