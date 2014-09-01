<?php

    require_once('libs/TheX.php');
    define('DEBUG',0);

    require_once('core.php');
    require_once('libs/CometServerApi.php');
    require_once('systems/_db.php');
    require_once(корень.'/db/user.php');
    require_once(корень.'/db/Servers.php');
    require_once(корень.'/db/Projects.php');
    require_once(корень.'/db/Notes.php');
    require_once(корень.'/db/Blog_posts.php');
    require_once(корень.'/db/Clubs.php');
    require_once(корень.'/design/render_classes/Servers.php');

    $core = new Core();
    $user = new User($core::get_db());
    $ajax = $core->is_ajax_request();
    $user_profile = Core::get_current_user_profile();