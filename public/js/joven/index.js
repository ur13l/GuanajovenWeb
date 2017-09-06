$(function(){

    //Funcionalidad de los botones para eliminar un joven.
    $(".borrar").click(function(){
        var btn = $(this),
            yesButton = null,
            id;
        $("#modal-borrar").openModal();
        $("#id_usuario").val(btn.data('user-id'));
    });

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getNotifications(page);
     });

     function getNotifications(page) {
        $.ajax({
            url: $("#_url").val() + '/jovenes/lista?page=' + page
        }).done(function(data) {
            $("#table").html(data);
        });
    }

});
