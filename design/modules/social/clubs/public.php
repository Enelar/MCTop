
    <?php $clubs = new Clubs('get_all_public_clubs');?>
    <h1>Публичные клубы</h1><hr>

    <?php if(sizeof($clubs->storage)>0):?>

        <div class="clubs">
            <?php
            foreach($clubs->storage as $club)
                require('club_user_list.php');
            ?>
        </div>
    <?php endif;?>