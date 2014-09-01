

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