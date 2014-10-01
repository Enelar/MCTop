<?php

// Для того что бы не запутаться при мигрировании
class main extends api
{
    protected function Reserve()
    {
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
        "design" => "example/faq"
      ];
    }
}