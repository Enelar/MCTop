
    /*
        Горячие клавиши
    */
    key('q+w', function(){
        $('#vay_logo').click();
        update_notifications();
    });

    key('alt+c', function(){ display_page('social','contacts/index'); });
    key('alt+n', function(){ display_page('features','notes/index'); });
    key('alt+k', function(){ display_page('social','clubs/index'); });
    key('alt+b', function(){ display_page('features','blog/index'); });
    key('alt+h', function(){ display_page('main','help'); });
    key('a', function(){ display_page('social','applications/index'); });
    key('home', function(){ render_home_page(); });

    key('ctrl+e', function(){ display_page('social','misc/edit_profile_info'); });

    key('esc', function() {
        var test = $(".content").find("form");
        test.submit();
    });

