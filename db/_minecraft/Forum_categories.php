<?php

class Forum_categories {
    public $id, $name, $description, $parent_id, $topics;

    function create()
    {

    }

    function update()
    {

    }

    function get($id)
    {
        return Core::$db->Query("select * from main.forum_categories where id = $1", [$id], true);
    }

    function delete()
    {

    }

    static function get_all()
    {
        $categories = Core::$db->Query('select * from main.forum_categories');
        $idle_category = new Forum_categories();

        $result = [];

        foreach($categories as $category)
        {
            foreach($category as $key => $value)
                $idle_category->$key = $value;

            $idle_category->topics = Forum_api::get_category_topics($idle_category->id);
            $result[] = $idle_category;
        }
        return $result;
    }
}