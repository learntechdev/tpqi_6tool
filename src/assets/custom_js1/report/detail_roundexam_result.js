function search(prm_page_no) {
	$.ajax({
		url: "../../report/ReportExamResults/searchDetailRoundExamResult",
		method: "POST",
		data: {
			page_no: prm_page_no,
			per_page: "10",
			keyword: $("#keyword").val(),
			tp_created_date_start: $("#tp_created_date_start").val(),
			tp_created_date_end: $("#tp_created_date_end").val(),
			tpqi_exam_no: $("#tpqi_exam_no").val(),
			tool_type: $("#tool_type").val(),
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
