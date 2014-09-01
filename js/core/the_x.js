
    function api_get_request(module, action)
    {
        var result = "";

        var response = $.ajax(
            {
                type: "GET",
                url: "/api.php?module="+module+"&action="+action,
                cache: false,
                async: false,
                success: function(data){
                    result = jQuery.parseJSON(data);
                }
            }
        );

        return result;
    }

    function display_page(module, action)
    {
        $.ajax({
            type: "GET",
            url: "/index.php?module="+module+"&action="+action,
            cache: false,
            success: function(content){
                $( ".content" ).html( content );
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

    function display_page_with_id(module, action, id)
    {
        $.ajax({
            type: "GET",
            data: {'id':id},
            url: "/index.php?module="+module+"&action="+action,
            cache: false,
            success: function(content){
                $( ".content" ).html( content );
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

    function log(var_)
    {
        //console.log(var_);
    }

    function call_function_with_timeout(seconds, func) {
        //todo Just do it
    }

    function show_login_page()
    {
        display_page('main','login');
        setTimeout(function() {
            $("#login").focus();
        }, 100);
    }

    function render_page_in_div_by_id(module, action, div_id)
    {
        $.ajax({
            type: "GET",
            url: "/index.php?module="+module+"&action="+action,
            cache: false,
            success: function(html){
                $( '#'+div_id ).html( html );
            }
        });
    }

    //todo Сделать рефактор функции с _div_by_id до div




