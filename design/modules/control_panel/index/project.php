<div class="project">

    <div class="name">
        <span class = "glyphicon glyphicon-folder-close"></span> <?php echo $project->name?>
    </div>

    <a onclick="display_page_with_id('control_panel', 'projects/update', '<?php echo $project->id?>')" class="btn btn-primary">Обновить сведения</a>
    <a onclick="display_page_with_id('control_panel', 'projects/access_settings', '<?php echo $project->id?>')" class="btn btn-primary">Настройки доступа</a>
    <a onclick="display_page_with_id('control_panel', 'projects/remove', '<?php echo $project->id?>')" class="btn btn-primary">Удаление</a>

</div>