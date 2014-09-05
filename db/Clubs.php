<?php

class Clubs
{

    public $id, $name, $description, $owner, $access_privacy, $redis_key;
    private $model_reason_to_call;
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
                        foreach (Core::$redis_db->hGetAll('clubs:' . $this->model_record_id) as $key => $value)
                            $this->$key = $value;

                $this->id = $this->model_record_id;

                if (is_null($this->name))
                    Core::throw_error();
            }

            if ($this->model_reason_to_call == 'get_all_in_which_user_entered') {
                $array_of_ids = Core::$redis_db->sGetMembers('user:' . Core::get_current_user_profile()->id . ':clubs:entered');
                $this->storage = $this->get_all_clubs_by_array_of_ids($array_of_ids);
            }

            if ($this->model_reason_to_call == 'get_all_public_clubs') {
                $array_of_ids = Core::$redis_db->sGetMembers('clubs:public:ids');
                $this->storage = $this->get_all_clubs_by_array_of_ids($array_of_ids);
            }

        }

    }

    private function know_what_need_to_do($behaviour)
    {
        $parsed_array = explode(':', $behaviour);

        $this->model_reason_to_call = $parsed_array[0];

        $this->model_description_to_reason = $parsed_array[1];
        $this->model_record_id = $parsed_array[2];
    }

    function get($id)
    {
        return Core::$redis_db->hGetAll($id);
    }

    function get_all_clubs_by_array_of_ids($ids)
    {
        $clubs = [];

        foreach ($ids as $id) {
            $club = new Clubs('idle');

            foreach ($this->get('clubs:' . $id) as $key => $value)
                $club->$key = $value;

            $club->id = $id;

            $clubs[] = $club;
        }

        return $clubs;
    }

    function is_club_member($user_id)
    {
        return Core::$redis_db->sIsMember('clubs:' . $this->id . ':members', $user_id);
    }

    function check_privacy($user_id)
    {

        if (is_null($this->name))
            Core::throw_error();

        if (!$this->is_club_member($user_id))
            if ($this->access_privacy == 'private_club')
                Core::throw_error();

    }

    static function get_current_user_invitations_count()
    {
        return sizeof(self::get_current_user_invitations());
    }

    static function get_current_user_invitations()
    {
        return Core::$redis_db->sMembers('user:' . Core::get_current_user_profile()->id . ':clubs:invitations');
    }

}
