<ol class="breadcrumb">
    <li>
        <a onclick="display_page('control_panel', 'index')">Панель управления</a>
    </li>
    <li class="active">
        Регистрация проекта
    </li>
</ol>


<a onclick="project_create('<?php echo Core::get_current_user_profile()->id?>')" class="btn btn-lg btn-success">Добавить новый проект</a>