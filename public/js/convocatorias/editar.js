/**
 * Archivo JavaScript para la vista de edición de convocatorias
 * Autor: Uriel Infante
 * Fecha: 04/05/17
 */


$(function() {
    var counter = 0;
    //Se asigna un formato a las fechas a la hora que carga la interfaz
    $("#fecha_inicio").val(moment($("#fecha_inicio").val(),"YYYY-MM-DD" ).format("DD MMM, YYYY"));
    $("#fecha_cierre").val(moment($("#fecha_cierre").val(), "YYYY-MM-DD").format("DD MMM, YYYY"));

    //Funcionalidad de botón eliminar
    $(".delete-doc").click(function(event) {
        var elem = $(this).parent().parent().parent(),
            id = $(this).data('id');
        $("#deleteModalDoc").openModal();

        /**
         * Se asigna el evento al botón de yes para
         */
        $("#yesBtn").unbind()
            .click({elem: elem, id: id}, function(event) {
                var arrIds = JSON.parse($("#input-deleted-docs").val());
                arrIds.push(id);
                $("#input-deleted-docs").val(JSON.stringify(arrIds));
                event.data.elem.remove();
                $("#deleteModalDoc").closeModal();
        });
    });

    //Funcionalidad de botón eliminar en nuevos
    $(document).on('click', '.delete-doc-nuevo', function(event) {
        var elem = $(this).parent().parent().parent();
        $("#deleteModalDoc").openModal();

        /**
         * Se asigna el evento al botón de yes para
         */
        $("#yesBtn").unbind()
            .click({elem: elem}, function(event) {
                event.data.elem.remove();
                $("#deleteModalDoc").closeModal();
            });
    });

    //Funcionalidad de botón Agregar documento
    $("#agregar-documento").click(function() {
        var section = $("<div class='section'/>"),
            row = $("<div class='row'/>"),
            img = $("<div class='col s1'/>"),
            divTitulo = $("<div class='input-field col s8'/>"),
            divFile = $("<div class='file-field input-field col s2'/>"),
            divX = $("<div class='s1'/>");

        //Se agrega la imagen al div img;
        img.append('<img src="../../img/ic_unknow.png" alt="">');

        //Se agrega input y label de título
        divTitulo
            .append('<input class="doc-titulo-nuevo" name="doc-titulo-nuevo[${counter}]" type="text" value=""  class="validate">')
            .append('<label for="titulo">Título</label>');
        //Se agregan los inputs de archivo
        divFile.append(`
           <div class="btn accent-color">
                <span>Agregar </span>
                <input type="file" class="input-file-nuevo" name="doc-file-nuevo[${counter}]" >
            </div>
        `);

        //El div para cerrar
        divX.append(`
           <a class="red-text large center-align delete-doc-nuevo" style="cursor: pointer" ><h5>&times;</h5></a> 
        `);

        row.append(img)
            .append(divTitulo)
            .append(divFile)
            .append(divX);

        section.append(row);

        counter++;

        $("#doc-container").append(section);
        $(".input-file-nuevo").each(function(){
            $(this).rules("add",{
                required:true,
                messages:{
                    required: "El archivo es bligatorio"
                }

            });
        });
    });

    //Validación de formulario para nueva convocatoria
    $("#form-editar").validate({
        submitHandler: function(form) {
            $("#fecha_inicio").val(moment($("#fecha_inicio").val(), "DD MMM, YYYY").format("YYYY-MM-DD"));
            $("#fecha_cierre").val(moment($("#fecha_cierre").val(), "DD MMM, YYYY").format("YYYY-MM-DD"));
            form.submit();
        },
        rules: {
            titulo: {
                required: true
            },
            "fecha_inicio": {
                required: true
            },
            "fecha_cierre": {
                required: true
            },
            descripcion: {
                required: true
            },
            "doc-file-nuevo": {
                required:true
            }
        },
        messages:{
            titulo: "Este campo es obligatorio",
            "fecha_inicio": "Este campo es obligatorio",
            "fecha_cierre": "Este campo es obligatorio",
            descripcion: "Este campo es obligatorio",
        },
        errorElement : 'span',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if($(element).attr('type') == "file"){
                element = $(element).parent().parent().find('[type=text]');
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
