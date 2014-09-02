<?php

class Cities

{

    public $name, $description, $id;
    private $model_reason_to_call;
    private $model_description_to_reason;
    private $model_with_witch_user_works;
    private $model_record_id;
    public $storage;

    function __construct($behaviour)
    {
        if (DEBUG)
            echo 'Getting city with id ' . $_GET['id'];

        $this->know_what_need_to_do($behaviour);

        if ($this->model_reason_to_call == 'get_all') {

            $notes = [];

            $ids = $this->get_array_of_ids_in_the_correct_order($this->model_with_witch_user_works);

            foreach ($ids as $note_id) {
                $notes[$note_id] = $this->get('user:' . $this->model_with_witch_user_works . ':notes:' . $note_id);
            }

            $this->storage = array_reverse($notes);
        }

        if ($this->model_reason_to_call == 'get_one') {

            if (!empty($this->model_description_to_reason))
                if ($this->model_description_to_reason == 'city_by_id')
                    $this->storage = $this->get('user:' . $this->model_with_witch_user_works . ':notes:' . $this->model_record_id);
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
        return explode(':', Core::$redis_db->get('user:' . $user . ':notes:ids'));
    }

    function get_all_user_notes_ids($uid)
    {
        return Core::$redis_db->keys('user:' . $uid . ':notes:*');
    }

    function get($id)
    {
        return Core::$redis_db->hGetAll($id);
    }

}
