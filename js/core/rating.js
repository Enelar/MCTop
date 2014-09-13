

    function vote_for_server(mode, server)
    {
        if(mode == '+')
            console.log('плюс одно очко серверу ' + server);
        else
            console.log('минус одно очко серверу ' + server);

        $.ajax({
            type: "POST",
            data: ({
                server_id : server,
                mode : mode
            }),
            url: "/api.php?module=ratingservers&action=vote",
            success: function(msg){
                var answer = jQuery.parseJSON(msg);
                log(answer);
            }
        });

    }

    function server_subscribe(server_id)
    {
        $.ajax({
            type: "POST",
            data: ({
                server_id : server_id,
                nickname: $("input[name='nickname']").val()
            }),
            url: "/api.php?module=ratingservers&action=subscribe",
            success: function(msg){
                var answer = jQuery.parseJSON(msg);
                if(answer['message'] == 'success')
                    display_page_with_id('projects_rating', 'project/server', server_id);
            }
        });
    }

    function server_subscriber_change_nickname(server_id)
    {
        $.ajax({
            type: "POST",
            data: ({
                server_id : server_id,
                nickname: $("input[name='nickname']").val()
            }),
            url: "/api.php?module=ratingservers&action=subscriber_change_nickname",
            success: function(msg){
                var answer = jQuery.parseJSON(msg);
                if(answer['message'] == 'success')
                    display_page_with_id('projects_rating', 'project/server', server_id);
            }
        });
    }