<h1><span class="glyphicon glyphicon-lock"></span> Авторизация на <?php echo Core::get_settings()->application['site_name'];?></h1>
<hr>

<form method="POST" id="formx" class="login_form" action="javascript:void(null);" onsubmit="authorize_user()">
    <div class="form-group">
        <label>Логин</label>
        <input id="login" name="login" class="form-control">
    </div>
    <div class="form-group">
        <label>Пароль</label>
        <input name="password" type="password" class="form-control">
    </div>
    <input type="submit" class="btn btn-default" value="Войти">
</form>