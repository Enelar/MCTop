

    <?php
        $club = new Clubs('get_one:club_by_id:'.$_GET['id']);

        if($club->owner != Core::get_current_user_profile()->id)
            Core::oups_sorry_404();
    ?>
    <h1>Редактирование клуба</h1><hr>

    <form method="POST" id="formx" action="javascript:void(null);" onsubmit="club_edit('<?php echo $_GET['id'];?>')">

        <div class="form-group">
            <input name="name" class="form-control" placeholder="Название" value = '<?php echo $club->name;?>'>
        </div>

        <textarea class="form-control" rows="3" name="description" placeholder="Описание"><?php echo $club->description;?></textarea>
        <hr>

        <h3>Приватность</h3>
        <div class="radio">
            <label>
                <input type="radio" name="access_privacy" value="private_club" <?php if($club->access_privacy == 'private_club') echo 'checked';?>>
                Приватный клуб (не виден в списке клубов)
            </label>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="access_privacy" value="public_closed_club" <?php if($club->access_privacy == 'public_closed_club') echo 'checked';?>>
                Публичный <b>закрытый</b> клуб
            </label>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="access_privacy" value="public_club" <?php if($club->access_privacy == 'public_club') echo 'checked';?>>
                Публичный клуб
            </label>
        </div>
        <hr>

        <input class="btn btn-success" type="submit" value="Сохранить изменения"/>
    </form>