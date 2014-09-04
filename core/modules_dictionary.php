<?php

class modules_dictionary
{

    function __construct()
    {
        $this->modules = array(
            'main' => 'Основной "Преддверный" модуль',
            'social' => 'Социальный модуль',
            'features' => array(
                'notes' => 'Заметки'
            ),
            'api' => 'API for Vay'
        );
    }

    function in_dictionary($name)
    {
        return isset($this->modules[$name]);
    }

}
