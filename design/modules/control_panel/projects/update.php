
    <?php $project = Projects::get_project($_GET['id']);?>
    <h1> Обновление проекта: <?php echo $project->name;?></h1> <hr>

    <form method="POST" id="formx" action="javascript:void(null);" onsubmit="project_update('<?php echo $project->id?>', '<?php echo Core::get_current_user_profile()->id?>')">

        <div class="form-group">
            <label>Название проекта</label>
            <input name="name" type="text" class="form-control" placeholder="Название" value="<?php echo $project->name;?>"/>
        </div>

        <div class="form-group">
            <label>Описание проекта</label>
            <textarea name="description" type="text" class="form-control" placeholder="Описание"><?php echo $project->description;?></textarea>
        </div>

        <hr>

        <div class="form-group">
            <label>Сайт проекта</label>
            <input name="site_url" type="text" class="form-control" placeholder="Сайт" value="<?php echo $project->site_url;?>"/>
        </div>

        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>

    <div class="message"></div>