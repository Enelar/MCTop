<?php

error_reporting(E_ALL);
ini_set('display_errors','On');

include_once('migrate/php/core.php');
$instance = new Core();

function phoxy_conf()
{
  $ret = phoxy_default_conf();
  $ret["ejs_dir"] = "/migrate/design";
  $ret["js_dir"] = "/migrate/js";
  global $_SERVER;
  $ret["ip"] = $_SERVER["HTTP_X_REAL_IP"];
  return $ret;
}

function default_addons( $name )
{
  $ret =
  [
    "cache" => ["no"],
    "result" => "phoxy_canvas",
    "breadcrumbs" => breadcrumbs(),
  ];

  return $ret;
}

function breadcrumbs()
{
    global $_GET;
    $url = $_GET[phoxy_conf()["get_api_param"]];

    $array = explode("/", $url);
    $runner = Core::get_settings()->breadcrumbs;

    $ret = ["/" => "Главная"];

    $moan = "";
    foreach ($array as $stone)
    {
      $moan .= "/".$stone;

      if (!isset($runner[$stone]))
      {
        $ret[$moan] = $stone;
        $runner = [];
        continue;
      }

      $runner = $runner[$stone];

      if (is_array($runner) || is_object($runner))
        $sign = $runner[0];
      else
      {
        $sign = $runner;
        $runner = [];
      }

      if ($sign === false)
        continue;
      //if ($sign === true)
      // append to previous one
      //if ($sign === null)
      // wait for next and append      
      $ret[$moan] = $sign;
    }

    if (isset($ret['/Main']))
    {
      $ret['/'] = $ret['/Main'];
      unset($ret['/Main']);
    }

    return $ret; 
}

include('core/libs/phoxy/index.php');