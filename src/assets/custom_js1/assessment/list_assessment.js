function goto_applicant_assessment(
	org_id,
	occ_level_name,
	template_id,
	exam_schedule_id,
	tool_type,
	occ_level_id
) {
	$.redirect("../../assessment/Assessment/applicant_assessment", {
		org_id: org_id,
		occ_level_name: occ_level_name,
		template_id: template_id,
		exam_schedule_id: exam_schedule_id,
		tool_type: tool_type,
		occ_level_id,
	});
}

$("#btn_search").click(function () {
	search("1");
});

function search(prm_page_no) {
	bp.showLoading();
	$.ajax({
		url: "../../assessment/Assessment/search",
		method: "GET",
		data: {
			page_no: prm_page_no,
			per_page: "15",
			keyword: $("#keyword").val(),
			ass_status: $("#ass_status").val(),
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
