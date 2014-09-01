<?php if(Core::is_user_authorized()):?>
    <?php $user = Core::get_current_user_profile();?>
    <h1>
        Здравствуй, <?php echo $user->name;?> <?php echo $user->lastname;?>!
    </h1>
    <hr>
<?php endif?>

<a class="btn btn-primary" onclick="display_page('features','blog/index')">Мой блог</a>