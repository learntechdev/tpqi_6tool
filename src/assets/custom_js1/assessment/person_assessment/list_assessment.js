function goto_assessment(exam_template_id, exam_schedule_id, app_id) {
	//alert(exam_template_id);
	$.redirect("../../portfolio/Portfolio/index", {
		template: exam_template_id,
		exam_schedule_id: exam_schedule_id,
		app_id: app_id,
		action: "create",
	});
}

function edit_file_upload(exam_template_id, exam_schedule_id, app_id) {
	$.redirect("../../portfolio/Portfolio/index", {
		template: exam_template_id,

		exam_schedule_id: exam_schedule_id,

		app_id: app_id,

		action: "edit",
	});
}

$("#btn_search").click(function () {
	search("1");
});

function search(prm_page_no) {
	bp.showLoading();

	$.ajax({
		url: "../../assessment/PersonAssessment/search",

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

$("#btn_clear").click(function () {
	$("input[type=text]").val("");

	$("#ass_status").val("");

	search(1);
});

function page(page_no) {
	search(page_no);
}
