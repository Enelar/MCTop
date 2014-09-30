<?php

define('DEBUG', 0);

require ROOT_DIR . '/core/utils/Autoloader.php';
Autoloader::add_classes([
    'Core' => ROOT_DIR . '/core/core.php',
    'API' => ROOT_DIR . '/core/utils/API.php',
    'CometServerApi' => ROOT_DIR . '/core/libs/CometServerApi.php',
    'pgsql' => ROOT_DIR . '/core/libs/phpsql/pgsql.php',
    'X' => ROOT_DIR . '/core/libs/TheX.php',
    '_db' => ROOT_DIR . '/core/systems/_db.php',
    'Modules_names' => ROOT_DIR . '/design/texts/modules.php',

    'News' => ROOT_DIR . '/db/_minecraft/News.php',

    'Forum_topics' => ROOT_DIR . '/db/_minecraft/Forum_topics.php',
    'Forum_categories' => ROOT_DIR . '/db/_minecraft/Forum_categories.php',
    'Forum_answers' => ROOT_DIR . '/db/_minecraft/Forum_answers.php',

    'User' => ROOT_DIR . '/db/user.php',
    'Servers' => ROOT_DIR . '/db/Servers.php',
    'Projects' => ROOT_DIR . '/db/Projects.php',
    'HelpCategories' => ROOT_DIR . '/db/Help.php',
    'Help_Topic' => ROOT_DIR . '/db/Help.php',
    'Blog_Posts' => ROOT_DIR . '/db/Blog_posts.php',

    'Banner' => ROOT_DIR . '/api/Banner.php',
    'Users' => ROOT_DIR . '/api/Users.php',
    'Projects_api' => ROOT_DIR . '/api/Projects_api.php',
    'Achievements_api' => ROOT_DIR . '/api/Achievements_api.php',
    'Reputation_api' => ROOT_DIR . '/api/Reputation_api.php',
    'Forum_api' => ROOT_DIR . '/api/Forum_api.php',
    'RatingServers' => ROOT_DIR . '/api/RatingServers.php',
    'Votes' => ROOT_DIR . '/api/Votes.php',

    'Servers_render_class' => ROOT_DIR . '/design/render_classes/Servers.php',
    'Forum_render_class' => ROOT_DIR . '/design/render_classes/Forum.php'
]);
Autoloader::register();

$core = new Core();
$user = new User($core::get_db());
$ajax = $core->is_ajax_request();
$user_profile = Core::get_current_user_profile();
