
    function project_update(id, user)
    {
        $.ajax({
            type: "POST",
            data: ({
                id: id,
                name : $("input[name='name']").val(),
                description : $("textarea[name='description']").val(),
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
                        $(".message").fadeOut().empty();
                    }, 5000);
                }
            }
        });
    }