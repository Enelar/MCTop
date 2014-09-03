<?php

class Notes extends API
{

    function create_note()
    {
        global $core;
        API::is_user_authorized_and_is_not_empty_post_request();

        $id = uniqid();

        $result = Core::$redis_db->hMset('user:' . $core::get_current_user_profile()->id . ':notes:' . $id, [
                'name' => $_POST['name'],
                'content' => htmlspecialchars($_POST['content'], ENT_QUOTES),
                'time' => time(),
                'private' => 0
            ]
        );

        $user_notes_ids = Core::$redis_db->get('user:' . $core::get_current_user_profile()->id . ':notes:ids');
        $user_notes_ids .= ':' . $id;

        Core::$redis_db->set('user:' . $core::get_current_user_profile()->id . ':notes:ids', $user_notes_ids);

        return [
            'message' => $result == 1 ? 'success' : 'fail'
        ];
    }

    function edit_note()
    {
        global $core;
        API::is_user_authorized_and_is_not_empty_post_request();

        $result = Core::$redis_db->hMset($_POST['id'], array(
                'name' => $_POST['name'],
                'content' => htmlspecialchars($_POST['content'], ENT_QUOTES),
                'time' => time(),
                'private' => 0)
        );

        return [
            'message' => $result == 1 ? 'success' : 'fail'
        ];
    }

    function delete()
    {
        global $core;
        API::is_user_authorized_and_is_not_empty_post_request();

        $note = Core::$redis_db->hGetAll('user:' . $_POST['user_id'] . ':notes:' . $_POST['id']);

        if (sizeof($note) > 0) {
            if ($_POST['user_id'] == Core::get_current_user_profile()->id) {

                $result = Core::$redis_db->del('user:' . $_POST['user_id'] . ':notes:' . $_POST['id']);

                return [
                    'message' => $result == 1 ? 'success' : 'fail'
                ];
            }
        }
    }

}
