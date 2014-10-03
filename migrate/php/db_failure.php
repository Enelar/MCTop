<?php

class db_failure
{
  private $name;
  private $e;

  public function __construct($name, $e = null)
  {
    $this->name = $name;
    $this->e = $e;
  }

  public static function __callStatic($f, $arg)
  {
    phoxy_protected_assert(false, ["error" => "DB Failure at {$this->name}::$f", "exception" => $this->e]);
  }

  public function __call($f, $arg)
  {
    phoxy_protected_assert(false, ["error" => "DB Failure at {$this->name}->$f", "exception" => $this->e]);
  }
}