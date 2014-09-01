
    /*
        Code of _features_ module
     */

    function create_new_note(uid)
    {
        $.ajax({
            type: "POST",
            data: ({
                name : $("input[name='name']").val(),
                content : $("textarea[name='content']").val(),
                private: 1
            }),
            url: "/api.php?module=notes&action=create_note",
            cache: false,
            success: function(msg){
                var answer = jQuery.parseJSON(msg);
                if(answer['message'] == 'success')
                {
                    display_page('features','notes/index')
                }
            }
        });
    }

    function edit_note(id)
    {
        $.ajax({
            type: "POST",
            data: ({
                id: id,
                name : $("input[name='name']").val(),
                content : $("textarea[name='content']").val(),
                private: 1
            }),
            url: "/api.php?module=notes&action=edit_note",
            cache: false,
            success: function(msg){
                var answer = jQuery.parseJSON(msg);
                if(answer['message'] == 'success')
                {
                    display_page('features','notes/index')
                }
            }
        });
    }

    function note_delete(id, user_id)
    {
        if(user_id)
            $.ajax({
                type: "POST",
                data: ({
                    id : id,
                    user_id : user_id
                }),
                url: "/api.php?module=notes&action=delete",
                cache: false,
                success: function(msg){
                    var answer = jQuery.parseJSON(msg);
                    if(answer['message'] == 'success')
                    {
                        display_page('features','notes/index');
                    }
                }
            });
    }

    function blog_post_record()
    {
        $.ajax({
            type: "POST",
            data: ({
                name : $("input[name='name']").val(),
                content : $("textarea[name='content']").val(),
                private: 1
            }),
            url: "/api.php?module=blog&action=post_new_record",
            cache: false,
            success: function(msg){
                var answer = jQuery.parseJSON(msg);
                if(answer['message'] == 'success')
                {
                    display_page('features','blog/index')
                }
            }
        });
    }

    function blog_post_delete(id, user_id)
    {
        if(user_id)
            $.ajax({
                type: "POST",
                data: ({
                    id : id,
                    user_id : user_id
                }),
                url: "/api.php?module=blog&action=delete",
                cache: false,
                success: function(msg){
                    var answer = jQuery.parseJSON(msg);
                    if(answer['message'] == 'success')
                        $('#post_'+id).remove();
                }
            });
    }

