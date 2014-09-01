

    <?php
        $club = new Clubs('get_one:club_by_id:'.$_GET['id']);
        $club->check_privacy(Core::get_current_user_profile()->id);
        $members = Core::$redis_db->sMembers('clubs:'.$_GET['id'].':members');
    ?>

    <h1>Клуб: <?php echo $club->name;?></h1><hr>

    <div class="clubs">

        <?php if($club->owner != Core::get_current_user_profile()->id):?>
            <div class="leave_enter_button">

                <?php if(Core::$redis_db->sIsMember('clubs:'.$club->id.':members',Core::get_current_user_profile()->id)):?>
                    <a class="btn btn-warning" onclick="club_leave('<?php echo $club->id?>','<?php echo Core::get_current_user_profile()->id?>')">Выйти из клуба</a>
                <?php endif;?>

                <?php if(!Core::$redis_db->sIsMember('clubs:'.$club->id.':members',Core::get_current_user_profile()->id)):?>
                    <a class="btn btn-success" onclick="club_join('<?php echo $club->id?>','<?php echo Core::get_current_user_profile()->id?>')">Вступить в клуб</a>
                <?php endif;?>
            </div>
        <?php endif?>

        <a class="btn btn-primary" onclick="display_page_with_id('social','clubs/members','<?php echo $_GET['id'];?>')"> Участников в клубе: <?php echo sizeof($members);?></a>
        <hr>


            <?php if($club->owner == Core::get_current_user_profile()->id):?>
                <a class="btn btn-success" onclick="display_page_with_id('social', 'clubs/edit', '<?php echo $club->id;?>')">Редактировать</a>
                <a class="btn btn-success" onclick="display_page_with_id('social', 'clubs/invites', '<?php echo $club->id?>')">Пригласить людей в клуб</a>
                <a class="btn btn-success" onclick="club_delete('<?php echo $club->id?>','<?php echo Core::get_current_user_profile()->id?>')">Удалить клуб</a>
                <hr>
            <?php endif?>

            Описание клуба: <?php echo $club->description;?>

    </div>

