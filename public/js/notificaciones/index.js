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

  $("#sl_rango_edad").change(function(){
     if(this.value > 1){
       $("#txt_age1").css("display", "inline");
       $("#label_age").css("display", "inline");
       $("#txt_age2").css("display", "none");
     }

     if(this.value == 2){
      $("#txt_age2").css("display", "inline");
     }

     if(this.value == 1){
      $("#txt_age1").css("display", "none");
      $("#txt_age2").css("display", "none");
      $("#label_age").css("display", "none");

     }
  });
}

function enviarNotificacion(){
    var tituloEmpty = isEmpty($("#titulo"));
    var mensajeEmpty = isEmpty($("#mensaje"));

    if(!tituloEmpty && !mensajeEmpty){
      $("#enviar").addClass('disabled');
      $("#enviar").prop('disabled', true);
      $('#enviar').removeClass('waves-effect')
      newNotification();
    }
}


$(function(){

  //Configuración para generar el SideNav
  $(".button-collapse").sideNav();

  //Configuración para abrir modal
  $('.modal-trigger').leanModal();


  //Necesario para sustituir el select común de HTML5 por el de Materialize
   $('select').material_select();


   validacionesModal();

   $("#enviar").on('click',enviarNotificacion);

   //Manejador del botón de eliminar selección
   $("#delete-selection").on('click', function(){
     $("#delete-message").html("¿Confirma que desea eliminar las notificaciones seleccionadas?");
     dialogDelete();
   });

});
