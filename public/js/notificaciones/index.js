/**
 * Archivo de configuración de UI de la vista de notificaciones
 * Autor: Uriel Infante
 * Fecha: 10/05/2017
 */

/**
 * EventosUI
 * Método para la generación de eventos en la vista utilizando jQuery. Aquí se validan los checkbox de sexo, sistema
 * operativo; y el dropdown de edad.
 */
function eventosUI() {

    //No pueden estar sin selección los dos
    $("#chk_hombre").change(function() {
        if(!$(this).is(":checked")) {
            if(!$("#chk_mujer").is(":checked")) {
                $("#chk_mujer").prop("checked", true);
            }
        }
    });

    //Si no es mujer, se activa el checkbox de hombre
    $("#chk_mujer").change(function() {
        if(!$(this).is(":checked")) {
            if(!$("#chk_hombre").is(":checked")) {
                $("#chk_hombre").prop("checked", true);
            }
        }
    });

    //Si no está seleccionado Android, se selecciona iOS
    $("#chk_android").change(function() {
        if(!$(this).is(":checked")) {
            if(!$("#chk_ios").is(":checked")) {
                $("#chk_ios").prop("checked", true);
            }
        }
    });

    //Si no está seleccionado iOS se marca Android.
    $("#chk_ios").change(function(){
        if(!$(this).is(":checked")){
            if(!$("#chk_android").is(":checked")) {
                $("#chk_android").prop("checked", true);
            }
        }
    });

    //Funcionalidad para rango de edad, determina qué campos se van a mostrar.
    $("#sl_rango_edad").change(function() {
        //1 es el valor de TODOS, cuando se elige otra opción se muestra el primer campo.
        if(this.value > 1) {

            //Se muestra el primer campo y se oculta el segundo.
            $("#txt_age2").removeClass('invalid').siblings().remove();
            $("#txt_age1").css("display", "inline");
            $("#label_age").css("display", "inline");
            $("#txt_age2").css("display", "none");

            //El primer campo se vuelve obligatorio.
            $("#txt_age1").rules('add', {
                required:true,
                messages: {
                    required: "Este campo es requerido"
                }
            });

            //Se eliminan las validaciones del campo 2
            $("#txt_age2").rules('remove', "required");
        }

        //Si se selecciona ENTRE, se abilita el campo 2 con validación
        if(this.value == 2){
            $("#txt_age2").css("display", "inline");
            $("#txt_age2").rules('add', {
                required:true,
                messages: {
                    required: "Este campo es requerido"
                }
            });
        }

        //Si la opción es TODOS, se ocultan todos los campos de vuelta y se remueven las validaciones.
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

    //Muestra todos los selects con formato Materialize
    $('select').material_select();

    //Se oculta la vista de configuración avanzada y se genera su evento.
    $('.advanced').hide();
    $('#show-advanced').click(() => $(".advanced").toggle(500));

    //Evento para controlar el botón de eliminar múltiple
    $(".check-delete").change(function() {
        var flag = false;
        $.each($(".check-delete"), (index, val) => {
            if ($(val).prop('checked')){
                flag = true;
                return;
            }
        });
        if(flag){
            $("#delete-selection").show(500);
        }
        else {
            $("#delete-selection").hide(500);
        }
    });

    //Evento para eliminar una notificación individual.
    $(".delete-notif").click(function() {
        var ids = JSON.stringify([$(this).data('id')]);
        $("#id-eliminar").val(ids);
        $("#deleteModalNotif").openModal();
    });

    //Botón de eliminar múltiple.
    $("#delete-selection").click(function() {
        var ids =[];
        $.each($(".check-delete"), (index, val) => {
            if($(val).prop('checked')){

                ids.push($(val).val());
            }
        });
        $("#id-eliminar").val(JSON.stringify(ids));
        $("#deleteModalNotif").openModal();
    });

    $(document).on('click', '.pagination a', function(e) {
       e.preventDefault();
       var page = $(this).attr('href').split('page=')[1];
       getNotifications(page);
    });
}


function getNotifications(page) {
    $.ajax({
        url: '/notificaciones/lista?page=' + page
    }).done(function(data) {
        console.log(data);
        $("#table").html(data);
    });
}



$(function(){


    //Funcionalidad que agrega los eventos de UI para evitar mensajes inválidos.
    eventosUI();

    //Validación de formulario para nueva notificación
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
