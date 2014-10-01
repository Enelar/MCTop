<?php
class News extends api
{
    protected function reserve($page = 0)
    {
        $res = Core::get_db()->Query("select * from main.news limit 10 offset $1", [$page*10]);

        return
        [
            "design" => "news/index",
            "data"   => [ "news" => $res ],
        ];
    }

    protected function post_category($id)
    {
        $res = Core::get_db()->Query("select * from main.news_categories where id = $1", [$id], true);

        return
        [
            "design" => "news/post_category",
            "data"   => [ "info" => $res ],
        ];
    }
}

