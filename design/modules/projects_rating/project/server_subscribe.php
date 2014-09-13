<?php $server = Servers::get_server($_GET['id'])?>

<h1>Подписаться на сервер <?php echo $server->name;?></h1><hr>

<form role="form" action="javascript:void(null);" onsubmit="server_subscribe('<?php echo $server->id;?>')">
    <div class="form-group">
        <input name="nickname" class="form-control" placeholder="Ник на сервере"/>
    </div>
    <input type="submit" class="btn btn-success" value="Подписаться">
</form>
