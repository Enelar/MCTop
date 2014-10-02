<?php

/*
 * return ['databases' => [...], 'modules' => [...], ...];
 */

class Settings
{

    public function __construct()
    {
        $settings = array(
            'databases' => array(
                'db' => array(
                    'postgres' => array(
                        'server_address'    => '127.0.0.1',
                        'server_port'       => '5432',
                        'user_name'         => 'postgres',
                        'password'          => '',
                        'working_base_name' => 'mctop',
                    ),
                    'redis' => array(
                        'server_address' => '127.0.0.1',
                        'using_password' => false,
                        'user_name' => 'root',
                        'redis_server_port' => 6379,
                        'db_number' => 2,
                    )
                ),
            ),

            'modules' => array(
                'main' => new Object(
                        array(
                            'show_in_navbar' => false
                        )
                    ),
                'news' => new Object(
                        array(
                            'show_in_navbar' => true,
                            'show_to_authorized' => true,
                            'show_to_guest' => false,
                            'name' => 'Новости',
                            'icon' => 'glyphicon glyphicon-volume-up',
                            'link' => '/News'
                        )
                    ),
                'projects_rating' => new Object(
                        array(
                            'show_in_navbar' => true,
                            'show_to_authorized' => true,
                            'show_to_guest' => true,
                            'name' => 'Проекты',
                            'icon' => 'glyphicon glyphicon-star',
                            'link' => '/'
                        )
                    ),
                'rating' => new Object(
                        array(
                            'show_in_navbar' => true,
                            'show_to_authorized' => true,
                            'show_to_guest' => false,
                            'name' => 'Серверы',
                            'icon' => 'glyphicon glyphicon-home',
                            'link' => '/Servers/list'
                        )
                    ),
                'search' => new Object(
                        array(
                            'show_in_navbar' => true,
                            'show_to_authorized' => true,
                            'show_to_guest' => true,
                            'name' => 'Поиск',
                            'icon' => 'glyphicon glyphicon-search',
                            'link' => '/Search'
                        )
                    ),
                'outdoor' => new Object(
                        array(
                            'show_in_navbar' => true,
                            'show_to_authorized' => false,
                            'show_to_guest' => true,
                            'name' => 'Авторизация',
                            'icon' => 'glyphicon glyphicon-lock',
                            'link' => '/Users/login_page'
                        )
                    ),
                'registration' => new Object(
                        array(
                            'show_in_navbar' => true,
                            'show_to_authorized' => false,
                            'show_to_guest' => true,
                            'name' => 'Регистрация',
                            'icon' => 'glyphicon glyphicon-plus',
                            'link' => '/Users/register_page'
                        )
                    ),
                'social' => new Object(
                        array(
                            'show_in_navbar' => false
                        )
                    ),
                'control_panel' => new Object(
                        array(
                            'show_in_navbar' => false
                        )
                    ),
                'why' => new Object(
                        array(
                            'show_in_navbar' => true,
                            'show_to_authorized' => false,
                            'show_to_guest' => true,
                            'icon' => 'glyphicon glyphicon-repeat',
                            'name' => 'Почему?',
                            'link' => '/Main/why'
                        )
                    ),
                'api' => new Object(
                        array(
                            'show_in_navbar' => false,
                            'icon' => 'glyphicon glyphicon-picture',
                        )
                ),
            ),

            'application' => [

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

                'friends' => [
                    'http://topcraft.ru' => '...',
                    'http://minecraft-servera.ru' => '...',
                    'http://want2vote.com' => '...',
                    'http://mctop.ru/friends' => 'Стать другом'
                ],

                'official_wiki' => '',
                'russian_wiki' => '',

                'image_prefix' => "./../img/",
            ],

            'engine' => [
                'name' => 'VoP', // (Vay on Phoxy)
                'version' => '0.2',
            ],

        );

        $this->db = $settings['databases']['db'];
        $this->application = $settings['application'];
        $this->modules = $settings['modules'];
        $this->engine = $settings['engine'];

    }
}

$settings = new Settings();
