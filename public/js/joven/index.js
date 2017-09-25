$(function(){

    //Funcionalidad de los botones para eliminar un joven.
    $(document).on('click', '.borrar', function(e){
        var btn = $(this),
            yesButton = null,
            id;
        $("#modal-borrar").openModal();
        $("#id_usuario").val(btn.data('user-id'));
    });

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getJovenes(page, $("#icon_search").val());

     });
    
    $("#icon_search").on("keyup paste change", function(e){
        getJovenes(1, $(this).val())
    }) 
     
});

var xhr;
function getJovenes(page, q) {
    if(xhr){
        xhr.abort();
    }
    xhr = $.ajax({
        url: $("#_url").val() + '/jovenes/buscar',
        data: {
            page: page,
            q: q
        }
    }).done(function(data) {
        $("#table").html(data);
    });
}

