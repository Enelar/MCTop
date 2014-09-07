<?php

class News extends X
{

    public $cl_name = 'News';

    public $id, $subject, $text, $time, $category;
    public $fields_to_edit = 'subject, text, category';

    static function get_post($id, $for_what_purposes = null)
    {
        $result = Core::get_db()->Query("select * from main.news where id = $1", [$id], true);

        if (!$result) {
            if (is_null($for_what_purposes))
                Core::throw_error('Пост не найден');
            else
                return array('data' => null);
        }

        $idle_post = new News();
        foreach ($result as $key => $value)
            $idle_post->$key = $value;

        return $idle_post;
    }

    static function get_posts_for_news_page($page, $limit = 10)
    {
        $_offset = $page * 10;

        $result = Core::get_db()->Query("select * from main.news limit $1", [$limit]);
        $posts = [];

        foreach ($result as $post) {

            $idle_post = new News();
            foreach ($post as $key => $value)
                $idle_post->$key = $value;

            $idle_post->category = News_categories::get_category($idle_post->category);

            $posts[] = $idle_post;
        }

        return $posts;
    }

    function add_new_post()
    {
        return Core::get_db()->Query("INSERT INTO main.news(text) VALUES ($1)", [$this->id]);
    }

}

Class News_categories
{
    public $cl_name = 'News_categories';

    public $id, $name;
    public $fields_to_edit = 'name';

    public static function get_category($id)
    {
        $category = new News_categories();
        $result = Core::get_db()->Query("select * from main.news_categories where id = $1", [$id], true);

        foreach ($result as $key => $value)
            $category->$key = $value;

        return $category;
    }

    function add_new_category()
    {
        return Core::get_db()->Query("INSERT INTO main.news_categories (name) VALUES ($1)", [$this->id]);
    }
}