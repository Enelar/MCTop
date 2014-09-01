<?php

    class Clubs extends Api
    {

        function create()
        {

            global $core;
            Api::is_user_authorized_and_is_not_empty_post_request();

            $id = uniqid();

            $result = Core::$redis_db->hMset('clubs:'.$id, array(
                    'name' => $_POST['name'],
                    'description' => htmlspecialchars($_POST['description'],ENT_QUOTES),
                    'owner' => Core::get_current_user_profile()->id,
                    'access_privacy' => $_POST['access_privacy'])
            );

            $user_own_clubs_ids = Core::$redis_db->get('user:'.$core::get_current_user_profile()->id.':clubs:owner');
            $user_own_clubs_ids .= ':'.$id;

            Core::$redis_db->set('user:'.$core::get_current_user_profile()->id.':clubs:owner', $user_own_clubs_ids);

            if($_POST['access_privacy'] != 'private_club')
                Core::$redis_db->sAdd('clubs:public:ids',$id);

            Core::$redis_db->sAdd('clubs:'.$id.':members',$core::get_current_user_profile()->id);
            Core::$redis_db->sAdd('user:'.$core::get_current_user_profile()->id.':clubs:entered',$id);

            return
                [
                    'message' => $result == 1? 'success' : 'fail',
                    'id' => $id
                ];

        }

        function edit()
        {

            global $core;
            Api::is_user_authorized_and_is_not_empty_post_request();

            $result = Core::$redis_db->hMset('clubs:'.$_POST['id'], array(
                    'name' => $_POST['name'],
                    'description' => htmlspecialchars($_POST['description'],ENT_QUOTES),
                    'access_privacy' => $_POST['access_privacy'])
            );

            return
                [
                    'message' => $result == 1? 'success' : 'fail',
                    'id' => $_POST['id']
                ];


        }

        function delete_note()
        {

            global $core;
            Api::is_user_authorized_and_is_not_empty_post_request();

            $result = Core::$redis_db->del($_POST['id']);

            return
                [
                    'message' => $result == 1? 'success' : 'fail'
                ];

        }

        function join()
        {

            global $core;
            Api::is_user_authorized_and_is_not_empty_post_request();

            $result = Core::$redis_db->sAdd('clubs:'.$_POST['id'].':members',$_POST['user_id']);

            if($result)
                $result = Core::$redis_db->sAdd('user:'.Core::get_current_user_profile()->id.':clubs:entered',$_POST['id']);

            $result = Core::$redis_db->sRem('user:'.Core::get_current_user_profile()->id.':clubs:invitations',$_POST['id']);

            return
                [
                    'message' => $result == 1? 'success' : 'fail'
                ];
        }

        function leave()
        {

            global $core;
            Api::is_user_authorized_and_is_not_empty_post_request();

            $result = Core::$redis_db->sRem('clubs:'.$_POST['id'].':members',$_POST['user_id']);
            $result = Core::$redis_db->sRem('user:'.Core::get_current_user_profile()->id.':clubs:entered',$_POST['id']);

            return
                [
                    'message' => $result == 1? 'success' : 'fail'
                ];
        }

        function delete()
        {

            global $core;
            Api::is_user_authorized_and_is_not_empty_post_request();

            $club = Core::$redis_db->hGetAll('clubs:'.$_POST['id']);

            if($club['owner'] == $_POST['user_id'])
            {
                Core::$redis_db->del('clubs:'.$_POST['id'].':members');
                Core::$redis_db->del('clubs:'.$_POST['id']);
                Core::$redis_db->sRem('user:'.Core::get_current_user_profile()->id.':clubs:entered',$_POST['id']);
                $result = Core::$redis_db->sRem('clubs:public:ids',$_POST['id']);

                return
                    [
                        'message' => $result == 1? 'success' : 'fail'
                    ];
            }

        }

        function invite()
        {

            global $core;
            Api::is_user_authorized_and_is_not_empty_post_request();

            $result = Core::$redis_db->sAdd('clubs:'.$_POST['id'].':members:invited',$_POST['who_wants_to_invite']);

            if($result)
                $result = Core::$redis_db->sAdd('user:'.$_POST['who_wants_to_invite'].':clubs:invitations',$_POST['id']);

            return
                [
                    'message' => $result == 1? 'success' : 'fail'
                ];
        }

        function dismember()
        {

            global $core;
            Api::is_user_authorized_and_is_not_empty_post_request();

            $club = Core::$redis_db->hGetAll('clubs:'.$_POST['club_id']);

            if($club['owner'] == $_POST['user_id'])
            {
                $result = Core::$redis_db->sRem('clubs:'.$_POST['club_id'].':members',$_POST['id_to_dismember']);
                $result = Core::$redis_db->sRem('user:'.$_POST['id_to_dismember'].':clubs:entered',$_POST['club_id']);

                return
                    [
                        'message' => $result == 1? 'success' : 'fail'
                    ];
            }

        }

        function get_club_info()
        {
            $club = Core::$redis_db->hGetAll('clubs:'.$_GET['id']);
            return
            [
                $club
            ];
        }


    }