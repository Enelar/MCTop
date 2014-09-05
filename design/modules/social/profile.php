
    <?php
        $user = new User(Core::get_db());
        if(is_array($user->get_user($_GET['id'])))
        {
            echo 'Пользователя не существует';
            die();
        }
    ?>

    <div class="profile">

        <table>
            <tr>
                <td class="name"> <h1><span class="glyphicon glyphicon-user"></span> <?php $user->display_name();?> <?php $user->display_nickname();?> <?php $user->display_lastname();?></h1></td>
                <td class="status"><?php echo $user->status;?></td>
                <div class="availability_status <?php if(User::is_user_online($_GET['id'])) echo 'status_in_vay'?>"></div>
            </tr>
        </table>

        <hr>

        <table class="middle_info">
            <tr>
                <td class="avatar_td">
                    <div class="avatar">
                        <img src="/static/ava_profile.png"/>
                    </div>
                </td>
                <td class="right_column">
                    <!--Город: InDev<hr>
                    Мировидение: InDev<hr>
                    Любимая музыка: InDev<br>

                    Работа: InDev<br>
                    <br>-->
                    <?php $user->display_relations();?>
                    <?php $user->display_mobile_phone();?>
                    <?php $user->display_hobby();?>
                    <?php $user->display_city();?>
                    <?php //echo $user->display_reputation();?>
                    <?php //echo $user->display_prestige();?>
                </td>
            </tr>
        </table>

        <hr>

        <?php if(Core::is_user_authorized()):?>
            <?php if(Core::get_current_user_profile()->id != $user->id):?>
                <div class="btn-group buttons">
                    <?php if(!Core::$redis_db->sIsMember('user:'.Core::get_current_user_profile()->id.':contacts:ids',$user->id)):?>
                        <button type="button" class="btn btn-success" onclick="add_user_to_contact_list('<?php echo Core::get_current_user_profile()->id;?>','<?php echo $user->id;?>')">Добавить</button>
                    <?php endif;?>
                    <?php if(Core::$redis_db->sIsMember('user:'.Core::get_current_user_profile()->id.':contacts:ids',$user->id)):?>
                        <button type="button" class="btn btn-danger" onclick="delete_user_from_contact_list('<?php echo Core::get_current_user_profile()->id;?>','<?php echo $user->id;?>')">Удалить</button>
                    <?php endif;?>
                    <button type="button" class="btn btn-default">Группа</button>
                </div>
            <?php endif;?>

            <div class="btn-group buttons">
                <button type="button" class="btn btn-primary" onclick="display_page_with_id('features','blog/index',<?php echo $user->id?>)">Блог</button>
            </div>

            <hr>

            <?php if(Core::get_current_user_profile()->id != $user->id):?>
            <div class="btn-group buttons">
                <button type="button" class="btn btn-success" onclick="display_page_with_id('social','im/chat',<?php echo $user->id;?>)">Начать чат</button>
            </div>
            <?php endif;?>
        <?php endif;?>


    </div>

    <script>
        key('c', function(){ display_page_with_id('social','im/chat',<?php echo $user->id;?>); });
    </script>