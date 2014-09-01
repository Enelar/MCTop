
    <?php
        $club = new Clubs('get_one:club_by_id:'.$_GET['id']);
        $members_ids = Core::$redis_db->sMembers('clubs:'.$_GET['id'].':members');
    ?>

    <h3 class="page_label">Участники клуба <a onclick="display_page_with_id('social','clubs/body','<?php echo $_GET['id'];?>')" class="btn btn-primary"><?php echo $club->name;?></a></h3><hr>

    <div class="clubs">

        <div class="users">
            <?php

                $user = new User('idle');

                foreach($members_ids as $id)
                {
                    $user->get_user($id);
                    require('_user_club_member.php');
                }

            ?>
        </div>

    </div>
