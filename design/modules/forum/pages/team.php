

    <h1> <span class="glyphicon glyphicon-eye-open"></span> Команда сайта и форума</h1><hr>

    <?php
        foreach(Forum_render_class::get_site_team() as $member)
        {
            require('team/member.php');
        }
    ;?>