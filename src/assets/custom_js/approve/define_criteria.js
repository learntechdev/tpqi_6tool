$(document).ready(function () {
	$(".occ_level").select2({ allowClear: true });
	//$('#full_score, #pass_score, #percent_score').prop('readonly', true);
	//$('#full_score, #pass_score, #percent_score').val('');
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
	if (occ_level_id != "") {
		populate_criteria(
			occ_level_id,
			occ_level_name,
			place,
			exam_date,
			exam_schedule_id,
			status,
			tool_type,
			template_id
		);
	}
}

function populate_criteria(
	occ_level_id,
	occ_level_name,
	place,
	exam_date,
	exam_schedule_id,
	status,
	tool_type,
	template_id
) {
	$.ajax({
		method: "POST",
		dataType: "JSON",
		url: "../../approve/Approve/get_criteria",
		data: {
			occ_level_id: occ_level_id,
			template_id: template_id,
		},
		success: function (res) {
			var rs = JSON.parse(JSON.stringify(res));
			console.log("rs:" + rs);
			var criteria_desc = "";
			if (rs[0].criteria_used_byexamier != "1") {
				$(".modal-body #define_criteria_1").prop("checked", true);
				$(".modal-body #percent_score").prop("readonly", true);
				criteria_desc = "ไม่กำหนดเกณฑ์";
			} else {
				$(".modal-body #define_criteria_2").prop("checked", true);
				$(".modal-body #percent_score").prop("readonly", false);
				criteria_desc = rs[0].description;
			}

			$("#modal_approvecriteria").modal("show");
			$(".modal-body #occ_level_id").val(occ_level_id);
			$(".modal-body #occ_level_name").text(occ_level_name);
			$(".modal-body #place").text(place);
			$(".modal-body #exam_date").text(exam_date);
			$(".modal-body #exam_schedule_id").val(exam_schedule_id);
			$(".modal-body #txt_tool_type").val(tool_type);
			$(".modal-body #span_criteria").text(criteria_desc);
		},
	});
}

function search(prm_page_no) {
	//bp.showLoading();
	$.ajax({
		url: "../Approve/define_criteria",
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
