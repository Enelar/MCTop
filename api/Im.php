<?php

class Im extends API
{

    protected $comet_server;

    function __construct()
    {
        if (Core::is_user_authorized()) {
            $this->comet_server = CometServerApi::getInstance();
            $this->comet_server->authorization(99, "In9a4PPrZMzUiZJscpoZzx9l9ap3UxVhpaaHJDTGWZdHBajbmPU6J0oL2ayTdonu");
        } else
            die();
    }

    function authorize_user_on_comet_server()
    {
        # А если пользователь не авторизован?
        # return ['error' => '?'];
        if (!Core::is_user_authorized())
            return;

        if (session_status() != PHP_SESSION_ACTIVE)
            session_start();

        if (!isset($_SESSION['is_authorized_on_comet_server'])) 
            return [
                'error' => 'user_already_authorized_on_comet_server'
            ];

        $hash = substr(md5(uniqid() . md5(time())), 0, 6) . '+' . Core::get_current_user_profile()->id;
        CometServerApi::getInstance()->add_user_hash(Core::get_current_user_profile()->id, $hash);
        $_SESSION['is_authorized_on_comet_server'] = true;
        return [
            'message' => 'user_successfuly_authorized_on_comet_server'
        ];
    }

    function send_message_to_user()
    {
        API::is_user_authorized_and_is_not_empty_post_request();

        $sender = new User();
        $sender->get_user($_POST['from']);

        $from = $_POST['from'];
        $to = $_POST['to'];
        $message = $_POST['message'];

        $this->comet_server->send_to_pipe('user_' . $to . '_notifications', 'a_new_message', [
            'from' => '<a onclick="show_profile(' . $from . ')">' . $sender->name . ' ' . $sender->lastname . '</a>',
            'to' => $to,
            'message' => $message
        ]);

        $from_to = 'im:chat_users:' . $from . '_' . $to . '.:messages';
        $to_from = 'im:chat_users:' . $to . '_' . $from . '.:messages';
        $new_message_id = $this->get_new_id_for_message_for_chat($from, $to);

        Core::$redis_db->zAdd('im:chat_users:' . $from . '_' . $to, $new_message_id, $new_message_id);

        //todo сделать сохранение сообщения только под .._from_to..
        //чтобы даже в случае если юзер_2 пишет юзеру_1
        return [
            'comet' => 'message_had_sent'
        ];

    }

    function get_chat_messages_count($user_1, $user_2)
    {
        $chat_messages_count = sizeof(Core::$redis_db->keys('im:chat_users:' . $user_1 . '_' . $user_2 . '.:message:*'));
        if ($chat_messages_count == 0)
            $chat_messages_count = sizeof(Core::$redis_db->keys('im:chat_users:' . $user_2 . '_' . $user_1 . '.:message:*'));
        return $chat_messages_count;
    }

    function get_new_id_for_message_for_chat($user1, $user_2)
    {
        return $this->get_chat_messages_count($user1, $user_2);
    }

    function is_chat_exists_for_users($user1, $user2)
    {

    }

    function add_message_to_chat($id, $message)
    {

    }

    function get_chat_id_for_users($user1, $user2)
    {

    }
}