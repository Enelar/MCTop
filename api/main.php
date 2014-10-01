<?php

// Для того что бы не запутаться при мигрировании
class main extends api
{
    protected function Reserve()
    {
      return
      [
        "design" => "main/index"
      ];
    }

    protected function home_page()
    {

    }
}