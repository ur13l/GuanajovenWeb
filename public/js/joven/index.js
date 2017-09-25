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

    $(document).on('click', '.header', function(e){   
        if(columna == $(this).data('field')){
            if(tipo == "asc"){
                tipo = "desc";
            }
            else{
                tipo = "asc";
            }
        }
        else {
            tipo ="asc";
        }
        columna = $(this).data('field')
    
        getJovenes(1, $("#icon_search").val());
    });
    
    $("#icon_search").on("keyup paste change", function(e){
        getJovenes(1, $(this).val())
    }) 
     
});
 
var xhr, columna = "usuario.id", tipo="asc";
function getJovenes(page, q) {
    if(xhr){
        xhr.abort();
    }
    xhr = $.ajax({
        url: $("#_url").val() + '/jovenes/buscar',
        data: {
            page: page,
            q: q,
            columna: columna,
            tipo: tipo 
        }
    }).done(function(data) {
        $("#table").html(data);
    });
}

