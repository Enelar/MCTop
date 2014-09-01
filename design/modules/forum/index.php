
    <h1> <span class="<?php echo Core::get_settings()->modules['forum']->icon;?>"></span> Форум </h1><hr>

    <a onclick="display_page('forum','pages/team')" class = "btn btn-success"> <span class="glyphicon glyphicon-eye-open"></span> Команда сайта и форума</a> <hr>

    <div class="forum">

        <div class="section">

            <div class="name">
                <span class="glyphicon glyphicon-link"></span> Разработка сайта
            </div>

            <div class="topics">

                <div class="topic">

                    <div class="name">
                        <a onclick="display_page_with_id('forum', 'topic/body', '<?php echo $topic->id;?>')"><span class="glyphicon glyphicon-pushpin"></span> Обновления MCTop</a>
                    </div>

                </div>

            </div>

        </div>

    </div>