<?php
class CoreUtils extends api
{
    protected function get_module_icon($name)
    {
        return Core::get_settings()->modules[$name]->icon;
    }

    protected function get_engine_info()
    {
        return
        [
            "data" => Core::get_settings()->engine
        ];
    }
}