<?php

class Core extends X
{

    public static $db;
    public static $redis_db;
    private static $_session;
    private static $_user;
    private static $settings;
    private static $_current_user;
    public $router;
    public $user;
    public $user_session;

    function __construct()
    {
        session_start();
        self::$_session = $_SESSION;

        require_once('settings.php');
        self::$settings = $settings;

        self::$redis_db = new Redis();
        self::$redis_db->connect($settings->db['redis']['server_address'], $settings->db['redis']['redis_server_port']);
        self::$redis_db->select($settings->db['redis']['db_number']);

        if (substr($_SERVER['REQUEST_URI'], 0, 8) != '/api.php')
            $this->handleQuery();
    }

    function handleQuery()
    {
        if (!isset($_GET['module'])) {
            $module = 'main';
        } else {
            $module = $_GET['module'];
            $slash_position = strpos($module, '/');
            if (!$slash_position)
                $slash_position = strlen($module);
            $module = substr($module, 0, $slash_position);

            require_once('modules_dictionary.php');
            $dictionary = new modules_dictionary();

            $modules = [];
            foreach (Core::get_settings()->modules as $key => $settings_module)
                $modules[$key] = 'gg';

            if (array_key_exists($module, $modules)) {
                if (DEBUG) {
                    ini_set('display_errors', 'yes');
                    var_dump($_GET);
                    echo '<br>';
                    var_dump($_POST);
                    //echo '<b>XCoreQueryHanlder:</b> initializng of '.$module. ' module<br>';
                } else
                    ini_set('display_errors', 'no');
            } else
                throw new Exception('Some error had occured');
        }
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
        else
            return false;
    }

    static function is_user_authorized()
    {
        return (sizeof(self::get_session()) > 0 && self::get_session()['uid'] > 0) ? true : false;
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

    static function get_core_path()
    {
        return __DIR__;
    }

    function is_ajax_request()
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            return 1;
        else
            return 0;
    }

    function render_page($module, $action)
    {
        if (file_exists(ROOT_DIR . '/design/modules/' . $module . '/' . $action . '.php'))
            require_once(ROOT_DIR . '/design/modules/' . $module . '/' . $action . '.php');
        else
            Core::oups_sorry_404('Страница не найдена.<br><br>А кто сказал что она вообще существует?');
    }

    static function oups_sorry_404($message = null, $title = 'Ошибка 404')
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
