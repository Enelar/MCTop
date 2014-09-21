<?php

class Users extends API
{
    function authorize()
    {
        API::check_for_post_request();

        $user = User::find_user_by_login($_POST['login']);
        if(sizeof($user) == 0)
            $user = User::find_user_by_id($_POST['login']);

        $message = (md5($_POST['password']) == $user['salted_password']) ? 'success' : 'fail';

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
        //141094196054194408f28c2
        $password = uniqid(time());
        $salted_password = md5($password);

        Core::$db->Query("insert into main.users (salted_password) values ($1)", [$salted_password]);
        $user = Core::$db->Query("select * from main.users where salted_password = $1 order by id desc", [$salted_password], true);

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
        header('Location: http://mctop.ru');
    }

    function edit_profile()
    {
        API::is_user_authorized_and_is_not_empty_post_request();

        $user = new User(Core::get_db());
        $user->get_user(intval($_POST['user_id']));

        $fields = explode(', ', $user->fields_to_edit);
        $changed_fields = [];

        foreach ($fields as $key => $field) {
            if ($field != 'password' && $user->$field != $_POST[$field]) {
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
        $time = 0;
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

}
