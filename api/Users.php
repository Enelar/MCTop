<?php

class Users extends Api
{
    function authorize()
    {
        global $core;

        Api::check_for_post_request();

        $user = new User(Core::get_db());
        $user_hack = new User(Core::get_db());

        $user = $user->find_user_by_login($_POST['login']);

        if (md5($_POST['password']) == $user['password'])
            $message = 'success';
        else
            $message = 'fail';

        if ($message == 'success') {
            if (session_status() != PHP_SESSION_ACTIVE)
                session_start();
            $_SESSION['uid'] = $user['id'];
            $_SESSION['last_update'] = time();
            $_SESSION['session_id'] = md5($user['id'] . 'salt');
            $user_hack->update_session_id($_SESSION['session_id'], $user['id']);
        }

        return [
            'message' => $message
        ];
    }

    function logout()
    {
        global $core;
        if (session_status() != PHP_SESSION_ACTIVE)
            session_start();
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_unset();
            //session_destroy();
        }
        header('Location: http://mctop.ru');
    }

    function edit_profile()
    {
        global $core;
        Api::is_user_authorized_and_is_not_empty_post_request();

        $user = new User(Core::get_db());
        $user->get_user(intval($_POST['user_id']));

        $fields = explode(', ', $user->fields_to_edit);
        $changed_fields = [];

        foreach ($fields as $key => $field) {
            if ($field != 'password')
                if ($user->$field != $_POST[$field] and $field != 'password') {
                    $changed_fields[$field] = 1;
                }
        }

        $query = 'UPDATE users set ';

        foreach ($changed_fields as $key => $field)
            $query .= "$key = '{$_POST[$key]}', ";

        $query = substr($query, 0, strlen($query) - 2);
        $query .= ' where id = ' . $user->id;

        $sth = Core::get_db()->prepare($query);
        $status = $sth->execute()
        or
        self::abort($sth);
        return $status;
    }

    function get_test_data_for_home()
    {
        global $core;

        return $some_data = [
            'message' => time()
        ];
    }

    function is_user_authorized()
    {
        return [
            'is_authorized' => Core::is_user_authorized() ? true : false
        ];
    }

    function update_user_session_period()
    {
        global $core;

        $time = 0; # =(
        if (Core::is_user_authorized()) {
            $time = time();
            Core::$redis_db->hSet('user:' . Core::get_current_user_profile()->id . ':vay_data', 'last_seen', $time);
        }

        return [
            'time' => $time
        ];
    }

    function get_current_user_id()
    {
        if (Core::is_user_authorized())
            return [
                'data' => Core::get_current_user_profile()->id
            ];
    }

    function get_user_info()
    {

        $info = new User();

        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $info->get_user($id);
        }

        if (isset($_GET['login'])) {
            $login = $_GET['login'];
            $info->get_user_by_login($login);
        }

        unset($info->password);
        unset($info->session_id);
        unset($info->fields_to_edit);
        unset($info->cl_name);

        return [
            $info
        ];
    }

    function get_user_contacts()
    {
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            return Core::$redis_db->sMembers('user:' . $id . ':contacts:ids');
        }
    }

    function get_user_clubs()
    {

    }

    function get_user_books()
    {

    }

    function get_user_books_pages()
    {

    }

}
