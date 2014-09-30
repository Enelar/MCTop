
    require([
        "_libs/bootstrap",
        "core/the_x",
        "core/rating",
        "control_panel/crud",
        "features/features",
        "social/home",
        "social/social",
    ],
        function(the_x)
        {

            user_logged_status = api_get_request('users','is_user_authorized');
            current_user_id = api_get_request('users', 'get_current_user_id');

            if(user_logged_status['is_authorized'])
            {
                api_get_request('users','update_user_session_period');
                update_user_status();
            }

        }


    );



