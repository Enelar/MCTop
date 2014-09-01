

    require([
        "_libs/bootstrap",
        "_libs/jqClock",
        "_libs/keymaster",
        "_libs/jquery.qtip.min",
        "_libs/ion.sound",
        "core/the_x",
        "core/rating",
        "control_panel/crud",
        "features/features",
        "features/hotkeys",
        "social/notifications",
        "social/home",
        "social/im",
        "social/social",
    ],
        function(the_x)
        {

            user_logged_status = api_get_request('users','is_user_authorized');
            current_user_id = api_get_request('users', 'get_current_user_id');

            if(!user_logged_status['is_authorized'])
                display_page('main', 'index');
            else
            {

                display_page('social','home/index');
                render_page_on_tab('social', 'home/home_tab', 'home');

                api_get_request('users','update_user_session_period');
                update_user_status();

                ion.sound({
                    sounds: [
                        {
                            name: "notify",
                            volume: 1.0
                        },
                    ],
                    path: "static/sounds/",
                    preload: true
                });

            }

        }
    );



