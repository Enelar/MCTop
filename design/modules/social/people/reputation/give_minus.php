
<?php $user = User::get_user_info($_GET['id']);?>
<h1>Поставить минус в репутацию пользователю <a onclick="show_profile('<?php echo $_GET['id']?>')"><?php echo $user->name.' '.$user->lastname?></a></h1>

<form method="POST" id="formx" action="javascript:void(null);" onsubmit="user_add_reputation('minus', '<?php echo $_GET['id'];?>', '<?php echo Core::get_current_user_profile()->id?>')">
    <textarea class="form-control" rows="3" name="description" placeholder="Причина изменения репутации"></textarea>
    <br>
    <input class="btn btn-success" type="submit" value="Обновить историю репутации пользователя"/>
</form>