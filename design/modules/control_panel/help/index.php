
    <?php
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

                <div class="category">

                    <div class="name">
                        Рейтинг
                    </div>

                    <div class="topics">

                        <div class="topic" onclick="display_page_with_id('control_panel', 'help/topic', '<?php echo $topic->id;?>')">

                            <div class="name">
                                <span class="glyphicon glyphicon-list-alt"></span> Регистрация сервера в рейтинге
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>