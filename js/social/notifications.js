
    function send_notification(to, title, message)
    {

        $.ajax({
            type: "POST",
            data: ({
                title: title,
                message : message,
                to: to
            }),
            url: "/api.php?module=notifications&action=send_notification",
            success: function(msg)
            {
                log(msg);
            }
        });

    }