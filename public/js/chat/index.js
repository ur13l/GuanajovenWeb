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

    $(".chat-item").click(function() {
        var idChat = $(this).find("[type=hidden]").val();
        $("#_active_chat").val(idChat);
        console.log(idChat);
        $.ajax({
            url: $("#_url").val() + "/api/chat/mensajesAdmin",
            method: "POST",
            data: {
                api_token: $("#_api_token").val(),
                id_chat: idChat,
                page: '1'
            },
            success: function (data) {
                mensajes = data.data;
                     $("#lista-mensajes").html("");
                for( var i = 0, max = mensajes.length; i< max ; i++) {

                    console.log(mensajes[i]);
                    if(mensajes[i].envia_usuario) {
                        $("#lista-mensajes").prepend("<li class='mensaje-izquierda primary-color'>" + mensajes[i].mensaje + "</li>");
                    }
                    else {
                        $("#lista-mensajes").prepend("<li class='mensaje-derecha accent-color'>" + mensajes[i].mensaje + "</li>");
                    }
                }
            }
        })
    });
})