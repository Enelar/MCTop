<?php
require_once('core/libs/TheX.php');
define('DEBUG', 0);
ini_set('display_errors', 'yes');
include('core/core.php');
include('core/API.php');
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
            API::answer($object->$_GET['action']());
        //else
        //if($_SERVER['REQUEST_METHOD'] != 'get')
        //    Api::answer(array('error' => 'Method is not exists'));
    }
}
