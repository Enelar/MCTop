<?php

class Photos
{

    public $id, $name, $description, $owner, $access_privacy, $redis_key;
    private $model_reason_to_call;
    private $model_with_which_user_works;
    private $model_description_to_reason;
    private $model_record_id;
    public $storage;

    function __construct($behaviour)
    {
        if ($behaviour != 'idle') {
            $this->know_what_need_to_do($behaviour);

            if ($this->model_reason_to_call == 'get_one') {
                if (!empty($this->model_description_to_reason))
                    if ($this->model_description_to_reason == 'club_by_id')
                        foreach ($this->get('clubs:' . $this->model_record_id) as $key => $value)
                            $this->$key = $value;
                $this->id = $this->model_record_id;
            }

            if ($this->model_reason_to_call == 'get_all_photos_from_album') {
                $array_of_ids = Core::$redis_db->sGetMembers('user:.' . $this->model_with_which_user_works . '.:album:' . $this->model_record_id . ':photos:ids');
                $this->storage = $this->get_all_photos_in_album_by_array_of_ids($array_of_ids);
            }

            if ($this->model_reason_to_call == 'get_all_user_albums') {
                $array_of_ids = Core::$redis_db->sGetMembers('user:' . Core::get_current_user_profile()->id . '.albums:ids');

                //$this->storage = $this->get_all_clubs_by_array_of_ids($array_of_ids);
            }

            if ($this->model_reason_to_call == 'get_all_club_albums') {
                $array_of_ids = Core::$redis_db->sGetMembers('clubs:public:ids');

                //$this->storage = $this->get_all_clubs_by_array_of_ids($array_of_ids);
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
            $this->model_record_id = $parsed_array[2];
        }

    }

    function get($id)
    {
        return Core::$redis_db->hGetAll($id);
    }

    function get_all_photos_in_album_by_array_of_ids($ids, $user = null, $album = null)
    {
        $photos = [];

        foreach ($ids as $id) {
            $club = new Photos('idle');

            foreach ($this->get('user:' . $user . ':album:' . $album . ':photos') as $key => $value)
                $club->$key = $value;

            //как-то так

            $club->id = $id;
            $clubs[] = $club;
        }

        return $clubs;
    }

}
