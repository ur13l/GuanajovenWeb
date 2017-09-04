$(function() {
    //Funcionalidad de los botones para eliminar un joven.
    $(".borrar").click(function(){
        var btn = $(this),
            yesButton = null,
            id;
        $("#modal-borrar").openModal();
        $("#id_usuario").val(btn.data('user-id'));
    });
})
