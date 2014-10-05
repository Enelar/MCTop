<?php

/*
 * return ['databases' => [...], 'modules' => [...], ...];
 */

class Settings
{
    private $settings = false;

    public function __invoke()
    {
        if (!$this->settings)
            $this->settings = $this->init();
        return $this->settings;
    }

    private function init()
    {
        $settings =
        [
            'db' =>
            [
                'connect_url' => 'pgsql://postgres@127.0.0.1/mctop',
                'redis' =>
                [
                    'server_address' => '127.0.0.1',
                    'using_password' => false,
                    'user_name' => 'root',
                    'redis_server_port' => 6379,
                    'db_number' => 2,
                ],
            ],

            'modules' =>
            [
                'main' =>
                [
                    'show_in_navbar' => false,
                ],
                'news' =>
                [
                    'show_in_navbar' => true,
                    'show_to_authorized' => true,
                    'show_to_guest' => false,
                    'name' => 'Новости',
                    'icon' => 'glyphicon glyphicon-volume-up',
                    'link' => '/News',
                ],
                'projects_rating' =>
                [
                    'show_in_navbar' => true,
                    'show_to_authorized' => true,
                    'show_to_guest' => true,
                    'name' => 'Проекты',
                    'icon' => 'glyphicon glyphicon-star',
                    'link' => '/',
                ],
                'rating' =>
                [
                    'show_in_navbar' => true,
                    'show_to_authorized' => true,
                    'show_to_guest' => false,
                    'name' => 'Серверы',
                    'icon' => 'glyphicon glyphicon-home',
                    'link' => '/Servers/list',
                    ],
                'search' =>
                [
                    'show_in_navbar' => true,
                    'show_to_authorized' => true,
                    'show_to_guest' => true,
                    'name' => 'Поиск',
                    'icon' => 'glyphicon glyphicon-search',
                    'link' => '/Search',
                ],
                'outdoor' =>
                [
                    'show_in_navbar' => true,
                    'show_to_authorized' => false,
                    'show_to_guest' => true,
                    'name' => 'Авторизация',
                    'icon' => 'glyphicon glyphicon-lock',
                    'link' => '/Users/login_page',
                ],
                'registration' =>
                [
                    'show_in_navbar' => true,
                    'show_to_authorized' => false,
                    'show_to_guest' => true,
                    'name' => 'Регистрация',
                    'icon' => 'glyphicon glyphicon-plus',
                    'link' => '/Users/register_page',
                ],
                'social' =>
                [
                    'show_in_navbar' => false,
                ],
                'control_panel' =>
                [
                    'show_in_navbar' => true,
                    'show_to_authorized' => true,
                    'show_to_guest' => false,
                    'name' => 'Панель управления',
                    'icon' => 'glyphicon glyphicon-plus',
                    'link' => '/ControlPanel',
                ],
                'why' =>
                [
                    'show_in_navbar' => true,
                    'show_to_authorized' => false,
                    'show_to_guest' => true,
                    'icon' => 'glyphicon glyphicon-repeat',
                    'name' => 'Почему?',
                    'link' => '/Main/why',
                ],
                'api' =>
                [
                    'show_in_navbar' => false,
                    'icon' => 'glyphicon glyphicon-picture',
                ],
            ],

            'application' =>
            [
                'site_domain' => 'mctop.im',
                'site_name' => 'MCTop',
                'title_content' => 'MCTop - Minecraft сервера',
                'game' => 'Minecraft',
                'official_game_site' => 'http://minecraft.net',

                'official_site_vay_club' => '',
                'official_site_facebook_public' => '',
                'official_site_vk_public' => '',

                'official_game_vay_club' => '',
                'official_game_facebook_public' => '',
                'official_game_vk_public' => '',

                'friends' =>
                [
                    'http://topcraft.ru' => '...',
                    'http://minecraft-servera.ru' => '...',
                    'http://want2vote.com' => '...',
                    'http://mctop.ru/friends' => 'Стать другом',
                ],

                'official_wiki' => '',
                'russian_wiki' => '',

                'image_prefix' => "./../img/",
            ],

            'engine' =>
            [
                'name' => 'VoP', // (Vay on Phoxy)
                'version' => '0.2',
            ],

        ];

        include_once('migrate/php/pg_wrap.php');

        $settings = new row_wraper($settings);

        return $settings;
    }
}