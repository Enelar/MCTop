<?php

class pg_wrap
{
  private $obj;

  public function __construct($obj)
  {
    $this->obj = $obj;
  }

  public function __call($method, $args)
  {
    return call_user_func_array([$this->obj, $method], $args);
  }

  public function Query($query, $params = [], $one_row = false, $reindex_by = null)
  {
    $res = $this->obj->Query($query, $params, $one_row, $reindex_by);

    $row_array_to_obj = function($row)
    {
      return new row_wraper($row);
    };

    if ($one_row)
      return $row_array_to_obj($res);

    $ret = [];
    foreach ($res as $row)
      $ret[] = $row_array_to_obj($row);
    return $ret;
  }
}

class row_wraper
{
  private $original_row_array;
  
  public function __construct(&$row)
  {
    phoxy_protected_assert(is_array($row), "Row wrapper support only arrays");
    $this->original_row_array = $row;
  }

  public function __set ( $name , $value )
  {
    $o = &$this->original_row_array;
    $o[$name] = $value;
    return $this->__get($name);
  }

  public function __get ( $name )
  {
    $o = &$this->original_row_array;
    if (!isset($o[$name]))
      return null;
    if (!is_array($o[$name]))
      return $o[$name];
    return new row_wraper($o[$name]);
  }
}