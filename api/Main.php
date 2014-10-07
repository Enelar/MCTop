<?php

// Для того что бы не запутаться при мигрировании
class Main extends api
{
    protected function reserve()
    {
      unset($this->addons['result']);
      return
      [
        "design" => "main/index",
        "script" =>
        [
          "main/segment.io",
          "main/url-hook",
          "main/jquery.form.patch",
          "libs/bootstrap",
        ],
      ];
    }

    protected function navbar_links()
    {
        return
        [
            "design" => "main/navbar",
            "data" =>
            [
                "links" => Core::get_settings()->modules,
                "is_user_authorized" => LoadModule('api', 'Users')->is_user_authorized(),
            ],
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

    protected function why()
    {
        return
            [
                "design" => "main/pages/why"
            ];
    }

}