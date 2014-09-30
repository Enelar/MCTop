<?php

ini_set('display_errors', 'no');

define('ROOT_DIR', __DIR__);
require_once 'core/bootstrap.php';

if (isset($_GET['module'], $_GET['action'])) {
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
