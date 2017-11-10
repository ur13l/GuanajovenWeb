$(function() {
  //Necesario para sustituir el select común de HTML5 por el de Materialize
   $('select').material_select();
    //Validación de formulario para nueva convocatoria
    $("#form-crear").validate({
        submitHandler: function(form) {
            form.submit();
        },

        rules: {
            "curp": { required: true },
            "nombre": { required: true },
            "apellido_paterno": { required: true },
            "apellido_materno": { required: true },
            "correo": { required: true },
            "password": { required: true },
            "confirmar_password": { required: true }
        },
        messages:{
            "curp": "Este campo es obligatorio",
            
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
