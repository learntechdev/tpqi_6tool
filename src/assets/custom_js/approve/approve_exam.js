$(document).ready(function () {
	$("#reason_disapproval").prop("readonly", true);
	$(".occ_level").select2({ allowClear: true });
});

function show_criteria(
	occ_level_id,
	occ_level_name,
	place,
	exam_date,
	exam_schedule_id,
	status,
	tool_type,
	template_id
) {
	populate_template(template_id);
	populate_criteria(template_id);
	$("#modal_approveexam").modal("show");
	$(".modal-body #occ_level_id").val(occ_level_id);
	$(".modal-body #occ_level_name").text(occ_level_name);
	$(".modal-body #place").text(place);
	$(".modal-body #exam_date").text(exam_date);
	$(".modal-body #exam_schedule_id").val(exam_schedule_id);
	$(".modal-body #txt_tool_type").val(tool_type);
	$(".modal-body #txt_template_id").val(template_id);
}

//ดึงข้อมูลเทมเพลตไปใส่ใน ddl ของ modal form

function populate_template(template_id) {
	$.ajax({
		method: "POST",
		url: "../../approve/Approve/get_template_forapprove",
		data: {
			template_id: template_id,
		},
		success: function (data) {
			$("#template").html(data);
		},
	});
}

function populate_criteria(template_id) {
	$.ajax({
		method: "POST",
		dataType: "JSON",
		url: "../../approve/Approve/get_criteria",
		data: {
			template_id: template_id,
		},
		success: function (res) {
			var rs = JSON.parse(JSON.stringify(res));
			var criteria_desc = "";
			if (rs[0].criteria_used_byexamier != "1") {
				criteria_desc = "ไม่กำหนดเกณฑ์";
			} else {
				criteria_desc = rs[0].description;
			}
			$("#span_criteria").text(criteria_desc);
		},
	});
}

function search(prm_page_no) {
	//bp.showLoading();
	$.ajax({
		url: "../Approve/get_examforapprove",
		method: "GET",
		data: {
			page_no: prm_page_no,
			per_page: "10",
			occ_level_id: $("#occ_level_id").val(),
			tool_type: $("#tool_type").val(),
			status: $("#status").val(),
			action: "search",
		},
		success: function (data) {
			//bp.hideLoading();
			$("#show_data").empty();
			$("#show_data").html(data);
		},
	});
}

function page(page_no) {
	search(page_no);
}

$("#btn_search").click(function () {
	search(1);
});

$("#btn_cleardata").click(function () {
	$("#occ_level_id").val("").trigger("change");
	$("#tool_type").val("0");
	$("#status").val("0");
	search(1);
});
