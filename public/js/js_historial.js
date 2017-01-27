// JavaScript Document
jQuery(document).ready(function(){

	load_historial();

});

function load_historial(){


	var table = $('#example').DataTable( {
		"ajax": "../inc/funcion.php",
		"processing": true,
        "serverSide": true,
		"destroy": true,
		"info":     false,
		"bFilter": false, 
		"bLengthChange": false,
		"language": {
                		"url": "../../js/DataTables/es_ES.txt"
            								},

								/*dom: 'Bfrtip',
								buttons: [

								{
									extend:'pdfHtml5',
									download: 'open',
									orientation: 'landscape',
                                    pageSize: 'LEGAL'

								},
				 				 'excelHtml5',

							 ]	*/
	"order": [[1, 'asc']],
	 "columnDefs": [
            {
                targets: [ 0, 1, 2 ],
                className: 'mdl-data-table__cell--non-numeric'
            }
        ]	


    } );

}


function reg_tip(id){
	
	
	
	$.ajax({
  			url: "../inc/modal_ajax.php?cmd=add_reg&id=" + id,
  			context: document.body,
  			dataType : "html", 
			success: function(data){ 
				   
				   $('#modalData').html(data);
				   
					$('#myModal').openModal();
                   
				  
				  
			}
			

		});	
	
		
	return false;	
	
	
}	  


function save_registro(){
	
	($('#act_hombre').prop('checked')) ? $('#act_hombre').val(1): $('#act_hombre').val(0);
	($('#act_mujer').prop('checked')) ? $('#act_mujer').val(1): $('#act_mujer').val(0);
	
	($('#act_pa').prop('checked')) ? $('#act_pa').val(1): $('#act_pa').val(0);
	($('#act_gl').prop('checked')) ? $('#act_gl').val(1): $('#act_gl').val(0);
	($('#act_af').prop('checked')) ? $('#act_af').val(1): $('#act_af').val(0);
	($('#act_lesion').prop('checked')) ? $('#act_lesion').val(1): $('#act_lesion').val(0);
	  
	   var inputFile = document.getElementById("file1");
		
       var file = inputFile.files[0];
	        
	        var datos = new FormData(document.getElementById('floatForm'));
			datos.append("file1",file);
		
	        $('#btnGuardar').disabled = true;
	var percent = 0;	
	$.ajax({
			type: "POST",
			url: "../inc/guardar.php",
			dataType : "html",
			data: datos,
			processData: false,
            contentType: false,
			//beforeSend: guardando(),
			/*uploadProgress: function(event, position, total, percentComplete) { //on progress
						 var percent = (position / total) * 100;
                         $(".determinate").css("width", Math.round(percent)+"%");
            },*/
			success: function(val) { 
				
				$('#myModal').closeModal();
				//$('#myModal').modal('hide');
				//tinymce.remove();
			    load_historial();
				
			}
		
		});
	
}    







function delete_enlace(ide){

		//var datos = $('#formex');
		var datos = {  "cmd" : 'del_enl', 'keyidvalpersona' : ide, "ud_vigente" : '0' };

		conf = confirm("Esta seguro que desea borrar este registro?","si");
		if (conf==true){
			$.ajax({
				type: "POST",
				url: "inc/valores.php",
				dataType : "html",
				data: $.param(datos),
				beforeSend: guardando(),
				success: function(val) {
				  destroy_guardando();
				  load_enlaces();

				}
			});
		}
}
