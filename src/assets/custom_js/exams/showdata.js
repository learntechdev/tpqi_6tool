function show_criteria(occ_level_id, occ_level_name, place, exam_date, exam_schedule_id, status, tool_type) {
	var modal = "";
	if (status == "4") {
		modal = "modal_approvecriteriaforexam";
	} else {
		modal = "modal_criteriaforexam";
		populate_template(occ_level_id);
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
function populate_template(occ_level_id) {
	$.ajax({
		method: "POST",
		url: "../../exam/Exam/get_template",
		data: {
			occ_level_id: occ_level_id
		},
		success: function (data) {
			//console.log("data:" + data);
			$('#template').html(data);
		},
	});
}

$("#btn_pickexam").click(function () {
	//console.log(JSON.stringify($("#form_exam_criteria").serializeJSON()));
	$.ajax({
		method: "POST",
		url: "../../exam/Exam/pickexam",
		data: {
			dt: JSON.stringify($("#form_exam_criteria").serializeJSON()),
			action: "create",
		},
		success: function (response) {
			if (response == 1) {
				$("#modal_criteriaforexam").modal("hide");
				$("#modal_alert").modal("show");
				$(".modal-body #span_msg").text("กำหนดชุดข้อสอบเรียบร้อยแล้ว");
				$("#btn_ok").click(function () {
					$("#modal_alert").modal("hide");
					search(1);
				});
			}
		},
	});
});

$("#btn_search").click(function () {
	search("1");
});

$("#btn_clear").click(function () {
	$('input[type=text]').val('');
	$("#tool_type").val('0');
	$("#status").val('0');
	search(1);
})

function search(prm_page_no) {
	bp.showLoading();
	$.ajax({
		url: "../Exam/search",
		method: "GET",
		data: {
			page_no: prm_page_no,
			per_page: "15",
			keyword: $("#keyword").val(),
			tool_type: $("#tool_type").val(),
			status: $("#status").val(),
			type: $("#txt_type").val()
		},
		success: function (data) {
			bp.hideLoading();
			$("#show_data").empty();
			$("#show_data").html(data);
		},
	});
}

$("#btn_priview_exam").click(function () {
	var template_id = $("#template").val();
	var tool_type = $("#txt_tool_type").val();

	if (template_id == 0 || template_id == "") {
		sweet_alert("<strong>ไม่มีข้อมูลเทมเพลต!!!</strong>");
	} else {
		if (tool_type == 3) {
			window.open("../../interview/InterviewPreview/index?template_id=" + template_id, "_blank");
		} else if (tool_type == 2) {
			window.open("../../demonstration/DemonstrationPreview/index?template_id=" + template_id, "_blank");
		} else if (tool_type == 4) {
			window.open("../../portfolio/PortfolioTools/exam_preview?template_id=" + template_id, "_blank");
		} else {
			sweet_alert("<strong>อยู่ระหว่างดำเนินการ!!!</strong>");
		}
	}
})

function page(page_no) {
	search(page_no);
}