$(document).ready(function () {
	$('#reason_disapproval').prop('readonly', true);
});

$("#btn_ap_priview_exam").click(function () {
	var template_id = $("#txt_template_id").val();
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

$('input[type=radio][name=approve_status]').change(function () {
	if (this.value == '7') {
		$('#reason_disapproval').prop('readonly', false);
	} else {
		$('#reason_disapproval').prop('readonly', true);
	}
});

function validate() {
	var isValid = true;

	var criteria_byexamier = $("input[name='approve_status']:checked").val();

	if (criteria_byexamier == "7") {
		if ($("#reason_disapproval").val() == "") {
			sweet_alert("<strong>กรุณาระบุเหตุผล ที่ไม่อนุมัติเกณฑ์การสอบประเมิน!!!</strong>");
			isValid = false;
		}
	}

	return isValid;
}

$("#btn_approve_exam_criteria").click(function () {
	var valid = validate();//เช็คว่ากรอกข้อมูลครบหรือไม่
	if (valid) {
		$.ajax({
			method: "POST",
			url: "../Exam/approve_exam_criteria",
			data: {
				exam_schedule_id: $("#exam_schedule_id").val(),
				approve_status: $("input[name='approve_status']:checked").val(),
				reason_disapproval: $("#reason_disapproval").val()
			},
			success: function (response) {
				if (response == 1) {
					$("#modal_criteriaforexam").modal("hide");
					$("#modal_alert").modal("show");
					$(".modal-body #span_msg").text(
						"บันทึกข้อมูลเรียบร้อยแล้ว"
					);
					$("#btn_ok").click(function () {
						$("#modal_alert").modal("hide");
						search(1);
					});
				}
			},
		});
	}
});

$("#btn_cancel").click(function () {
	$("#modal_approvecriteriaforexam").modal("hide");
});



