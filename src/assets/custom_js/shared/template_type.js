/*$(document).ready(function () {

	result = "<option value='0'>--กรุณาเลือก--</option>";

	$('#template_type').html(result);

	

});*/



$("#exam_type").change(function () {
	
	$("#txt_asm_tool").val($("#exam_type").val());

   get_template_type($("#exam_type").val());

});



function get_template_type()

{

    $.ajax({

		url: "../../settings/MasterData/get_template_type",

		method: "POST",

		async : true,

		dataType : 'json',

		data: {

            asm_tool : $("#txt_asm_tool").val(),

            exam_type : $("#exam_type").val()

		},

		success: function (data) {



			$("#template_type").empty();

			$("#template_type").show();



			var result = '';

			var i;

			var select = "";

			var tp_type = $("#txt_template_type").val();

			//alert("from javascript : ");

			result = "<option value='0'>--กรุณาเลือก--</option>";

			for(i=0; i<data.length; i++){
			  if(data[i].template_type != 2){

				if(data[i].template_type == tp_type){

					select = "selected";

				}else{

					select = "";

				}

				result += '<option value='+data[i].template_type+ ' '+ select+'>'+data[i].name+'</option>';
			  }
			}

			//console.log(result);

			$('#template_type').html(result);
			$('#template_type').prop('disabled', false);



		},

	});

}

