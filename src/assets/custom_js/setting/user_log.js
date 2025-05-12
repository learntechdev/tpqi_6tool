
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

	console.log($('#asm_tool').val())
	console.log($('#log_action').val())
	//	alert(prm_page_no);
	//bp.showLoading();
	$.ajax({
		url: "../../settings/Userlog/search",
		method: "GET",
		data: {
			page_no: prm_page_no,
			per_page: "10",
			asm_tool: $('#asm_tool').val(),
			log_action: $('#log_action').val(),
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
	$("#asm_tool").val("").trigger("change");
	$("#log_action").val("").trigger("change");
	$("#tp_created_date_start").val("");
	$("#tp_created_date_end").val("");
	search(1);
});


function export_excel() {
	page_no = 1;
	per_page = 9999;
	asm_tool = $("#asm_tool").val();
	log_action = $("#log_action").val();
	tp_created_date_start = $("#tp_created_date_start").val();
	tp_created_date_end = $("#tp_created_date_end").val();
	window.open(
		"../../settings/Userlog/export_excel?page_no=" +
		page_no +
		"&per_page=" +
		per_page +
		"&asm_tool=" +
		asm_tool +
		"&log_action=" +
		log_action +
		"&tp_created_date_start=" +
		tp_created_date_start +
		"&tp_created_date_end=" +
		tp_created_date_end
	);
}