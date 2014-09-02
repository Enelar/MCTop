<?php

class Blog_Posts
{

    public $id, $content, $time, $private;
    private $model_reason_to_call;
    private $model_description_to_reason;
    private $model_with_witch_user_works;
    private $model_record_id;
    public $storage;

    function __construct($behaviour)
    {
        if ($behaviour != 'idle') {
            $this->know_what_need_to_do($behaviour);

            if ($this->model_reason_to_call == 'get_all') {
                $posts = [];
                $ids = $this->get_array_of_ids_in_the_correct_order($this->model_with_witch_user_works);

                foreach ($ids as $post_id) {
                    $post = $this->get('user:' . $this->model_with_witch_user_works . ':blog:records:' . $post_id);

                    if (sizeof($post) > 0) {
                        $post_object = new Blog_Posts('idle');

                        foreach ($post as $key => $value)
                            $post_object->$key = $value;

                        $post_object->id = $post_id;
                        $posts[$post_id] = $post_object;

                    }
                }

                $this->storage = array_reverse($posts);
            }

            if ($this->model_reason_to_call == 'get_one'
                && !empty($this->model_description_to_reason)
                && $this->model_description_to_reason == 'record_by_id'
            ) {
                $this->storage = $this->get('user:' . $this->model_with_witch_user_works . ':blog:records:' . $this->model_record_id);
            }

        }
    }

    private function know_what_need_to_do($behaviour)
    {
        $parsed_array = explode(':', $behaviour);

        $this->model_reason_to_call = $parsed_array[0];
        if ($this->model_reason_to_call != 'get_one')
            $this->model_with_witch_user_works = $parsed_array[2];
        else {
            $this->model_description_to_reason = $parsed_array[1];
            $this->model_with_witch_user_works = $parsed_array[4];
            $this->model_record_id = $parsed_array[2];
        }
    }

    function get_array_of_ids_in_the_correct_order($user)
    {
        return explode(':', Core::$redis_db->get('user:' . $user . ':blog:records:ids'));
    }

    function get_all_user_notes_ids($uid)
    {
        return Core::$redis_db->keys('user:' . $uid . ':blog:records:*');
    }

    function get($id)
    {
        return Core::$redis_db->hGetAll($id);
    }


}