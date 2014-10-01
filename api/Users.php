<?php

class Users extends API
{
    public function uid()
    {
        phoxy_protected_assert($this->is_user_authorized(), ["error" => "Auth required"]);
        return $this->get_uid();
    }

    public function get_uid()
    {
        global $_session;

        if (isset($_session['uid']))
            return $_session['uid'];
        return false;
    }

    public function is_user_authorized()
    {
        return !!$this->get_uid();
    }

    public function get_current_user_profile()
    {
        return $this->get_uid();
    }

    function authorize()
    {
        API::check_for_post_request();

        $user = User::find_user_by_login($_POST['login']);
        if(sizeof($user) == 0)
            $user = User::find_user_by_id($_POST['login']);

        $message = (md5($_POST['password']) == $user['password']) ? 'success' : 'fail';

        if ($message == 'success') {
            if (session_status() != PHP_SESSION_ACTIVE)
                session_start();
            $_SESSION['uid'] = $user['id'];
            $_SESSION['last_update'] = time();
            $_SESSION['session_id'] = md5($user['id'] . 'salt');
        }

        return [
            'message' => $message
        ];
    }

    function register()
    {
        $password = uniqid(time());
        $salted_password = md5($password);


        Core::$db->Query("insert into main.users (password) values ($1)", [$salted_password]);
        $user = Core::$db->Query("select * from main.users where password = $1 order by id desc", [$salted_password], true);

        if (session_status() != PHP_SESSION_ACTIVE)
            session_start();

        $_SESSION['uid'] = $user['id'];
        $_SESSION['last_update'] = time();
        $_SESSION['session_id'] = md5($user['id'] . 'salt');

        return
        [
            'message' => 'success',
            'password' => $password,
            'id'       => $user['id']
        ];

    }

    function logout()
    {
        if (session_status() != PHP_SESSION_ACTIVE)
            session_start();
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
        header('Location: http://online.mctop.im');
    }

    function edit_profile()
    {
        $uid = Core::get_current_user_profile()->id;
        if ($uid === null)
            return;

        $user = new User(Core::get_db());
        $user->get_user($uid);

        $dictonary = explode(', ', $user->fields_to_edit);

        $trans = Core::$db->Begin();
        $success = true;

        foreach ($dictonary as $field)
        {
            if (!isset($_POST[$field]) && strlen($_POST[$field]) > 0)
                continue;

            $data = $_POST[$field];
            
            if ($field == 'password')
                $data = md5($data); // Rainbow hash table vulnerability

            $res = Core::$db->Query("UPDATE main.users SET {$field}=$2 WHERE id=$1 RETURNING id", [$uid, $data], true);
            $success &= count($res);
        }

        $res = $trans->Finish($success);

        return ['message' => $res ? 'success' : 'failure' ];
    }

    function get_test_data_for_home()
    {
        return $some_data = [
            'message' => time()
        ];
    }

    function update_user_session_period()
    {
        $time = 0;
        if (Core::is_user_authorized()) {
            $time = time();
            Core::$redis_db->hSet('user:' . Core::get_current_user_profile()->id . ':vay_data', 'last_seen', $time);
        }

        return [
            'time' => $time
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

        unset($info->password, $info->session_id, $info->fields_to_edit, $info->cl_name);

        return [
            $info
        ];
    }

    function get_user_contacts()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, ['options' => ['default' => 0, 'min_range' => 1, 'max_range' => PHP_INT_MAX]]);
        if (!$id || is_null($id) || $id == 0) {
            return null;
        }

        return Core::$redis_db->sMembers('user:' . $id . ':contacts:ids');
    }

    function get_user_projects($id = null)
    {
        if(!is_null($id))
            $_GET['id'] = $id;

        $projects_ids = Core::get_db()->Query("select id from main.projects where owner = $1", [$_GET['id']]);
        if(sizeof($projects_ids) == 0)
            Core::throw_error('У пользователя нет проектов');

        $projects = [];
        $idle_project = new Projects_api();

        foreach($projects_ids as $project_id)
        {
            $projects[] = $idle_project->get($project_id);
        }

        return $projects;

    }

    static function get_user_achievements($id = null)
    {

        if($id == null)
            $id = Core::get_current_user_profile()->id;

        $count = Core::$redis_db->zSize('user:'.$id.':site_achievements');
        if($count == 0)
            return 0;

        $achievements = Core::$redis_db->zRange('user:'.$id.':site_achievements', 0, -1, false);

        foreach($achievements as $key => $achievement_id)
        {
            $achievement = Achievements_api::get_for_user_profile($achievement_id);
            $achievement->time = Core::$redis_db->hGet('user:'.$id.':site_achievements:'.$achievement_id, 'time');
            $achievements[$key] = $achievement;
        }

        return $achievements;
    }

    static function get_user_players_count_on_all_projects()
    {
        return '<b>[ в разработке ]</b>';
        return Core::$redis_db->hGet('user:'.Core::get_current_user_profile()->id.':stats', 'players_count');
    }

    static function get_site_team_users()
    {
        return Core::get_db()->Query("select * from main.site_team");
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

    function email_approving()
    {
        $email = $_POST['email'];
        $check = Core::$db->Query('select * from main.users where email = $1', [$email], true);

        if(is_array($check) && sizeof($check)>0)
            return [
                'message' => 'email_had_registered'
            ];

        $hash = uniqid();
        Core::$db->Query('update main.users set email = $1 where id = $2', [$email, Core::get_current_user_profile()->id]);
        Core::$db->Query('insert into users.email_approving (user_id, hash) values ($1, $2)', [Core::get_current_user_profile()->id, $hash]);
        $to      = $email;
        $subject = 'MCTop: подтверждение адреса электронной почты';
        $message = "<a href='http://online.mctop.im/user/approve_email/{$hash}'>Подтвердить адрес электронной почты</a>";
        $headers = "From: wm@mctop.im\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        mail($to, $subject, $message, $headers);

        return
            [
                'message' => 'success'
            ];
    }


}
