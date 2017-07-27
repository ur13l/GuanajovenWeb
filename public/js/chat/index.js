$(function() {
    $("#form_enviar").submit(function() {
        $.ajax({
            url: $("#_url").val() + "/api/chat/enviarAdmin",
            method: "POST",
            data: {
                "mensaje": $("#mensaje").val(),
                "api_token": $("#_api_token").val(),
                "active_chat": $("#_active_chat").val()
            },
            success: function (data) {
                console.log(data);
            }
        });
        
        return false;
    });
})