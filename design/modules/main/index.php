
    <?php $servers = Servers::get_servers_for_rating_page(0,10);?>

    <h1> <span class="<?php echo Core::get_settings()->modules['rating']->icon?>"></span> Рейтинг серверов <?php echo Core::get_settings()->application['game'];?></h1><hr>

    <div class="rating">

        <?php
            foreach($servers as $key => $server)
            {
                require('server/_on_main_page.php');
            }
        ?>

    </div>