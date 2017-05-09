function validacionesModal(){
  $("#chk_hombre").change(function(){
    if(!$(this).is(":checked")){
      if(!$("#chk_mujer").is(":checked")){
        $("#chk_mujer").prop("checked", true);
      }
    }
  });

  $("#chk_mujer").change(function(){
    if(!$(this).is(":checked")){
      if(!$("#chk_hombre").is(":checked")){
        $("#chk_hombre").prop("checked", true);
      }
    }
  });

  $("#chk_android").change(function(){
    if(!$(this).is(":checked")){
      if(!$("#chk_ios").is(":checked")){
        $("#chk_ios").prop("checked", true);
      }
    }
  });

  $("#chk_ios").change(function(){
    if(!$(this).is(":checked")){
      if(!$("#chk_android").is(":checked")){
        $("#chk_android").prop("checked", true);
      }
    }
  });

  //TODO: Agregar validaciones para txt_age1 y 2
  $("#sl_rango_edad").change(function(){
     if(this.value > 1){

         $("#txt_age2").removeClass('invalid').siblings().remove();
       $("#txt_age1").css("display", "inline");
       $("#label_age").css("display", "inline");
       $("#txt_age2").css("display", "none");

       $("#txt_age1").rules('add', {
           required:true,
           messages: {
               required: "Este campo es requerido"
           }
       });

         $("#txt_age2").rules('remove', "required");
     }

     if(this.value == 2){
      $("#txt_age2").css("display", "inline");
         $("#txt_age2").rules('add', {
             required:true,
             messages: {
                 required: "Este campo es requerido"
             }
         });
     }

     if(this.value == 1){
         $("#txt_age1").removeClass('invalid').siblings().remove();
         $("#txt_age2").removeClass('invalid').siblings().remove();
          $("#txt_age1").css("display", "none");
          $("#txt_age2").css("display", "none");
          $("#label_age").css("display", "none");
         $("#txt_age1").rules('remove','required');
         $("#txt_age2").rules('remove', 'required');
     }
  });
}




$(function(){

  //Necesario para sustituir el select común de HTML5 por el de Materialize
   $('select').material_select();
    $('.advanced').hide();
    $('#show-advanced').click(() => $(".advanced").toggle(500));

   validacionesModal();

    //Validación de formulario para nueva convocatoria
    $("#form-enviar").validate({
        rules: {
            titulo: {
                required: true
            },
            mensaje: {
                required: true
            },

        },
        messages: {
            titulo: "Este campo es obligatorio",
            mensaje: "Este campo es obligatorio"
        },
        errorElement : 'span',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if($(element).attr('type') == "file"){
                element = $(element).parent().parent().parent().find('[type=text]');
            }
            $(element).addClass('invalid');
            $(error).css('color', '#F44336 ');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element)[0];
            }
        }
    });


});
