
    function authorize_user()
    {
        $.ajax({
            type: "POST",
            data: ({
                login : $("input[name='login']").val(),
                password : $("input[name='password']").val()
            }),
            url: "/api.php?module=users&action=authorize",
            success: function(msg){
                var answer = jQuery.parseJSON(msg);
                if(answer['message'] == 'success')
                {
                    window.location.replace("http://mctop.ru");
                }
            }
        });
    }

    function logout_user()
    {
        window.location.replace("http://mctop.ru/api.php?module=users&action=logout");
    }

    function show_profile(id)
    {
        $.ajax({
            type: "GET",
            data: {'id':id},
            url: "/index.php?module=social&action=profile",
            cache: false,
            success: function(html){
                $( ".content" ).html( html );

                $.ajax({
                    type: "GET",
                    url: "/index.php?module=main&action=footer",
                    cache: false,
                    success: function(footer){
                        $( ".footer" ).html( footer );
                    }
                });
            }
        });

    }

    function edit_profile(session_id, user_id)
    {
        $.ajax({
            type: "POST",
            data: ({
                name : $("input[name='name']").val(),
                lastname : $("input[name='lastname']").val(),
                email : $("input[name='email']").val(),
                nickname : $("input[name='nickname']").val(),
                city : $("input[name='city']").val(),
                hobby : $("input[name='hobby']").val(),
                mobile_phone : $("input[name='mobile_phone']").val(),
                relationship_status : $("input[name='relationship_status']").val(),
                status : $("input[name='status']").val(),
                session_id: session_id,
                user_id: user_id
            }),
            url: "/api.php?module=users&action=edit_profile",
            cache: false,
            success: function(msg){
                var answer = jQuery.parseJSON(msg);
                if(answer['data']['edit_profile'])
                {
                    $( ".message" ).html('<div class="alert alert-success" role="alert">Данные обновлены</div>');
                    setTimeout(function() {
                        $(".message").fadeOut().empty();
                    }, 5000);
                }
            }
        });
    }

    function delete_user_from_contact_list(from, who_wants_to_remove)
    {
        $.ajax({
            type: "POST",
            data: ({
                from : from,
                who_wants_to_remove : who_wants_to_remove
            }),
            url: "/api.php?module=contacts&action=remove",
            cache: false,
            success: function(msg){
                var answer = jQuery.parseJSON(msg);
                if(answer['message'] == 'success')
                {
                    show_profile(who_wants_to_remove);
                }
            }
        });
    }

    function add_user_to_contact_list(from, who_wants_to_add)
    {

        //privacy will be here

        $.ajax({
            type: "POST",
            data: ({
                from : from,
                who_wants_to_add : who_wants_to_add
            }),
            url: "/api.php?module=contacts&action=add",
            cache: false,
            success: function(msg){
                var answer = jQuery.parseJSON(msg);
                if(answer['message'] == 'success')
                {
                    from_user_info = get_user_info(from)[0];
                    send_notification(who_wants_to_add, 'Добавление в список контактов', 'Пользователь <a onclick="show_profile('+from+')">'+ from_user_info['name'] + ' '+ from_user_info['lastname'] + '</a> добавил тебя в свой список контактов');
                    show_profile(who_wants_to_add);
                }
            }
        });
    }

    function club_create()
    {
        $.ajax({
            type: "POST",
            data: ({
                name : $("input[name='name']").val(),
                description : $("textarea[name='description']").val(),
                owner : $("input[name='owner']").val(),
                access_privacy : $("input[name='access_privacy']:checked").val()

            }),
            url: "/api.php?module=clubs&action=create",
            cache: false,
            success: function(msg){
                var answer = jQuery.parseJSON(msg);
                if(answer['message'] == 'success')
                {
                    display_page_with_id('social','clubs/body',answer['id']);
                }
            }
        });

    }

    function club_edit(id)
    {
        $.ajax({
            type: "POST",
            data: ({
                id: id,
                name : $("input[name='name']").val(),
                description : $("textarea[name='description']").val(),
                access_privacy : $("input[name='access_privacy']:checked").val()
            }),
            url: "/api.php?module=clubs&action=edit",
            cache: false,
            success: function(msg){
                var answer = jQuery.parseJSON(msg);
                if(answer['message'] == 'success')
                {
                    display_page_with_id('social','clubs/body',answer['id']);
                }
            }
        });
    }

    function club_join(id, user_id)
    {
        $.ajax({
            type: "POST",
            data: ({
                id : id,
                user_id : user_id
            }),
            url: "/api.php?module=clubs&action=join",
            cache: false,
            success: function(msg){
                var answer = jQuery.parseJSON(msg);
                if(answer['message'] == 'success')
                {
                    display_page_with_id('social','clubs/body',id);
                }
            }
        });
    }

    function club_leave(id, user_id)
    {
        $.ajax({
            type: "POST",
            data: ({
                id : id,
                user_id : user_id
            }),
            url: "/api.php?module=clubs&action=leave",
            cache: false,
            success: function(msg){
                var answer = jQuery.parseJSON(msg);
                if(answer['message'] == 'success')
                {
                    display_page_with_id('social','clubs/body',id);
                }
            }
        });
    }

    function club_delete(id, user_id)
    {
        if(user_id)
            $.ajax({
                type: "POST",
                data: ({
                    id : id,
                    user_id : user_id
                }),
                url: "/api.php?module=clubs&action=delete",
                cache: false,
                success: function(msg){
                    var answer = jQuery.parseJSON(msg);
                    if(answer['message'] == 'success')
                    {
                        display_page('social','clubs/index');
                    }
                }
            });
    }

    function club_invite(id, who_wants_to_invite, user_id)
    {
        $.ajax({
            type: "POST",
            data: ({
                id : id,
                who_wants_to_invite: who_wants_to_invite,
                user_id : user_id
            }),
            url: "/api.php?module=clubs&action=invite",
            cache: false,
            success: function(msg){

                var answer = jQuery.parseJSON(msg);
                if(answer['message'] == 'success')
                {
                    $( ".message_"+who_wants_to_invite ).html('<br><div class="alert alert-success" role="alert"> Приглашение отправлено</div>');
                    setTimeout(function() {
                        $(".message_"+who_wants_to_invite).fadeOut().empty();
                    }, 5000);
                }

            }
        });
    }

    function club_dismember(id_to_dismember, club_id, user_id)
    {
        if(user_id)
            $.ajax({
                type: "POST",
                data: ({
                    id_to_dismember : id_to_dismember,
                    club_id: club_id,
                    user_id : user_id
                }),
                url: "/api.php?module=clubs&action=dismember",
                cache: false,
                success: function(msg){
                    console.log(msg);
                    var answer = jQuery.parseJSON(msg);
                    if(answer['message'] == 'success')
                    {
                        $('#member_'+id_to_dismember).remove();
                        $('#delete_are_button_'+id_to_dismember).remove();
                    }

                }
            });
    }

    function update_notifications()
    {
        $.ajax({
            type: "GET",
            url: "/api.php?module=users&action=update_notifications",
            cache: false,
            success: function(html){

                $( ".content" ).html( html );
            }
        });
    }

    function update_user_status()
    {
        function timeout() {
            setTimeout(function () {
                api_get_request('users','update_user_session_period');
                timeout();
            }, 15000);
        }

        timeout();
    }

    function get_user_info(id)
    {
        var result = "";

        var response = $.ajax(
            {
                type: "GET",
                data: ({
                    id : id
                }),
                url: "/api.php?module=users&action=get_user_info",
                cache: false,
                async: false,
                success: function(data){
                    result = jQuery.parseJSON(data);
                }
            }
        );

        return result;
    }

    function user_add_reputation(type, to, from)
    {
        if(from && (type == 'plus' || type == 'minus'))
        {
            var url = '/api.php?module=reputation_api&action=add_'+type+'_to_user_reputation';
            $.ajax({
                type: "POST",
                data: ({
                    to : to,
                    from: from,
                    description: $("textarea[name='description']").val()
                }),
                url: url,
                cache: false,
                success: function(msg){
                    console.log(msg);
                }
            });
        }
    }

    function forum_topic_leave_message(topic, author)
    {
        $.ajax({
            type: "POST",
            data: ({
                message : $("textarea[name='message']").val(),
                author: author,
                topic: topic
            }),
            url: "/api.php?module=forum_api&action=post_new_message",
            cache: false,
            success: function(msg){
                var answer = jQuery.parseJSON(msg);
                if(answer['message'] == 'success')
                {
                    display_page_with_id('forum','topic/body', topic);
                }
            }
        });
    }
