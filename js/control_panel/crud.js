
    function project_create(user)
    {
        $.ajax({
            type: "POST",
            data: ({
                user: user
            }),
            url: "/api.php?module=projects_api&action=create",
            cache: false,
            success: function(msg){
                console.log(msg);
                display_page('control_panel', 'index');
            }
        });
    }

    function project_update(id, user)
    {
        $.ajax({
            type: "POST",
            data: ({
                id: id,
                name : $("input[name='name']").val(),
                description : $("textarea[name='description']").val(),
                site_url : $("input[name='site_url']").val(),
                vk_group : $("input[name='vk_group']").val(),
                fb_public : $("input[name='fb_public']").val(),
                twitter_account : $("input[name='twitter_account']").val(),
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

    function project_delete(id, user)
    {
        $.ajax({
            type: "POST",
            data: ({
                id: id,
                user: user
            }),
            url: "/api.php?module=projects_api&action=delete",
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

    function server_create(project, user)
    {
        $.ajax({
            type: "POST",
            data: ({
                user: user,
                project: project
            }),
            url: "/api.php?module=servers_api&action=create",
            cache: false,
            success: function(msg){
                var answer = jQuery.parseJSON(msg);
                if(answer)
                {
                    display_page_with_id('control_panel', 'projects/view', project);
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
                plugins : $("input[name='plugins']").val(),
                mods : $("input[name='mods']").val(),
                tags : $("input[name='tags']").val(),
                user: user
            }),
            url: "/api.php?module=servers_api&action=update",
            cache: false,
            success: function(msg){
                log(msg);
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

    function server_delete(id, user)
    {
        $.ajax({
            type: "POST",
            data: ({
                id: id,
                user: user
            }),
            url: "/api.php?module=servers_api&action=delete",
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