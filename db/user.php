<?php

class User extends X
{

    public $cl_name = 'User';

    public $id, $login, $email, $password, $name, $lastname, $hobby, $mobile_phone, $nickname, $city, $relationship_status, $status, $session_id;
    public $fields_to_edit = 'email, password, name, lastname, city, hobby, mobile_phone, nickname, relationship_status, status';

    function get_user($id)
    {

        $result = Core::get_db()->Query("select * from main.users where id = $1", [$id], true);

        if (!$result)
            Core::throw_error();

        foreach ($result as $key => $value)
            $this->$key = $value;

        return $this;
    }

    function get_user_by_login($login)
    {

        $sth = Core::get_db()->prepare("select * from users where login = '$login'");
        $sth->execute()
        or
        self::abort($sth);

        $result = $sth->fetch(PDO::FETCH_ASSOC);

        if (!$result)
            Core::throw_error();

        foreach ($result as $key => $value)
            $this->$key = $value;

        return $result;
    }

    static function get_user_info($id)
    {
        $id = intval($id);

        if (DEBUG)
            echo 'Getting user with id:' . $id . '<br>';

        $sth = Core::get_db()->prepare('select * from users where id = ' . $id);
        $sth->execute()
        or
        self::abort($sth);

        $result = $sth->fetch(PDO::FETCH_ASSOC);

        if (!$result)
            Core::throw_error();

        $user = new User();
        foreach ($result as $key => $value)
            $user->$key = $value;

        return $user;
    }

    static function find_user_by_login($login)
    {
        $login = strip_tags(htmlentities($login));

        return Core::get_db()->Query("select * from main.users where login = $1", [$login], true);
    }

    function display_name()
    {
        if (!empty($this->name))
            echo $this->name;
        else
            echo '..';
    }

    function display_lastname()
    {
        if (!empty($this->lastname))
            echo $this->lastname;
        else
            echo '..';
    }

    function display_hobby()
    {
        if (!empty($this->hobby))
            echo '<p>Хобби: ' . $this->hobby . '</p>';
    }

    function display_mobile_phone()
    {
        if (!empty($this->mobile_phone))
            echo '<p>Мобильный: ' . $this->mobile_phone . '</p>';
    }

    function display_relations()
    {
        if (!empty($this->relationship_status))
            echo '<p>Семейное положение: ' . $this->relationship_status . '</p>';
    }

    function display_city()
    {
        if (!empty($this->city))
            echo '<p>Город: ' . $this->city . '</p>';
    }

    //todo Fix injection around here

    function display_nickname()
    {
        if (!empty($this->nickname))
            echo '[' . $this->nickname . ']';
    }

    function display_reputation()
    {
        $reputation = 4;
        return '<p>' . '<a class="btn btn-success" onclick="display_page_with_id(\'social\', \'people/reputation\', \'' . $this->id . '\')"><span class="glyphicon glyphicon-adjust"></span></a> Репутация: ' . $reputation . '</p>';
    }

    function display_prestige()
    {
        $prestige = 4;
        return '<p>' . '<a class="btn btn-success"><span class="glyphicon glyphicon-ok-circle"></span></a> Престиж: ' . $prestige . '</p>';
    }

    function update_session_id($session_id, $user_id)
    {
        $sth = Core::get_db()->prepare("update users set session_id = '$session_id' where id = $user_id");
        $sth->execute()
        or
        self::abort($sth);
    }

    function add_user_to_contacts($who_wants_to_add, $user_id)
    {
        Core::$redis_db->sAdd('user:' . $who_wants_to_add . ':contacts:ids', $user_id);
    }

    function del_user_from_contacts($who_wants_to_delete, $user_id)
    {
        Core::$redis_db->sRem('user:' . $who_wants_to_delete . ':contacts:ids', $user_id);
    }

    static function is_user_online($user_id)
    {
        $last_seen = Core::$redis_db->hGet('user:' . intval($user_id) . ':vay_data', 'last_seen');
        if (time() - $last_seen < 20)
            return true;
        else
            return false;
    }

    static function get_all_users($limit, $offset = 0)
    {
        $sth = Core::get_db()->prepare("select * from users limit $limit offset $offset");
        $sth->execute()
        or
        X::abort($sth);

        $results = $sth->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $index => $user) {

            $idle_user = new User();

            //todo вместо 115 строчки написать X->reset_object_fields();

            foreach ($user as $key => $value)
                $idle_user->$key = $value;

            $results[$index] = $idle_user;
        }

        return $results;
    }

    static function get_users_for_community_page($page, $limit = 10)
    {
        $_offset = $page * 10;

        $result = Core::get_db()->Query("select * from main.users limit $1", [$limit]);
        $users = [];

        foreach ($result as $user) {
            $idle_user = new User();

            foreach ($user as $key => $value)
                $idle_user->$key = $value;

            $users[] = $idle_user;
        }

        return $users;
    }

    static function get_user_bank_transactions()
    {
        $transactions_count = Core::$redis_db->zCard('user:'.Core::get_current_user_profile()->id.':bank:transactions');
        if($transactions_count>0)
        {
            $transactions = [];
            $transactions_keys = Core::$redis_db->keys('user:'.Core::get_current_user_profile()->id.':bank:transactions:*');

            foreach ($transactions_keys as $key)
                $transactions[] = User_Bank_Transactions::get_transaction($key);

            return $transactions;
        }
        return false;
    }

    static function get_user_balance()
    {
        $count = Core::$redis_db->get('user:'.Core::get_current_user_profile()->id.':bank:money_count');
        if(!$count)
        {
            Core::$redis_db->set('user:'.Core::get_current_user_profile()->id.':bank:money_count', 0);
            $count = 0;
        }
        return $count;
    }

}

class User_Bank_Transactions
{
    public $id, $name, $description, $time, $user;

    static function register_transaction($name, $description)
    {
        $transaction_id = Core::$redis_db->zCard('user:'.Core::get_current_user_profile()->id.':bank:transactions')+1;
        $transaction = new User_Bank_Transactions;
        $transaction->id = $transaction_id;
        $transaction->name = $name;
        $transaction->description = $description;
        $transaction->time = time();

        Core::$redis_db->zAdd('user:'.Core::get_current_user_profile()->id.':bank:transactions', $transaction_id, $transaction_id);

        foreach($transaction as $key => $value)
            if($key != 'user' and $key != 'id')
                Core::$redis_db->hSet('user:'.Core::get_current_user_profile()->id.':bank:transactions:'.$transaction_id,$key, $value);
    }

    static function get_transaction($id)
    {
        $_info = Core::$redis_db->hGetAll($id);
        if(sizeof($_info)>0)
        {
            $transaction = new User_Bank_Transactions();

            foreach($_info as $key => $value)
                $transaction->$key = $value;

            return $transaction;
        }
        return false;
    }
}
