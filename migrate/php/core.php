<?php

class Core
{
    private static $db;
    private static $redis_db;
    private static $_session;
    private static $settings;
    private static $_current_user;
    private static $_called_module_name;
    public $router;
    public $user;
    public $user_session;

    function __construct()
    {
        $this->init_session();
        $this->load_settings();
        $this->init_dbs();
    }

    private function init_session()
    {
        session_start();
        self::$_session = $_SESSION;
    }

    private function load_settings()
    {
        require_once('core/settings.php');
        self::$settings = $settings;
    }

    private function init_redis_db()
    {
        try
        {
          self::$redis_db = new Redis();
          self::$redis_db->connect(self::$settings->db['redis']['server_address'], self::$settings->db['redis']['redis_server_port']);
          self::$redis_db->select(self::$settings->db['redis']['db_number']);
          return;
        }
        catch (RedisException $e) {}
        catch (Exception $e) {}

        include_once('db_failure.php');
        self::$redis_db = new db_failure('redis');
    }

    private function init_postgres_db()
    {
        try
        {
          include_once('core/libs/phpsql/phpsql.php');
          include_once('core/libs/phpsql/pgsql.php');
          $sql = new phpsql();
          $pg = $sql->Connect("pgsql://postgres@127.0.0.1/mctop");
          include_once('pg_wrap.php');
          self::$db = new pg_wrap($pg);
          return;
        } catch (Exception $e) {}

        include_once('db_failure.php');
        self::$db = new db_failure('postgresql');
    }

    private function init_dbs()
    {
        $this->init_redis_db();
        $this->init_postgres_db();
    }

    private function enable_debug_features()
    {
        ini_set('display_errors', 'yes');
        var_dump($_GET);
        echo '<br>';
        var_dump($_POST);
        echo '<br><b>XCoreQueryHanlder:</b> initializng of '.self::$_called_module_name. ' module<br>';
    }

    // @Deprecated
    private function define_called_module()
    {
        $module = $_GET['module'];

        $slash_position = strpos($module, '/');

        if (!$slash_position)
            $slash_position = strlen($module);

        return self::$_called_module_name = substr($module, 0, $slash_position);
    }

    // @Deprecated
    private function is_module_exists($module)
    {
        return array_key_exists($module, $this->get_all_modules_from_settings());
    }

    // @Deprecated
    private function get_all_modules_from_settings()
    {
        $modules = [];

        foreach (Core::get_settings()->modules as $key => $settings_module)
            $modules[$key] = 'gg';

        return $modules;
    }

    static function get_current_user_profile()
    {
        return LoadModule('api', 'Users')->info();
    }

    static function is_user_authorized()
    {
        return LoadModule('api', 'Users')-> is_user_authorized();
    }

    static function get_session()
    {
        return Core::$_session;
    }

    static function get_db()
    {
        return self::$db;
    }

    static function get_redis()
    {
        return self::$redis_db;
    }

    static function get_settings()
    {
        return self::$settings;
    }

    static function is_ajax_request()
    {
        return true;
    }

    // @Deprecated
    function render_page($module, $action)
    {
        if($action != 'footer')
        {
            $modules = new Modules_names();

            if(isset($_GET['id']))
                $entity_id = $_GET['id'];

            /*echo '
            <ol class="breadcrumb">
            <li>
                <a onclick="display_page(\''.$_GET['module'].'\', \'index\')">'.$modules->try_get_module_info()->name.'</a>
            </li>
            <li class="active">
                '.$modules->try_get_module_action_info()->name.'
            </li>
            </ol>';*/
        }
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

    static function json_encode_cyr($str) {
        $arr_replace_utf = array('\u0410', '\u0430','\u0411','\u0431','\u0412','\u0432',
            '\u0413','\u0433','\u0414','\u0434','\u0415','\u0435','\u0401','\u0451','\u0416',
            '\u0436','\u0417','\u0437','\u0418','\u0438','\u0419','\u0439','\u041a','\u043a',
            '\u041b','\u043b','\u041c','\u043c','\u041d','\u043d','\u041e','\u043e','\u041f',
            '\u043f','\u0420','\u0440','\u0421','\u0441','\u0422','\u0442','\u0423','\u0443',
            '\u0424','\u0444','\u0425','\u0445','\u0426','\u0446','\u0427','\u0447','\u0428',
            '\u0448','\u0429','\u0449','\u042a','\u044a','\u042b','\u044b','\u042c','\u044c',
            '\u042d','\u044d','\u042e','\u044e','\u042f','\u044f');
        $arr_replace_cyr = array('А', 'а', 'Б', 'б', 'В', 'в', 'Г', 'г', 'Д', 'д', 'Е', 'е',
            'Ё', 'ё', 'Ж','ж','З','з','И','и','Й','й','К','к','Л','л','М','м','Н','н','О','о',
            'П','п','Р','р','С','с','Т','т','У','у','Ф','ф','Х','х','Ц','ц','Ч','ч','Ш','ш',
            'Щ','щ','Ъ','ъ','Ы','ы','Ь','ь','Э','э','Ю','ю','Я','я');
        $str1 = json_encode($str, JSON_PRETTY_PRINT);
        $str2 = str_replace($arr_replace_utf,$arr_replace_cyr,$str1);
        return $str2;
    }

    static function log_post_request()
    {
        if(isset($_POST['password']))
            $_POST['password'] = md5($_POST['password']);
        Core::$db->Query('insert into logs.post (ip, json, url) values ($1, $2, $3)', [$_SERVER['REMOTE_ADDR'], json_encode($_POST, JSON_UNESCAPED_UNICODE), $_SERVER['REQUEST_URI']]);
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
