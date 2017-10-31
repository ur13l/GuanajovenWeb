$(function() {

    $("#buscarUsuarios").keydown(function() {

        var buscar = $(this).val();

        $.ajax({
            url: $("#_url").val() + "/api/chat/buscarUsuarios",
            method: "POST",
            data: {
                busqueda: buscar
            },
            success: function(data) {
                var lista_chats = $('#lista-chats');
                lista_chats.html("");

                jQuery.each(data, function(index, val) {

                    var idItem = val.chat_id !== null ? val.chat_id : val.user_id;
                    var claseItem = val.chat_id !== null ? 'chat-item' : 'user-item';

                    lista_chats.append(
                        '      <a href="#!" class="collection-item avatar ' + claseItem + '">' +
                        '      <input type="hidden" value="' + idItem + '" id="chat' + idItem + '">' +
                        '              <img src="' + val.ruta_imagen + '" alt="" class="circle">' +
                        '          <span  class="title accent-color-text">' + val.nombre + '</span>' +
                        '          <p class="grey-text">' + val.ultimo_mensaje + '</p>' +
                        '          <p class="grey-text secondary-content" style="margin-top:-5px" href="#!">' + val.fecha_ultimo + '</p>' +
                        '          <p href="#!"  class="secondary-content primary-color-text"><span style="margin-top:25px" class="badge">' + val.no_leidos + '</span></p>' +
                        '      </a>');
                });

                chat_item_event();
                user_item_event();

            }
        });
    });

    $("#form_enviar").submit(function() {
        var mensaje = $("#mensaje").val();
        $("#lista-mensajes").append("<li class='mensaje-derecha accent-color'>" + mensaje + "</li>");
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
            success: function(data) {
                console.log(data);
            }
        });

        return false;
    });

    function chat_item_event() {
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
                success: function(data) {
                    mensajes = data.data;
                    $("#lista-mensajes").html("");
                    for (var i = 0, max = mensajes.length; i < max; i++) {
                        if (mensajes[i].envia_usuario) {
                            $("#lista-mensajes").prepend("<li class='mensaje-izquierda primary-color'>" + mensajes[i].mensaje + "</li>");
                        } else {
                            $("#lista-mensajes").prepend("<li class='mensaje-derecha accent-color'>" + mensajes[i].mensaje + "</li>");
                        }
                    }
                    $("#lista-mensajes")[0].scrollTop = $("#lista-mensajes")[0].scrollHeight;
                }
            })
        });
    }
    chat_item_event();



    function user_item_event() {
        $(".user-item").click(function() {

            var idUser = $(this).find("[type=hidden]").val();

            $.ajax({
                url: $("#_url").val() + "/api/chat/nuevoChat",
                method: "POST",
                data: {
                    user_id: idUser
                },
                success: function(data) {
                    console.log(data);

                    $(this).removeClass('user-item');
                    $(this).addClass('chat-item');
                    $("#_active_chat").val(data);


                    $("#lista-mensajes").html("");
                    $("#lista-mensajes")[0].scrollTop = $("#lista-mensajes")[0].scrollHeight;
                }
            })
        });
    }
    user_item_event();

});


function actualizarListaChat() {
    $("#lista-chats").empty();
}