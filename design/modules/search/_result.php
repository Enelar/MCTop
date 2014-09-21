<a class="btn btn-primary"><?php echo $server->name;?> </a> Голосов: <?php echo $server->votes?>
<br><br>
<?php
    $only_tags = [];

    $server_tags = explode(':',$server->tags);

    foreach($server_tags as $tag)
        if(strlen($tag) != 0 & $tag != ' ')
            $only_tags[] = $tag;

    foreach ($only_tags as $tag)
    {
        if(in_array($tag, $tags))
            echo '<a class="btn btn-primary">'.$tag.'</a>';
        else
            echo '<a class="btn btn-default">'.$tag.'</a>';
    }
?><hr>