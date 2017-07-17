
$(function() {
    //Funcionalidad de los botones para eliminar una publicidad.
    $(".deleteP").click(function(){
        var btn = $(this),
            yesButton = null,
            id;
        $('#deleteModalConv').openModal();
        $("#id-eliminar").val(btn.data('id'));
    });



})
