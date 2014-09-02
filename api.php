<?php
require_once('core/libs/TheX.php');
define('DEBUG', 0);
ini_set('display_errors', 'yes');
include('core/core.php');
include('core/systems/_db.php');
include('db/user.php');
include('db/Servers.php');
include('db/Projects.php');
$core = new Core('api');

if (isset($_GET['module']) & isset($_GET['action'])) {
    $file_address = 'api/' . ucfirst($_GET['module']) . '.php';
    if (file_exists($file_address)) {
        if ($_GET['module'] == 'im' or $_GET['module'] == 'notifications') {
            require_once('api/Im.php');
            require('core/libs/CometServerApi.php');
        }
        require_once($file_address);
        $class_name = ucfirst($_GET['module']);
        $object = new $class_name;

        if (in_array($_GET['action'], get_class_methods($class_name)))
            Api::answer($object->$_GET['action']());
        //else
        //if($_SERVER['REQUEST_METHOD'] != 'get')
        //    Api::answer(array('error' => 'Method is not exists'));
    }
}

exit();

class Api
{

    static public function answer($object)
    {
        echo json_encode($object);
    }

    static function check_for_post_request()
    {
        if (sizeof($_POST) == 0) {
            self::answer(array(
                'message' => 'Empty post request'
            ));
            die();
        }
    }

    static function is_user_authorized_and_is_not_empty_post_request()
    {
        if (!Core::is_user_authorized())
            die();

        Api::check_for_post_request();
    }

    static function abort($object)
    {
        self::answer($object);
        die();
    }
}
