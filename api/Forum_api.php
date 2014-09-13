<?php

class Forum_api extends API
{
    static function get_topic ($id = null, $messages_count = null, $page = null)
    {
        if(is_null($id))
            $id = $_GET['id'];

        if(is_null($messages_count))
            $messages_count = $_GET['messages_count'];

        if(is_null($page))
            $page = $_GET['page'];

        $topic = new Forum_topics();
        return $topic->get($id, $messages_count, $page);
    }

    static function get_categories ()
    {
        $categories = Forum_categories::get_all();
        return $categories;
    }

    static function get_category_topics($id)
    {
        $topics = [];
        $topics_arrays = Core::$db->Query("select * from main.forum_topics where category = $1", [$id]);

        $idle_topic = new Forum_topics();
        foreach($topics_arrays as $topic_array)
        {
            foreach($topic_array as $key => $value)
            {
                $idle_topic->$key = $value;
            }
            $topics[] = $idle_topic;
        }

        return $topics;
    }

    static function get_category_topics_ids($id)
    {
        return Core::$db->Query("select id from main.forum_topics where category = $1", [$id]);
    }

    function post_new_message()
    {
        API::is_user_authorized_and_is_not_empty_post_request();

        $topic = Forum_api::get_topic($_POST['topic']);

        if(is_object($topic))
        {
            $time = date('Y-m-d H:i:sO', time());
            $query = "INSERT INTO main.forum_answers(topic, author, message, \"time\")  VALUES ($1, $2, $3, $4)";
            $result = Core::$db->Query($query, [$_POST['topic'], Core::get_current_user_profile()->id, $_POST['message'], $time], 1);

            return [
                'message' => 'success'
            ];
        }

    }
}
