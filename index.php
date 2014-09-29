<?php

define('ROOT_DIR', __DIR__);
require_once 'core/bootstrap.php';

if (!$ajax): ?>
    <!doctype html>
<html lang="ru">
<head>
    <title><?php echo Core::get_settings()->application['title_content']; ?></title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
</head>

<script src="js/jquery.js"></script>
<script src="js/jquery-1.11.0.js"></script>
<script data-main="js/main" src="js/require.js"></script>

<link type="text/css" rel="stylesheet" href="css/bootstrap.css"/>
<link type="text/css" rel="stylesheet" href="css/jquery.qtip.min.css"/>
<link type="text/css" rel="stylesheet" href="css/<?php echo Core::get_settings()->application['site_name']; ?>.css"/>
<body>

<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a id="mctop_logo" class="navbar-brand" onclick="display_page('main','index')">
                <span class="glyphicon glyphicon-home"></span> <?php echo Core::get_settings()->application['site_name'] ?>
            </a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php

                if (!Core::is_user_authorized()):
                    foreach (Core::get_settings()->modules as $key => $module) {
                        if ($module->show_in_navbar)
                            if(!isset($module->show_to_guest))
                                echo '<li><a onclick="display_page(\'' . $module->link . '\')"><span class="' . $module->icon . '"></span> ' . $module->name . '</a></li>';
                    }
                endif;
                if (Core::is_user_authorized()):
                    foreach (Core::get_settings()->modules as $key => $module) {
                        if ($module->show_in_navbar)
                            if ($module->show_to_authorized)
                                echo '<li><a onclick="display_page(\'' . $module->link . '\')"><span class="' . $module->icon . '"></span> ' . $module->name . '</a></li>';
                    }
                    ?>
                    <li><a onclick="show_profile('<?php echo $user_profile->id; ?>')">
                            <span class="glyphicon glyphicon-user"></span> Профиль</a></li>
                <?php endif ?>
            </ul>
            <?php if (Core::is_user_authorized()): ?>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Дополнения
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a onclick="display_page('control_panel','index')"><span class="glyphicon glyphicon-plane"></span> Панель управления</a>
                            </li>
                            <li>
                                <a onclick="display_page('projects_rating','favorite')"><span class="glyphicon glyphicon-star"></span> Избранное</a>
                            </li>
                            <li>
                                <a onclick="display_page('community','index')"><span class="glyphicon glyphicon-globe"></span> Сообщество</a>
                            </li>
                            <li>
                                <a onclick="display_page('api','index')"><span class="glyphicon glyphicon-picture"></span> API</a>
                            </li>
                            <li class="divider"></li>
                            <li><a onclick="display_page('outdoor','logout')">Выход</a></li>
                        </ul>
                    </li>
                </ul>
            <?php endif ?>

        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>

<?php
if (Core::is_user_authorized()):
    if (Clubs::get_current_user_invitations_count() > 0): ?>
        <div class="main_notifications">
            <?php Clubs_render_class::render_invitations_notifier(); ?>
        </div>
    <?php endif;
endif; ?>

<div class="content">
    <?php endif; ?>

    <?php
    if ($ajax)
        $core->render_page($_GET['module'], $_GET['action']);
    if (!$ajax): ?>
</div>

<div class="footer">

</div>

</body>
</html>
<?php endif; ?>
