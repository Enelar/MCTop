
    <?php
        //HelpCategories::add_new_category('Форум', 'Тип-какт-так');
        //Help_Topic::add_new_topic(2, 'Реклама на форуме', 'Не еблань');
        $help_categories = HelpCategories::get_categories_with_topics();
    ?>
    <h1><span class="glyphicon glyphicon-leaf"></span> Помощь по сайту</h1> <hr>
    <ol class="breadcrumb">
        <li><a onclick="display_page('control_panel', 'index')">Контрольная панель</a></li>
        <li class="active">Помощь по сайту</li>
    </ol>
    <hr>

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