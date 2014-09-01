
    <?php
        $all_clubs = new Clubs('get_all:clubs');
        $clubs_in_which_user_entered = new Clubs('get_all_in_which_user_entered');
        $invitations = Clubs::get_current_user_invitations();
    ?>

    <h1><span class="glyphicon glyphicon-flag"></span> Клубы</h1><hr>

    <a class="btn btn-success" onclick="display_page('social','clubs/creation')">Создать свой клуб</a>
    <a class="btn btn-success" onclick="display_page('social','clubs/public')">Публичные клубы</a>

    <?php if(sizeof($invitations)>0):?>
        <hr>
        <h3>Приглашения в клубы</h3><hr>
        <div class="clubs">
            <?php
                if(sizeof($invitations)>0)
                {
                    $club = new Clubs('idle');
                    foreach($invitations as $club_id)
                    {
                        $invite_to_club = $club->get('clubs:'.$club_id);
                        $invite_to_club['id'] = $club_id;
                        require('club_invitation_in_user_list.php');
                    }
                }
            ?>
        </div>
    <?php endif;?>

    <?php

        //ну и хули такое?

    ?>

    <?php if(sizeof($clubs_in_which_user_entered)>0):?>
        <hr>
        <div class="clubs">
            <?php
                foreach($clubs_in_which_user_entered->storage as $club)
                    require('club_user_list.php');
            ?>
        </div>
    <?php endif;?>