
    <?php $club = new Clubs('get_one:club_by_id:'.$_GET['id']);?>

    <h1>Приглашение в клуб <?php echo $club->name;?></h1><hr>

    <div class="clubs">

        <div class="users">

            <?php

                $idle_user = new User(Core::get_db());

                $user_contacts = Core::$redis_db->sMembers('user:'.Core::get_current_user_profile()->id.':contacts:ids');

                foreach($user_contacts as $key => $contact_id)
                {
                    $user_mutual_contact = Core::$redis_db->sIsMember('user:'.$contact_id.':contacts:ids', Core::get_current_user_profile()->id);
                    if($user_mutual_contact and !Core::$redis_db->sIsMember('clubs:'.$club->id.':members:invited',$contact_id))
                    {
                        $user = $idle_user->get_user($contact_id);
                        require('_user_to_invite_list.php');
                    }

                }

            ?>

        </div>

    </div>
