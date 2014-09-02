<?php

require_once('libs/TheX.php');
define('DEBUG', 0);

require_once('core.php');
require_once('libs/CometServerApi.php');
require_once('systems/_db.php');
require_once(ROOT_DIR . '/db/user.php');
require_once(ROOT_DIR . '/db/Servers.php');
require_once(ROOT_DIR . '/db/Projects.php');
require_once(ROOT_DIR . '/db/Help.php');
require_once(ROOT_DIR . '/db/Notes.php');
require_once(ROOT_DIR . '/db/Blog_posts.php');
require_once(ROOT_DIR . '/db/Clubs.php');
require_once(ROOT_DIR . '/design/render_classes/Servers.php');

$core = new Core();
$user = new User($core::get_db());
$ajax = $core->is_ajax_request();
$user_profile = Core::get_current_user_profile();
