<?php

error_reporting(E_ALL);
ini_set('display_errors','On');

function phoxy_conf()
{
  $ret = phoxy_default_conf();
  $ret["ejs_dir"] = "/migrate/design";
  $ret["js_dir"] = "/migrate/js";
  return $ret;
}

function default_addons( $name )
{
  $ret =
  [
    "cache" => ["no"],
    "result" => "phoxy_canvas",
  ];

  return $ret;
}

include('core/libs/phoxy/index.php');