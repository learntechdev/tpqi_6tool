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
			occ_level_id: occ_level_id,
		},
		success: function (data) {
			//console.log("data:" + data);
			$("#template").html(data);
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
	$("#occ_level_id").val("").trigger("change");
	$("#tool_type").val("0");
	$("#status").val("0");
	search(1);
});

function search(prm_page_no) {
	bp.showLoading();
//alert($("#occ_level_id").val())	;
	$.ajax({
		url: "../Approve/search",
		method: "GET",
		data: {
			page_no: prm_page_no,
			per_page: "10",
			occ_level_id: $("#occ_level_id").val(),
			tool_type: $("#tool_type").val(),
			status: $("#status").val(),
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

function update_approve_status(status, template_id, tool_type) {
	if (status == "2") {
		//ไม่อนุมัติต้องระบุเหตุผล
		(async () => {
			const { value: text } = await Swal.fire({
				input: "textarea",
				inputLabel: "เหตุผลที่ไม่อนุมัติ",
				inputPlaceholder: "กรุณากรอก เหตุผลที่ไม่อนุมัติ",
				inputAttributes: {
					"aria-label": "",
				},
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				confirmButtonText: "บันทึก",
				cancelButtonText: "ยกเลิก",
			});

			if (text) {
				sendtoapprove_reviewexam(status, template_id, text, tool_type);
			} else {
				sweet_alert("<strong>กรุณากรอก เหตุผลที่ไม่อนุมัติ!!!</strong>");
			}
		})();
	} else {
		Swal.fire({
			title: "ยืนยัน!!!",
			text: "คุณต้องการส่งข้อสอบไปอนุมัติใช่หรือไม่?",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			confirmButtonText: "ใช่",
			cancelButtonText: "ยกเลิก",
		}).then((result) => {
			if (result.isConfirmed) {
				sendtoapprove_reviewexam(status, template_id, "", tool_type);
			}
		});
	}
}

function sendtoapprove_reviewexam(
	status,
	template_id,
	reason_disapprove,
	tool_type
) {
	
	alert("status is :"+status);
	alert("reason for disapprove :"+reason_disapprove);
	alert("template_id is :"+template_id);
	alert("tool_type is :"+tool_type);
	//bp.showLoading();
	$.ajax({
		url: "../Approve/approve_review_exam",
		method: "POST",
		data: {
			template_id: template_id,
			status: status,
			tool_type: tool_type,
			reason_disapprove: reason_disapprove,
		},
		
		success: function (res) {
			//bp.hideLoading();
			alert("success function");
			if (res == 1) {
				success_alert("<strong>บันทึกข้อมูลเรียบร้อยแล้ว</strong>");
				search(1);
			}
		},
	});
}

function preview_exam(template_id, tool_type, template_type, exam_type) {
	/*window.open(
		"../../templates/Longanswer/exam_preview_html?template_id=" +
			template_id +
			"&tool_type=" +
			tool_type + 
			"&doc_type=2",
		"_blank"
	);
	*/
	if (template_id == 0 || template_id == "") {
		sweet_alert("<strong>กรุณาเลือกชุดข้อสอบ!!!</strong>");
	} else {
		if (tool_type == 4) {
			window.open(
				"../../simulation/SimulationTools/exam_preview?template_id=" +
					template_id,
				"_blank"
			);
		} else if (tool_type == 5) {
			/*window.open(
				"../../demonstration/DemonstrationTools/exam_preview?template_id=" +
					template_id +
					"&tool_type="+tool_type ,
				"_blank"
			);*/
			window.open(
				"../../templates/Longanswer/exam_preview_html?template_id=" +
					template_id +
					"&tool_type=" + tool_type,
				"_blank"
			);
		} else if (tool_type == 3) {
			window.open(
				"../../interview/InterviewTool/preview?template_id=" + template_id+
					"&tool_type=" + tool_type ,
				"_blank"
			);
		} else if (tool_type == 2) {
			window.open(
				"../../portfolio/PortfolioTools/exam_preview?template_id=" +
					template_id+
					"&tool_type="+tool_type ,
				"_blank"
			);
		} else if (tool_type == 6) {
			if (template_type == "3" && exam_type == "3") {
				window.open(
					"../../templates/Longanswer/preview?template_id=" +
						template_id +
						"&tool_type=6",
					"_blank"
				);
			} else {
				window.open(
					"../../observation/Observation/exam_preview?template_id=" +
						template_id,
					"_blank"
				);
			}
		} else if (tool_type == 7) {
			window.open(
				"../../tools/Thirdparty/exam_preview?template_id=" + template_id,
				"_blank"
			);
		} else {
			sweet_alert("<strong>อยู่ระหว่างดำเนินการ!!!</strong>");
		}
	}
}
