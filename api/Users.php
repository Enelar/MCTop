<?php

class Users extends API
{
    public function uid()
    {
        phoxy_protected_assert($this->is_user_authorized(), ["error" => "Auth required"]);
        return $this->get_uid();
    }

    public  function get_uid()
    {
        global $_session;

        if (isset($_SESSION['uid']))
            return $_SESSION['uid'];
        return false;
    }

    protected function store_uid()
    {
        return
        [
          "uid" => $this->get_uid(),
          "script" => "main/uid",
          "routeline" => "store_uid",
        ];
    }

    public function is_user_authorized()
    {
        return !!$this->get_uid();
    }

    public function get_current_user_profile()
    {
        return $this->get_uid();
    }

    public function login($id)
    {
        $this->get_login($id);
        global $_SESSION;
        return $_SESSION['uid'] = $id;
    }

    private function get_login($id = null)
    {
        if (session_status() !== PHP_SESSION_ACTIVE)
            session_start();
        global $_SESSION;

        //undefined index 'uid' без 43 и 44 строки, при подтверждении email

        if(!is_null($id))
            $_SESSION['uid'] = $id;
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

    private function info($id)
    {
        return Core::get_db()->Query("SELECT * FROM main.users WHERE id=$1", [$id], true);
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

    protected function test()
    {
        var_dump($_SESSION);
    }
}
