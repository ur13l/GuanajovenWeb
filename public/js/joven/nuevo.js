$(function(){
  $('#form-nj').validate({
    rules:{
      nombre:"required",
      apellido_paterno:"required",
      apellido_materno:"required",
      fecha_nacimiento:"required",
      codigo_postal:"required",
      curp:"required"
    },
    messages:{
      nombre: "Este campo es obligatorio",
      apellido_paterno: "Este campo es obligatorio",
      apellido_materno: "Este campo es obligatorio",
      fecha_nacimiento: "Este campo es obligatorio",
      codigo_postal: "Este campo es obligatorio",
      curp: "Este campo es obligatorio"
    },
    submitHandler:function(form){
      $("#fecha_nacimiento").val(moment($("#fecha_nacimiento").val(), "DD MMM, YYYY").format("YYYY-MM-DD"));
      form.submit();
    }
  });
});

function readURL(input) {
  if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
          $('#image')
              .attr('src', e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
  }
}