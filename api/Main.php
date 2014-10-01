<?php

// Для того что бы не запутаться при мигрировании
class Main extends api
{
    protected function reserve()
    {
      Core::get_db()->Query("SELECT 1");
      unset($this->addons['result']);
      return
      [
        "design" => "main/index",
        "script" => ["main/segment.io", "main/url-hook"],
      ];
    }

    protected function home_page()
    {
      return
      [
        "design" => "example/home_page"
      ];
    }

    protected function faq()
    {
      return
      [
        "design" => "main/pages/faq"
      ];
    }
}