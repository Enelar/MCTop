<?php

define('ROOT_DIR', __DIR__);
require_once 'core/bootstrap.php';
if(sizeof($_POST)>0)
    Core::log_post_request();

if (!$ajax): ?>
    <!doctype html>
<html lang="ru">
<head>
    <title><?php echo Core::get_settings()->application['title_content']; ?></title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
</head>

<script src="/js/jquery.js"></script>
<script data-main="/js/main" src="/js/require.js"></script>

<link type="text/css" rel="stylesheet" href="/css/bootstrap.css"/>
<link type="text/css" rel="stylesheet" href="/css/jquery.qtip.min.css"/>
<link type="text/css" rel="stylesheet" href="/css/<?php echo Core::get_settings()->application['site_name']; ?>.css"/>
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
            <a id="mctop_logo" class="navbar-brand" href="/static/main/index">
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
                                <a href="/static/control_panel/index"><span class="glyphicon glyphicon-plane"></span> Панель управления</a>
                            </li>
                            <li>
                                <a onclick="display_page('projects_rating','favorite')"><span class="glyphicon glyphicon-star"></span> Избранное</a>
                            </li>
                            <li>
                                <a onclick="display_page('social','misc/edit_profile_info')"><span class="glyphicon glyphicon-globe"></span> Редактировать профиль</a>
                            </li>
                            <li>
                                <a href="/static/api/index"><span class="glyphicon glyphicon-picture"></span> API</a>
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

<div class="faq_button">
    <a class="btn btn-primary" href="/static/main/faq">FAQ</a>
</div>

<div class="content">
    <?php endif; ?>

    <?php

    if ($ajax)
        $core->render_page($_GET['module'], $_GET['action']);
    else
    {
        if(isset($_GET['module']) && $_GET['action'])
            $core->render_page($_GET['module'], $_GET['action']);
        else
            $core->render_page('projects_rating', 'index');
    }

    if (!$ajax): ?>
</div>

<div class="footer">

</div>
<script type="text/javascript">
    window.analytics=window.analytics||[],window.analytics.methods=["identify","group","track","page","pageview","alias","ready","on","once","off","trackLink","trackForm","trackClick","trackSubmit"],window.analytics.factory=function(t){return function(){var a=Array.prototype.slice.call(arguments);return a.unshift(t),window.analytics.push(a),window.analytics}};for(var i=0;i<window.analytics.methods.length;i++){var key=window.analytics.methods[i];window.analytics[key]=window.analytics.factory(key)}window.analytics.load=function(t){if(!document.getElementById("analytics-js")){var a=document.createElement("script");a.type="text/javascript",a.id="analytics-js",a.async=!0,a.src=("https:"===document.location.protocol?"https://":"http://")+"cdn.segment.io/analytics.js/v1/"+t+"/analytics.min.js";var n=document.getElementsByTagName("script")[0];n.parentNode.insertBefore(a,n)}},window.analytics.SNIPPET_VERSION="2.0.9",
        window.analytics.load("f592b8nv9t");
    window.analytics.page();
</script>
</body>
</html>
<?php endif; ?>
