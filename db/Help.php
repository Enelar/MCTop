<?php

    class HelpCategories extends X {

        public $cl_name = 'Help';

        public $id, $name, $description;

        static function get_categories_with_topics()
        {
            
        }


    }

    class Help_Article extends X
    {

        public $cl_name = 'Help_Article';
        public $id, $name, $text;

        static function get_article()
        {

        }

        static function get_articles_for_category()
        {

        }

    }