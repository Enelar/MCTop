
<h1> <span class="glyphicon glyphicon-pencil"></span> Обновление сведений о Email</h1><hr>

<div class="alert alert-warning" role="alert">Настоятельно рекомендуем установить логин и пароль (правый верхний угол: "Дополнения" -> Редактировать профиль).</div>

<div class="alert alert-success" role="alert">Голос был успешно занесен в базу.</div>
<div class="alert alert-info" role="alert">
    Для того, чтобы твой голос был не удален, тебе нужно подтвердить Email<br>
    Для этого, введи email в форму ниже и нажми "Сохранить".<br>
    После получения письма, тебе необходимо перейти по ссылке в нем<br>
    Благодарим за понимание<br>
    ps. Мы гарантируем, что никакого спама прислано не будет, за все время участия на проекте
</div>
<div class="alert alert-warning" role="alert">После нажатия кнопки "Сохранить" вы будете переброшены на страницу сервера, за который отдали голос. Одновременно с этим, вы получите письмо.</div>

<form class="form-horizontal" method="POST" action="javascript:void(null);" onsubmit="email_approving(<?php echo $_GET['id'];?>)">

    <div class="form-group">
        <label class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
            <input name="email" type="email" class="form-control" placeholder="Email" value="">
        </div>
    </div>

    <hr>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Сохранить</button>
        </div>
    </div>

</form>