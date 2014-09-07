<?php

    class Modules_names
    {
        private $modules_names;
        private $action_names;

        public function __construct()
        {
            $this->modules_names = [
              'videos'  => new Object([
                'name'  => 'Видео'
              ]),
              'search'  => new Object([
                'name'  => 'Поиск'
              ]),
              'control_panel'  => new Object([
                'name'  => 'Панель управления'
              ]),
              'news'  => new Object([
                'name'  => 'Новости'
              ]),
            ];

            $this->action_names = [

                // Search
                'news/index'  => new Object([
                        'name'  => 'Главная страница'
                ]),

                // Videos
                'videos/index'  => new Object([
                        'name'  => 'Главная страница'
                ]),

                // Search
                'search/index'  => new Object([
                        'name'  => 'Главная страница'
                ]),
            ];
        }

        public function try_get_module_info()
        {
            return isset($this->modules_names[$_GET['module']])? $this->modules_names[$_GET['module']] : new Object([
            //'name' => 'Необходимо внести название модуля в /design/texts/modules/ ... modules_names'
            'name' => $_GET['module']
        ]);
        }

        public function try_get_module_action_info()
        {
            return isset($this->action_names[$_GET['module'].'/'.$_GET['action']])? $this->action_names[$_GET['module'].'/'.$_GET['action']] : new Object([
            //'name' => 'Необходимо внести название действия в /design/texts/modules/ ... action_names'
            'name' => $_GET['action']
        ]);
        }
    }