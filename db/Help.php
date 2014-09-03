<?php

class HelpCategories extends X
{

    public $cl_name = 'Help';

    public $id, $name, $description, $topics;

    static function get_categories_with_topics()
    {
        $categories_count = Core::$redis_db->zCard('help:categories');
        $categories = [];

        for($i = 1; $i < $categories_count+1; $i++)
        {
            $_info = Core::$redis_db->hGetAll('help:categories:'.$i);
            $category = new HelpCategories();
            $category->id = $i;
            $category->name = $_info['name'];
            $category->description = $_info['description'];
            $category->topics = $category->get_topics_for_category();
            $categories[] = $category;
        }

        return $categories;
    }

    static function add_new_category($name, $description)
    {
        $category_id = Core::$redis_db->zCard('help:categories') + 1;
        Core::$redis_db->zAdd('help:categories', $category_id, $category_id);

        Core::$redis_db->hSet('help:categories:'.$category_id, 'name', $name);
        Core::$redis_db->hSet('help:categories:'.$category_id, 'description', $description);
    }

    function get_topics_for_category()
    {
        $topics_count = sizeof(Core::$redis_db->keys('help:categories:'.$this->id.':topics:*'));

        if($topics_count>0)
        {
            $topics = [];

            for ($i = 1; $i < $topics_count + 1; $i++)
            {
                $topic = Help_Topic::get_topic($this->id, $i);
                $topics[] = $topic;
            }
            return $topics;
        }
        return false;

    }
}

class Help_Topic extends X
{

    public $cl_name = 'Help_Topic';
    public $id, $category, $name, $text;

    static function get_topic($category_id, $topic_id)
    {
        $_info = Core::$redis_db->hGetAll('help:categories:'.$category_id.':topics:'.$topic_id);

        if(sizeof($_info)>0)
        {
            $topic = new Help_Topic();
            $topic->id = $topic_id;
            $topic->category = $category_id;
            $topic->name = $_info['name'];
            $topic->text = $_info['text'];
            return $topic;
        }

        return false;
    }

    static function add_new_topic($category_id, $name, $text)
    {
        $topic_id = sizeof(Core::$redis_db->keys('help:categories:'.$category_id.':topics:*')) + 1;
        Core::$redis_db->hSet('help:categories:'.$category_id.':topics:'.$topic_id, 'name', $name);
        Core::$redis_db->hSet('help:categories:'.$category_id.':topics:'.$topic_id, 'text', $text);
    }

}
