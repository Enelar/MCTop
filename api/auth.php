<?php

class auth extends api
{
    protected function Reserve()
    {
        return
        [
            "design" => "auth/index"
        ];
    }

    protected function DoIt()
    {
        // One click auth?
    }
}