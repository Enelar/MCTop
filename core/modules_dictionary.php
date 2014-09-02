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
        if (isset($this->modules[$name]))
            return 1;
        else
            return 0;
    }

}
