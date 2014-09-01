
    <h1> <span class="glyphicon glyphicon-pencil"></span> Изменение информации профиля</h1><hr>

    <?php
        $user = Core::get_current_user_profile();
        //var_dump($_SESSION);
    ?>

    <form class="form-horizontal" method="POST" action="javascript:void(null);" onsubmit="edit_profile('<?php echo $_SESSION['session_id'];?>','<?php echo $user->id;?>')">

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

        <div class="form-group">
            <label class="col-sm-2 control-label">Ник</label>
            <div class="col-sm-10">
                <input name="nickname" class="form-control" value="<?php echo $user->nickname;?>">
            </div>
        </div>
        <hr>

        <div class="form-group">
            <label class="col-sm-2 control-label">Город</label>
            <div class="col-sm-10">
                <input name="city" class="form-control" value="<?php echo $user->city;?>">
            </div>
        </div>

        <hr>

        <div class="form-group">
            <label class="col-sm-2 control-label">Глобальный статус</label>
            <div class="col-sm-10">
                <input name="status" class="form-control" value="<?php echo $user->status;?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Статус семейных отношений</label>
            <div class="col-sm-10">
                <input name="relationship_status" class="form-control" value="<?php echo $user->relationship_status;?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Хобби</label>
            <div class="col-sm-10">
                <input name="hobby" class="form-control" value="<?php echo $user->hobby;?>">
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
            <label class="col-sm-2 control-label">Мобильный телефон</label>
            <div class="col-sm-10">
                <input name="mobile_phone" class="form-control" value="<?php echo $user->mobile_phone;?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input type="checkbox"> Скрывать мой статус в сети
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Сохранить</button>
            </div>
        </div>

        <div class="message">

        </div>
    </form>