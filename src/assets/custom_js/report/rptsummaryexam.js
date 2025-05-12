$(document).ready(function () {});

function search(prm_page_no) {
	bp.showLoading();
	$.ajax({
		url: "../../report/RptSummaryExam/search",
		method: "GET",
		data: {
			page_no: prm_page_no,
			per_page: "15",
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
