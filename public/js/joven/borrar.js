$(function () {
    $('.borrar').on('click', function () {
        var id = $(this).attr("data-user-id");
        $('#id_usuario').val(id);
        $('#modal-borrar').dialog({
            resizable: false,
            height: "auto",
            width: "auto",
            modal: true,
            buttons: [
                {
                    text: "Sí",
                    click: function(){
                        $('#form-borrar').submit();
                    }
                },
                {
                    text: "No",
                    click: function(){
                        $(this).dialog("close");
                    }
                }
            ]
        })
    })
});