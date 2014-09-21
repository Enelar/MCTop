<?php $server = Servers::get_server($_GET['id'])?>
<h1>Голосование за сервер <?php echo $server->name;?></h1>
<hr>

<a onclick="vote_for_server(<?php echo $server->id;?>)">Плюс</a>
