$(function(){

    //Funcionalidad de los botones para eliminar una publicidad.
    $(".deleteP").click(function(){
        var btn = $(this),
            yesButton = null,
            id;
        $('#deleteModalPub').openModal();
        $("#id-eliminar").val(btn.data('id'));
    });

    //Validación de formulario para nueva publicidad
    $("#form-nuevo").validate({
        submitHandler: function(form) {
            $("#fecha-inicio").val(moment($("#fecha-inicio").val(), "DD MMM, YYYY").format("YYYY-MM-DD"));
            $("#fecha-fin").val(moment($("#fecha-fin").val(), "DD MMM, YYYY").format("YYYY-MM-DD"));
            form.submit();
        },
        rules: {
            titulo: {
                required: true
            },
            "fecha-inicio": {
                required: true
            },
            "fecha-fin": {
                required: true
            },
            url: {
                required: true
            },
            imagen: {
                required: true
            }
        },
        messages: {
            titulo: {
                required: "Ingrese el título de esta publicidad"
            },
            "fecha-inicio": {
                required: "Este campo es obligatorio"
            },
            "fecha-fin": {
                required: "Este campo es obligatorio"
            },
            url: {
                required: "Este campo es obligatorio"
            },
            imagen: {
                required: "La imagen es obligatoria"
            }
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            $(element).addClass('invalid');
            $(error).css('color', '#F44336 ');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        }
    });


});
