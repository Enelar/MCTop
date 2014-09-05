<?php

class Core extends X
{

    public static $db;
    public static $redis_db;
    private static $_session;
    private static $settings;
    private static $_current_user;
    public $router;
    public $user;
    public $user_session;

    function __construct()
    {
        $this->init_session();
        $this->load_settings();
        $this->init_dbs();

        if (substr($_SERVER['REQUEST_URI'], 0, 8) != '/api.php')
            $this->handleQuery();
    }

    private function init_session()
    {
        session_start();
        self::$_session = $_SESSION;
    }

    private function load_settings()
    {
        require_once('settings.php');
        self::$settings = $settings;
    }

    private function init_redis_db()
    {
        self::$redis_db = new Redis();
        self::$redis_db->connect(self::$settings->db['redis']['server_address'], self::$settings->db['redis']['redis_server_port']);
        self::$redis_db->select(self::$settings->db['redis']['db_number']);
    }

    private function init_postgres_db()
    {
        include_once('libs/phpsql/phpsql.php');
        include_once('libs/phpsql/pgsql.php');
        $sql = new phpsql();
        $pg = $sql->Connect("pgsql://postgres@127.0.0.1/mctop");
        self::$db = $pg;
    }

    private function init_dbs()
    {
        $this->init_redis_db();
        $this->init_postgres_db();
    }

    function handleQuery()
    {
        if (isset($_GET['module'])) {
            if ($this->is_module_exists($this->define_called_module())) {
                if (DEBUG) {
                    $this->enable_debug_features();
                } else
                    ini_set('display_errors', 'no');
            } else
                throw new Exception('Some error had occured');
        }
    }

    private function enable_debug_features()
    {
        ini_set('display_errors', 'yes');
        var_dump($_GET);
        echo '<br>';
        var_dump($_POST);
        echo '<b>XCoreQueryHanlder:</b> initializng of '.$module. ' module<br>';
    }

    private function define_called_module()
    {
        $module = $_GET['module'];

        $slash_position = strpos($module, '/');
        if (!$slash_position)
            $slash_position = strlen($module);

        return substr($module, 0, $slash_position);
    }

    private function is_module_exists($module)
    {
        return array_key_exists($module, $this->get_all_modules_from_settings());
    }

    private function get_all_modules_from_settings()
    {
        $modules = [];

        foreach (Core::get_settings()->modules as $key => $settings_module)
            $modules[$key] = 'gg';

        return $modules;
    }

    static function get_current_user_profile()
    {
        if(sizeof(self::$_session)>0)
        {
            if (empty(self::$_current_user)) {
                $user = new User(self::$db);
                $user->get_user(self::$_session['uid']);
                self::$_current_user = $user;
            } else
                $user = self::$_current_user;
            return $user;
        }

        return false;
    }

    static function is_user_authorized()
    {
        return (sizeof(self::get_session()) > 0 && self::get_session()['uid'] > 0);
    }

    static function get_session()
    {
        return Core::$_session;
    }

    static function get_db()
    {
        return self::$db;
    }

    static function get_settings()
    {
        return self::$settings;
    }

    static function is_ajax_request()
    {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }

    function render_page($module, $action)
    {
        if (file_exists(ROOT_DIR . '/design/modules/' . $module . '/' . $action . '.php'))
            require_once(ROOT_DIR . '/design/modules/' . $module . '/' . $action . '.php');
        else
            Core::throw_error('Страница не найдена.<br><br>А кто сказал что она вообще существует?');
    }

    static function throw_error($message = null, $title = 'Ошибка 404')
    {
        if (is_null($message))
            $message = 'Страница не найдена';

        echo '<h1><span class="glyphicon glyphicon-remove"></span> ' . $title . ' </h1><hr> ' . $message;
        die();
    }

}

class Object
{

    function __construct(array $array)
    {
        if (sizeof($array) > 0) {
            foreach ($array as $key => $value)
                $this->$key = $value;
        }
    }

}
