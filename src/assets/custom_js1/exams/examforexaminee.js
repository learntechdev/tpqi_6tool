$("#btn_search").click(function () {
	search("1");
});

function search(prm_page_no) {
	bp.showLoading();
	$.ajax({
		url: "../../exam/Exam/search_examforexaminee",
		method: "GET",
		data: {
			page_no: prm_page_no,
			per_page: "15",
			keyword: $("#keyword").val(),
			tool_type: $("#tool_type").val(),
			exam_used: $("#exam_used").val(),
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
	$("#exam_used").val("").trigger("change");
	$("#tool_type").val("0");
	search(1);
});

//พิมพ์เอกสารสำหรับนำไปใช้สอบ
function printDocs(template_id, tool_type, tpqi_exam_no, doc_type) {
	// docs_type = 1 คือ สำหรับผู้เข้ารับการประเมิน, 2 คือ ผู้ประเมิน
	if (tool_type == "3" || tool_type == "4" || tool_type == "5") {
		window.open(
			"../../templates/Longanswer/exam_used_new?template_id=" +
				template_id +
				"&tool_type=" +
				tool_type +
				"&doc_type=" +
				doc_type,
			"_blank"
		);
	} else {
		sweet_alert(
			"<strong>เครื่องมือประเมินนี้ ไม่อนุญาตให้นำข้อสอบไปใช้!!!</strong>"
		);
	}
}

function printDiv(template_id, tool_type, url) {
	var oldPage = document.body.innerHTML;
	$.ajax({
		url: "../../" + url,
		method: "GET",
		data: {
			template_id: template_id,
			tool_type: tool_type,
		},
		success: function (data) {
			$("#div_print").empty();
			$("#div_print").html(data);

			$("#div_print").show();
			var graphElements = "";
			var divElements = document.getElementById("div_print").innerHTML;
			document.body.innerHTML =
				"<html><head>" +
				"<title></title>" +
				"</head><body>" +
				graphElements +
				divElements +
				"</body>";

			window.print();
			//Restore orignal HTML
			$("#div_print").hide();
			document.body.innerHTML = oldPage;
		},
	});
}

function exam_print(template_id, tool_type, exam_schedule_id) {
	if (tool_type == 3) {
		printDiv(template_id, "3", "templates/Longanswer/exam_used");
		/*window.open(
			"../../templates/Longanswer/exam_used?template_id=" +
				template_id +
				"&tool_type=3",
			"_blank"
		);*/
		/*update_exam_status(template_id, exam_schedule_id, tool_type);*/
	} else if (tool_type == 4) {
		//update_exam_status(template_id, exam_schedule_id, tool_type);
		printDiv(template_id, "4", "templates/Longanswer/exam_used");

		/*window.open(
			"../../simulation/SimulationTools/exam_preview?template_id=" +
				template_id,
			"_blank"
		);
		*/
	} else if (tool_type == 5) {
		printDiv(template_id, "5", "templates/Longanswer/exam_used");
		//update_exam_status(template_id, exam_schedule_id, tool_type);
		/*window.open(
			"../../demonstration/DemonstrationTools/exam_preview?template_id=" +
				template_id,
			"_blank"
		);*/
	} else if (tool_type == 7) {
		/*else if (tool_type == 6) {
		//printDiv(template_id, "6");
		window.open(
			"../../templates/Longanswer/exam_used?template_id=" +
				template_id +
				"&tool_type=6",
			"_blank"
		);
	} */
		//update_exam_status(template_id, exam_schedule_id, tool_type);
		window.open(
			"../../tools/Thirdparty/exam_preview?template_id=" + template_id,
			"_blank"
		);
	} else {
		sweet_alert(
			"<strong>เครื่องมือประเมินนี้ ไม่อนุญาตให้นำข้อสอบไปใช้!!!</strong>"
		);
	}
}

function assessor_print(template_id, tool_type, exam_schedule_id) {
	if (tool_type == 3) {
		printDiv(template_id, "3", "templates/Longanswer/assessor_print"); // 1 สำหรับผู้ประเมิน
	} else if (tool_type == 4) {
		printDiv(template_id, "4", "templates/Longanswer/assessor_print");
	} else if (tool_type == 5) {
		printDiv(template_id, "5", "templates/Longanswer/assessor_print");
	} else {
		sweet_alert(
			"<strong>เครื่องมือประเมินนี้ ไม่อนุญาตให้นำข้อสอบไปใช้!!!</strong>"
		);
	}
}

/*
function exam_print(template_id, tool_type, exam_schedule_id) {
	if (tool_type == 4) {
		update_exam_status(template_id, exam_schedule_id, tool_type);
		window.open(
			"../../simulation/SimulationTools/exam_preview?template_id=" +
				template_id,
			"_blank"
		);
	} else if (tool_type == 3) {
		update_exam_status(template_id, exam_schedule_id, tool_type);
		window.open(
			"../../templates/Longanswer/exam_used?template_id=" +
				template_id +
				"&tool_type=3",
			"_blank"
		);
	} else if (tool_type == 5) {
		update_exam_status(template_id, exam_schedule_id, tool_type);
		window.open(
			"../../demonstration/DemonstrationTools/exam_preview?template_id=" +
				template_id,
			"_blank"
		);
	} else if (tool_type == 6) {
		update_exam_status(template_id, exam_schedule_id, tool_type);
		window.open(
			"../../templates/Longanswer/exam_used?template_id=" +
				template_id +
				"&tool_type=6",
			"_blank"
		);
	} else if (tool_type == 7) {
		update_exam_status(template_id, exam_schedule_id, tool_type);
		window.open(
			"../../tools/Thirdparty/exam_preview?template_id=" + template_id,
			"_blank"
		);
	} else {
		sweet_alert(
			"<strong>เครื่องมือประเมินนี้ ไม่อนุญาตให้นำข้อสอบไปใช้!!!</strong>"
		);
	}
}
*/

//เมื่อกด print ให้อัพเดตสถานะของข้อสอบว่าถูกใช้งานแล้ว
function update_exam_status(template_id, exam_schedule_id, tool_type) {
	$.ajax({
		method: "POST",
		url: "../../exam/Exam/update_exam_status",
		data: {
			template_id: template_id,
			exam_schedule_id: exam_schedule_id,
			tool_type: tool_type,
		},
		dataType: "JSON",
		success: function (response) {
			if (response == 1) {
				search(1);
			}
		},
	});
}

//แสดงรายการเอกสารเพิ่มเติม สำหรับการสอบ
function show_docsexam(template_id) {
	$("#modal_docsexam").modal("show");
	$.ajax({
		type: "post",
		url: "../../shared/Shared/getDocsforExam",
		data: {
			template_id: template_id,
		},
		success: function (data) {
			$("#showdata").html(data);
		},
	});
}
