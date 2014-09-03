<?php

class Blog extends API
{

    function post_new_record()
    {
        global $core;

        if (!$core::is_user_authorized())
            die();

        API::check_for_post_request();

        $id = uniqid();

        $result = Core::$redis_db->hMset('user:' . $core::get_current_user_profile()->id . ':blog:records:' . $id, [
                'content' => htmlspecialchars($_POST['content'], ENT_QUOTES),
                'time' => time(),
                'private' => 0
            ]
        );

        $user_notes_ids = Core::$redis_db->get('user:' . $core::get_current_user_profile()->id . ':blog:records:ids');
        $user_notes_ids .= ':' . $id;

        Core::$redis_db->set('user:' . $core::get_current_user_profile()->id . ':blog:records:ids', $user_notes_ids);

        return [
            'message' => $result == 1 ? 'success' : 'fail'
        ];
    }

    function delete()
    {
        global $core;

        if (!$core::is_user_authorized())
            die();

        API::check_for_post_request();

        $post = Core::$redis_db->hGetAll('user:' . $_POST['user_id'] . ':blog:records:' . $_POST['id']);

        if ($_POST['user_id'] == Core::get_current_user_profile()->id) {
            $result = Core::$redis_db->del('user:' . $_POST['user_id'] . ':blog:records:' . $_POST['id']);

            return [
                'message' => $result == 1 ? 'success' : 'fail'
            ];
        }

        return [
            'message' => 'fail'
        ];
    }
}
