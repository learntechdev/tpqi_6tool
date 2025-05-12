
$(document).ready(function () {
	$("#tp_created_date_start")
		.datepicker({
			language: "th-th",
			autoclose: true,
		})
		.on("changeDate", function (ev) {
			$("#tp_created_date_start").datepicker("hide");
		});


	$("#tp_created_date_end")
		.datepicker({
			language: "th-th",
			autoclose: true,
		})
		.on("changeDate", function (ev) {
			$("#tp_created_date_end").datepicker("hide");
		});



});

function validate_form() {
	var title = $('#title').val();
	var description = $('#description').val();
	var min_score = $('#min_score').val();
	var max_score = $('#max_score').val();

	var check = true;

	if (title == '') {
		$('#valid_title').text('*กรุณากรอก ชื่อเกณฑ์การประเมิน');
		check = false;
	}
	if (description == '') {
		$('#valid_description').text('*กรุณากรอก รายละเอียดเกณฑ์การประเมิน');
		check = false;
	}
	if (min_score == '') {
		$('#valid_min_score').text('*กรุณากรอก คะแนนต่ำสุด');
		check = false;
	}
	if (max_score == '') {
		$('#valid_max_score').text('*กรุณากรอก คะแนนสูงสุด');
		check = false;
	}
	return check;
}

function clear_valid() {
	$('#valid_title').text('');
	$('#valid_description').text('');
	$('#valid_min_score').text('');
	$('#valid_max_score').text('');
}
function search(prm_page_no) {

	console.log($('#keyword').val())
	console.log($('#tp_created_date_start').val())
	//	alert(prm_page_no);
	//bp.showLoading();
	$.ajax({
		url: "../../settings/CriteriaTool/search",
		method: "GET",
		data: {
			page_no: prm_page_no,
			per_page: "10",
			keyword: $("#keyword").val(),
			tp_created_date_start: $("#tp_created_date_start").val(),
			tp_created_date_end: $("#tp_created_date_end").val(),

		},
		success: function (data) {
			//	console.log(data);
			//bp.hideLoading();
			$("#show_data").empty();
			$("#show_data").html(data);
		},
	});
}

function page(page_no) {
	search(page_no);
}
$("#btn_clear").click(function () {
	$("#keyword").val("");
	$("#tp_created_date_start").val("");
	$("#tp_created_date_end").val("");
	search(1);
});


function btn_create() {
	$('#form_criteria_tool').modal('show');
	$('#modal_title').text('เพิ่มเกณฑ์');
	$('#form_type').val('create');
	$('#criteria_type_id').val('');

	$('#title').val('');
	$('#description').val('');
	$('#min_score').val('');
	$('#max_score').val('');

	clear_valid();


}

function btn_edit(criteria_type_id) {
	clear_valid();

	$('#form_criteria_tool').modal('show');
	$('#modal_title').text('แก้ไขเกณฑ์');
	$('#form_type').val('edit');
	$('#criteria_type_id').val(criteria_type_id);

	$.ajax({
		url: "../../settings/CriteriaTool/get_detail",
		method: "POST",
		data: {
			criteria_type_id: criteria_type_id,
		},
		dataType: "JSON",
		success: function (data) {
			$('#title').val(data['title']);
			$('#description').val(data['description']);
			$('#min_score').val(data['min_score']);
			$('#max_score').val(data['max_score']);

			if (data['status'] == '1') {
				document.getElementById("status1").checked = true;
			} else {
				document.getElementById("status0").checked = true;
			}
		},
	});




}

function btn_save() {
	var form_type = $('#form_type').val();
	var criteria_type_id = $('#criteria_type_id').val();
	var title = $('#title').val();
	var description = $('#description').val();
	var status = '';

	var min_score = $('#min_score').val();
	var max_score = $('#max_score').val();
	$("input[name='status']:checked").each(function () {
		status = $(this).val();
	});

	if (validate_form()) {
		$.ajax({
			url: "../../settings/CriteriaTool/save_criteria",
			method: "GET",
			data: {
				form_type: form_type,
				criteria_type_id: criteria_type_id,
				title: title,
				description: description,
				status: status,
				min_score: min_score,
				max_score: max_score,
			},
			dataType: "JSON",
			success: function (data) {
				$('#form_criteria_tool').modal('hide');
				setTimeout(() => {
					search(1);
				}, 200);
			},
		});

	}

}