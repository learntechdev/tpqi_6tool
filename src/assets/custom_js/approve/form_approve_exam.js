$(document).ready(function () {
	if (this.value == "8") {
		$("#reason_disapproval").prop("readonly", false);
	} else {
		$("#reason_disapproval").prop("readonly", true);
		$("#reason_disapproval").val("");
	}
});

$("input[type=radio][name=approve_status]").change(function () {
	if (this.value == "8") {
		$("#reason_disapproval").prop("readonly", false);
	} else {
		$("#reason_disapproval").prop("readonly", true);
		$("#reason_disapproval").val("");
	}
});

$("#btn_priview_exam").click(function () {
	var template_id = $("#txt_template_id").val();
	var tool_type = $("#txt_tool_type").val();
	var template_type = $("#txt_template_type").val();
	var exam_type = $("#txt_exam_type").val();

	if (template_id == 0 || template_id == "") {
		sweet_alert("<strong>ไม่มีข้อมูลเทมเพลต!!!</strong>");
	} else {
		if (tool_type == 4) {
			window.open(
				"../../simulation/SimulationTools/exam_preview?template_id=" +
					template_id,

				"_blank"
			);
		} else if (tool_type == 5) {
			window.open(
				"../../demonstration/DemonstrationTools/exam_preview?template_id=" +
					template_id,

				"_blank"
			);
		} else if (tool_type == 3) {
			window.open(
				"../../interview/InterviewTool/preview?template_id=" + template_id,

				"_blank"
			);
		} else if (tool_type == 2) {
			window.open(
				"../../portfolio/PortfolioTools/exam_preview?template_id=" +
					template_id,

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
});

function validate() {
	var isValid = true;
	var status = $("input[name='approve_status']:checked").val();
	if (status == "8") {
		if ($("#reason_disapproval").val() == "") {
			sweet_alert(
				"<strong>กรุณาระบุเหตุผล ที่ไม่อนุมัติเกณฑ์การประเมิน!!!</strong>"
			);
			isValid = false;
		}
	}
	return isValid;
}

$("#btn_approve_exam").click(function () {
	var valid = validate();

	if (valid) {
		$.ajax({
			method: "POST",
			url: "../Approve/approve_exam",
			data: {
				txt_tool_type: $("#txt_tool_type").val(),
				exam_schedule_id: $("#exam_schedule_id").val(),
				template_id: $("#txt_template_id").val(),
				status: $("input[name='approve_status']:checked").val(),
				reason_disapproval: $("#reason_disapproval").val(),
			},

			success: function (res) {
				if (res == 1) {
					$("#modal_approveexam").modal("hide");
					success_alert("<strong>บันทึกข้อมูลเรียบร้อยแล้ว</strong>");
					search(1);
				}
			},
		});
	}
});
