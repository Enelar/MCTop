

    function send_message(from, to)
    {
        var message = $.trim($("textarea[name='message']").val());
        if(message.length>0)
            $.ajax({
                type: "POST",
                data: ({
                    from : from,
                    to : to,
                    message : message
                }),
                url: "/api.php?module=im&action=send_message_to_user",
                success: function(msg){
                    display_page_with_id('social', 'im/chat', to);
                }
            });

        //todo: Обновление страницы при получении сообщения юзером, если у него открыт чат.
    }

    function render_notification(persistent, title, data) {
        var target = $('.qtip.jgrowl:visible:last');

        $('<div/>').qtip({
            content: {
                text: data,
                title: {
                    text: title,
                    button: true
                }
            },
            position: {
                target: [0,0],
                container: $('#qtip-growl-container')
            },
            show: {
                event: false,
                ready: true,
                effect: function() {
                    $(this).stop(0, 1).animate({ height: 'toggle' }, 100, 'swing');
                },
                delay: 0,
                persistent: persistent
            },
            hide: {
                event: false,
                effect: function(api) {
                    $(this).stop(0, 1).animate({ height: 'toggle' }, 100, 'swing');
                }
            },
            style: {
                width: 250,
                classes: 'qtip-blue',
                tip: false
            },
            events: {
                render: function(event, api) {
                    if(!api.options.show.persistent) {
                        $(this).bind('mouseover mouseout', function(e) {
                            var lifespan = 5000;

                            clearTimeout(api.timer);
                            if (e.type !== 'mouseover') {
                                api.timer = setTimeout(function() { api.hide(e) }, lifespan);
                            }
                        })
                            .triggerHandler('mouseout');
                    }
                }
            }
        });
    }