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

    private function login($id)
    {
        $this->get_login();
        global $_SESSION;
        return $_SESSION['uid'] = $id;
    }

    private function get_login()
    {
        if (session_status() !== PHP_SESSION_ACTIVE)
            session_start();
        global $_SESSION;
        return $_SESSION['uid'];
    }

    protected function logout()
    {
        $this->login(0);
        return
        [
            'reset' => true,
        ];
    }

    protected function authorize()
    {
        global $_POST;

        $user = Core::get_db()->Query("SELECT * FROM main.users WHERE login=$1", [$_POST['login']], true);

        if (!$user)
            return false;

        if (!password_verify($_POST['password'], $user->password))
            return false;    

        if (password_needs_rehash($user->password, PASSWORD_DEFAULT))
        {
            $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            if ($hash != false)
                db::Query("UPDATE main.users SET password=$2 WHERE id=$1", [$user->id], $hash);
        }

        // ?? $_SESSION['last_update'] = time();
        // ?? $_SESSION['session_id'] = md5($user['id'] . 'salt');

        return 
        [
          "data" => ["authorize" => $this->login($user->id)],
          "reset" => true,
        ];
    }

    protected function register()
    {
        global $_POST;

        // оригинальная почта
        $email = $_POST['email'];
        // секретное слово для проверки почты
        $hashed_email = password_hash($email, PASSWORD_DEFAULT);
        // сохраненный пароль
        $hashed_pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        // публичное слово для проверки почты
        $email_token = password_hash($hashed_email, PASSWORD_DEFAULT);

        phoxy_protected_assert
        (
            Core::get_db()->Query("select * from main.users where email=$1", [$email]),
            ["error" => "Email already registered"]
        );
        // Не важно что будут еще регистрации, в процессе, главное что бы могла завершиться только одна
        $res = Core::get_db()->Query("insert into main.users (email, password) values ($1, $2) returning id",
            [$hashed_email, $salted_password], true);

        phoxy_protected_assert(isset($res['id']), ["error" => "Something went wrong"]);

        $params = http_build_query
        ([
            "id" => $res['id'],
            "email" => rawurlencode($email),
            "token" => $email_token,
        ]);
        $verify_url = phoxy_conf()['site']."/Users/email_approving?{$params}";
        $cancel_url = phoxy_conf()['site']."/Users/CancelEmail?{$params}";

        $to      = $email;
        $subject = 'MCTop: подтверждение адреса электронной почты';
        $message = "<a href='http://online.mctop.im/user/approve_email/{$hash}'>Подтвердить адрес электронной почты</a>";
        $headers = "From: wm@mctop.im\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        return true;//LoadModule('api/utils', 'Mail')->Send();
    }

    private function info($id)
    {
        return db::Query("SELECT * FROM main.users WHERE id=$1", [$id], true);
    }

    protected function email_approving($id, $email, $token)
    {
        $row = $this->info($id);

        if (!password_verify($row->email, $token))
            return false; // Наш секрет не подошел для проверки публичного слова. Валидация провалена
        // Регистрация разрешена
        if (!password_verify($email, $row->email))
            return false; // Их емаил не подошел для нашего секрета. Мы не можем доверять этому адресу.

        $res = Core::$db->Query('update main.users set email=$2 WHERE id=$1 RETURNING id', [$id, $email], true);
        if (!$res)
            return false;
        return $this->login($res['id']);
    }


    protected function login_page()
    {
        return
            [
                "design" => "social/user/login_page",
            ];
    }

    protected function register_page()
    {
        return
        [
            "design" => "social/user/register_page",
        ];
    }
}
