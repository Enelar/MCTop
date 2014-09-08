
    <div class="server">

        <div class="left_block">

            <div class="position">
                1
            </div>

            <div class="name">
                <a onclick="display_page_with_id('main','server', '<?php echo $server->id?>')"><?php echo $server->name?></a>
            </div>

            <div class="avatar">
                <a onclick="display_page_with_id('main','server', '<?php echo $server->id?>')">
                    <img src="<?php echo $server->avatar;?>"/>
                </a>
            </div>

        </div>

        <div class="right_block">

            <div class="score">
                Престиж: 1
            </div>

            <div class="vote">
                <a onclick="vote_for_server('+', '<?php echo $server->id;?>')" class="btn btn-default"><span class="glyphicon glyphicon-thumbs-up"></span> </a>
                <a onclick="vote_for_server('-', '<?php echo $server->id;?>')" class="btn btn-default"><span class="glyphicon glyphicon-thumbs-down"></span></a>
            </div>

        </div>

    </div>