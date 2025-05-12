$(document).ready(function () {
	$(".occ_level").select2({ allowClear: true });
});

function show_criteria(
	occ_level_id,
	occ_level_name,
	place,
	exam_date,
	exam_schedule_id,
	status,
	tool_type
) {
	var modal = "";
	if (status == "1") {
		modal = "modal_criteriaforexam";
		populate_template(occ_level_id, tool_type);
	}

	$("#" + modal).modal("show");
	$(".modal-body #occ_level_id").val(occ_level_id);
	$(".modal-body #occ_level_name").text(occ_level_name);
	$(".modal-body #place").text(place);
	$(".modal-body #exam_date").text(exam_date);
	$(".modal-body #exam_schedule_id").val(exam_schedule_id);
	$(".modal-body #txt_tool_type").val(tool_type);
}

//ดึงข้อมูลเทมเพลตไปใส่ใน ddl ของ modal form
function populate_template(occ_level_id, tool_type) {
	$.ajax({
		method: "POST",
		url: "../../approve/Approve/get_template",
		data: {
			occ_level_id: occ_level_id,
			tool_type: tool_type,
		},
		success: function (data) {
			console.log("data:" + data);
			$("#template").html(data);
		},
	});
}

$("#btn_search").click(function () {
	search("1");
});

$("#btn_clear").click(function () {
	$("#occ_level_id").val("").trigger("change");
	$("#tool_type").val("0");
	$("#status").val("0");
	search(1);
});

function search(prm_page_no) {
	bp.showLoading();
	$.ajax({
		url: "../../approve/Approve/choose_exam",
		method: "GET",
		data: {
			page_no: prm_page_no,
			per_page: "10",
			occ_level_id: $("#occ_level_id").val(),
			tool_type: $("#tool_type").val(),
			status: $("#status").val(),
			type: $("#txt_type").val(),
			action: "search",
		},
		success: function (data) {
			bp.hideLoading();
			$("#show_data").empty();
			$("#show_data").html(data);
		},
	});
}

function page(page_no) {
	search(page_no);
}
