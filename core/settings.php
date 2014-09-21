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
                            'name' => 'Новости',
                            'icon' => 'glyphicon glyphicon-volume-up',
                            'link' => 'news\', \'index'
                        )
                    ),
                'projects_rating' => new Object(
                        array(
                            'show_in_navbar' => true,
                            'show_to_authorized' => true,
                            'name' => 'Проекты',
                            'icon' => 'glyphicon glyphicon-star',
                            'link' => 'projects_rating\', \'index'
                        )
                    ),
                'rating' => new Object(
                        array(
                            'show_in_navbar' => true,
                            'show_to_authorized' => true,
                            'name' => 'Серверы',
                            'icon' => 'glyphicon glyphicon-home',
                            'link' => 'main\', \'index'
                        )
                    ),
                'search' => new Object(
                        array(
                            'show_in_navbar' => true,
                            'show_to_authorized' => true,
                            'name' => 'Поиск',
                            'icon' => 'glyphicon glyphicon-search',
                            'link' => 'search\', \'index'
                        )
                    ),
                'community' => new Object(
                        array(
                            'show_in_navbar' => true,
                            'show_to_authorized' => false,
                            'name' => 'Сообщество',
                            'icon' => 'glyphicon glyphicon-globe',
                            'link' => 'community\', \'index'
                        )
                    ),
                'videos' => new Object(
                        array(
                            'show_in_navbar' => false,
                            'show_to_authorized' => true,
                            'name' => 'Видео',
                            'icon' => 'glyphicon glyphicon-facetime-video',
                            'link' => 'videos\', \'index'
                        )
                    ),
                'forum' => new Object(
                        array(
                            'show_in_navbar' => false,
                            'show_to_authorized' => true,
                            'name' => 'Форум',
                            'icon' => 'glyphicon glyphicon-bullhorn',
                            'link' => 'forum\', \'index'
                        )
                    ),
                'chat' => new Object(
                        [
                            'name' => 'Chat',
                            'link' => 'chat\', \'index',
                            'show_in_navbar' => false,
                            'show_to_authorized' => true,
                            'icon' => 'glyphicon glyphicon-signal'
                        ]
                    ),
                'radio' => new Object(
                        [
                            'name' => 'Radio',
                            'link' => 'radio\', \'index',
                            'show_in_navbar' => true,
                            'show_to_authorized' => true,
                            'icon' => 'glyphicon glyphicon-headphones'
                        ]
                    ),
                'outdoor' => new Object(
                        array(
                            'show_in_navbar' => true,
                            'show_to_authorized' => false,
                            'name' => 'Авторизация',
                            'icon' => 'glyphicon glyphicon-lock',
                            'link' => 'outdoor\', \'login'
                        )
                    ),
                'registration' => new Object(
                        array(
                            'show_in_navbar' => true,
                            'show_to_authorized' => false,
                            'name' => 'Регистрация',
                            'icon' => 'glyphicon glyphicon-plus',
                            'link' => 'outdoor\', \'register'
                        )
                    ),
                'static_pages' => new Object(
                        array(
                            'show_in_navbar' => false,
                            'name' => 'Статические страницы'
                        )
                    ),
                'social' => new Object(
                        array(
                            'show_in_navbar' => false
                        )
                    ),
                'features' => new Object(
                        array(
                            'show_in_navbar' => false
                        )
                    ),
                'control_panel' => new Object(
                        array(
                            'show_in_navbar' => false
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

                'site_domain' => 'mctop.ru',

                'site_name' => 'MCTop',
                'title_content' => 'MCTop.ru - Рейтинг серверов',

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
            ],

            'engine' => [
                'name' => 'the Vay engine (ready 2 hack)',
                'version' => '0.01a',
            ],

        );

        $this->db = $settings['databases']['db'];
        $this->application = $settings['application'];
        $this->modules = $settings['modules'];
        $this->engine = $settings['engine'];

    }
}

$settings = new Settings();
