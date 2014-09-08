
    <?php
        $help_categories = HelpCategories::get_categories_with_topics();
    ?>
    <h1><span class="glyphicon glyphicon-leaf"></span> Помощь по сайту</h1> <hr>

    <div class="control_panel">

        <div class="help">

            <div class="categories">

                <?php
                    if(sizeof($help_categories)>0)
                        foreach($help_categories as $key => $category)
                            require('index/_category.php');
                ?>

            </div>

        </div>

    </div>

    <script>
        $('[title!=""]').qtip();
    </script>