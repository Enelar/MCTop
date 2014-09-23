
    <h1> <span class="glyphicon glyphicon-pencil"></span> Изменение информации профиля</h1><hr>

    <?php
        $user = Core::get_current_user_profile();
    ?>

    <form class="form-horizontal" method="POST" action="javascript:void(null);" onsubmit="edit_profile('<?php echo $_SESSION['session_id'];?>','<?php echo $user->id;?>')">

        <?php if(is_null($user->login)):?>
        <div class="form-group">
            <label class="col-sm-2 control-label">Логин для входа</label>
            <div class="col-sm-10">
                <input name="name" class="form-control" placeholder="Можно установить только 1 раз">
            </div>
        </div>
        <?php endif;?>

        <div class="form-group">
            <label class="col-sm-2 control-label">Имя</label>
            <div class="col-sm-10">
                <input name="name" class="form-control" value="<?php echo $user->name;?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Фамилия</label>
            <div class="col-sm-10">
                <input name="lastname" class="form-control" value="<?php echo $user->lastname;?>">
            </div>
        </div>

        <hr>

        <div class="form-group">
            <label class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
                <input name="email" type="email" class="form-control" placeholder="Email" value="<?php echo $user->email;?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Пароль</label>
            <div class="col-sm-10">
                <input name="password" type="password" class="form-control" placeholder="Заполни, если хочешь изменить">
            </div>
        </div>

        <hr>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Сохранить</button>
            </div>
        </div>

        <div class="message">

        </div>
    </form>