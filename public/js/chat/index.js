$(function() {
    
    $("#form_enviar").submit(function() {
        var mensaje = $("#mensaje").val();
        $("#lista-mensajes").append("<li class='mensaje-derecha accent-color'>" +  mensaje  + "</li>");
        $("#lista-mensajes")[0].scrollTop = $("#lista-mensajes")[0].scrollHeight;
        $("#mensaje").val('')
        $.ajax({
            url: $("#_url").val() + "/api/chat/enviarAdmin",
            method: "POST",
            data: {
                "mensaje": mensaje,
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
                    if(mensajes[i].envia_usuario) {
                        $("#lista-mensajes").prepend("<li class='mensaje-izquierda primary-color'>" + mensajes[i].mensaje + "</li>");
                    }
                    else {
                        $("#lista-mensajes").prepend("<li class='mensaje-derecha accent-color'>" + mensajes[i].mensaje + "</li>");
                    }
                }
                $("#lista-mensajes")[0].scrollTop = $("#lista-mensajes")[0].scrollHeight; 
            }
        })
    });
});


function actualizarListaChat () {
    $("#lista-chats").empty();
}