
    function project_update(id, user)
    {
        $.ajax({
            type: "POST",
            data: ({
                id: id,
                name : $("input[name='name']").val(),
                description : $("textarea[name='description']").val(),
                site_url : $("input[name='site_url']").val(),
                user: user
            }),
            url: "/api.php?module=projects_api&action=update",
            cache: false,
            success: function(msg){
                var answer = jQuery.parseJSON(msg);
                if(answer)
                {
                    $( ".message" ).html('<div class="alert alert-success" role="alert">Данные обновлены</div>');
                    setTimeout(function() {
                        $(".message").fadeOut().html('');
                    }, 5000);
                }
            }
        });
    }

    function server_update(id, user)
    {
        $.ajax({
            type: "POST",
            data: ({
                id: id,
                name : $("input[name='name']").val(),
                description : $("textarea[name='description']").val(),
                features : $("textarea[name='features']").val(),
                map_url : $("input[name='map_url']").val(),
                address : $("input[name='address']").val(),
                port : $("input[name='port']").val(),
                user: user
            }),
            url: "/api.php?module=servers_api&action=update",
            cache: false,
            success: function(msg){
                var answer = jQuery.parseJSON(msg);
                if(answer)
                {
                    $( ".message" ).html('<div class="alert alert-success" role="alert">Данные обновлены</div>');
                    setTimeout(function() {
                        $(".message").fadeOut().html('');
                    }, 5000);
                }
            }
        });
    }