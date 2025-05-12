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

function search(prm_page_no) {
	console.log($("#keyword").val());
	console.log($("#tp_created_date_start").val());
	//	alert(prm_page_no);
	//bp.showLoading();
	$.ajax({
		url: "../../report/ReportExamResults/search",
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

function detailRoundExamResult(tpqi_exam_no, tool_type) {
	$.redirect("../../report/ReportExamResults/detailRoundExamResult", {
		tpqi_exam_no: tpqi_exam_no,
		tool_type: tool_type,
	});
}
