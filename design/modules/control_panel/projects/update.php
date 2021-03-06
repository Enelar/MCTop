
    <?php $project = Projects::get_project($_GET['id']);?>

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

        <div class="form-group">
            <span class="label label-default">New</span> <label>Ссылка на группу проекта во ВКонтакте</label>
            <input name="vk_group" type="text" class="form-control" placeholder="VKontakte Group" value="<?php echo $project->vk_group;?>"/>
        </div>

        <div class="form-group">
            <span class="label label-default">New</span> <label>Ссылка на сообщество проекта в Facebook</label>
            <input name="fb_public" type="text" class="form-control" placeholder="Facebook Group" value="<?php echo $project->fb_public;?>"/>
        </div>

        <div class="form-group">
            <span class="label label-default">New</span> <label>Ссылка на аккаунт проекта в Twitter</label>
            <input name="twitter_account" type="text" class="form-control" placeholder="Twitter Account" value="<?php echo $project->twitter_account;?>"/>
        </div>

        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>

    <div class="message"></div>