<?php

class Forum_topics {
    public $id, $category, $name, $description, $header_message, $topic_starter, $time, $messages, $messages_authors;

    function create()
    {

    }

    function update($id, $data)
    {

    }

    function get($id, $messages_count, $page)
    {

        $topic =  Core::$db->Query("select * from main.forum_topics where id = $1", [$id], true);

        if(!$topic)
            Core::throw_error('Тема не найдена');

        $messages = $this->get_topic_messages_and_authors_ids($id, $messages_count, $page);
        $messages_authors = $this->get_messages_authors($messages['authors_ids']);

        $idle_topic = new Forum_topics();

        foreach ($topic as $key => $value)
            $idle_topic->$key = $value;

        $idle_topic->messages = $messages['messages'];
        $idle_topic->messages_authors = $messages_authors;
        return $idle_topic;
    }

    function delete()
    {

    }

    function get_topic_messages_and_authors_ids($id, $messages_count, $page)
    {
        $_offset = $page*10;
        $messages = Core::$db->Query("select * from main.forum_answers where topic = $1 limit $2 offset $3", [$id, $messages_count, $_offset]);
        $messages_authors_ids = [];

        $idle_message = new Forum_answers();

        foreach ($messages as $index => $message)
        {
            foreach ($message as $key => $value)
                $idle_message->$key = $value;

            $messages[$index] = $idle_message;
            $messages_authors_ids[$idle_message->author] = 0;
        }

        return [
            'messages' => $messages,
            'authors_ids' => $messages_authors_ids
        ];
    }

    function get_messages_authors($messages_authors_ids)
    {
        $idle_user = new User();

        foreach ($messages_authors_ids as $key => $value)
            $messages_authors_ids[$key] = $idle_user->get_user($key);

        return $messages_authors_ids;
    }
}