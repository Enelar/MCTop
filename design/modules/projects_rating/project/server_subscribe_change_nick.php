<?php $server = Servers::get_server($_GET['id'])?>

<h1>Смена нике на сервере <?php echo htmlspecialchars($server->name);?></h1><hr>

<form role="form" action="javascript:void(null);" onsubmit="server_subscriber_change_nickname('<?php echo $server->id;?>')">
    <div class="form-group">
        <input name="nickname" class="form-control" placeholder="Новый ник на сервере"/>
    </div>
    <input type="submit" class="btn btn-success" value="Сохранить изменения">
</form>
