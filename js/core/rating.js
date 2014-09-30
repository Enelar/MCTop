

    function vote_for_server(server)
    {
        $.ajax({
            type: "POST",
            data: ({
                server_id : server
            }),
            url: "/api.php?module=RatingServers&action=vote",
            success: function(msg){
                var answer = jQuery.parseJSON(msg);
                if(answer['message'] == 'is_first_vote')
                    display_page_with_id('social', 'misc/email_approving', server);
                else
                    display_page_with_id('projects_rating', 'project/server', server);
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
            url: "/api.php?module=RatingServers&action=subscribe",
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
            url: "/api.php?module=RatingServers&action=subscriber_change_nickname",
            success: function(msg){
                var answer = jQuery.parseJSON(msg);
                if(answer['message'] == 'success')
                    display_page_with_id('projects_rating', 'project/server', server_id);
            }
        });
    }

    function servers_search()
    {
        $.ajax({
            type: "POST",
            data: ({
                tags: $("input[name='tags']").val(),
                strictly_search: $("input[name='strictly_search']").val(),
                version_id : $('#version_id option:selected').val()
            }),
            url: "/api.php?module=search&action=results",
            cache: false,
            success: function(content){
                $( "#results" ).html( content );
            }
        });
    }

    function add_server_to_favorite(server_id)
    {
        $.ajax({
            type: "POST",
            data: ({
                server: server_id
            }),
            url: "/api.php?module=servers_api&action=favorite",
            cache: false,
            success: function(msg){
                display_page_with_id('projects_rating', 'project/server', server_id);
            }
        });
    }