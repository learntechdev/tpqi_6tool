$(document).ready(function () {
	$("#full_score, #pass_score, #percent_score").prop("readonly", true);
	$("#full_score, #pass_score, #percent_score").val("");
});


$('#modal_approvecriteria').on('hidden.bs.modal', function () {
	$("#percent_score").val('');
});

$("input[type=radio][name=define_criteria_status]").change(function () {
	if (this.value == "1") {
		$("#full_score, #pass_score, #percent_score").prop("readonly", true);
		$("#full_score, #pass_score, #percent_score").val("");
	} else {
		$("#full_score, #pass_score, #percent_score").prop("readonly", false);
	}
});

function validate() {
	var isValid = true;
	var status = $("input[name='define_criteria_status']:checked").val();

	if (status == "2") {
		if ($("#full_score").val() == "") {
			sweet_alert("<strong>กรุณาระบุคะแนนเต็ม!!!</strong>");
			isValid = false;
		}

		if ($("#pass_score").val() == "") {
			sweet_alert("<strong>กรุณาระบุคะแนนผ่าน!!!</strong>");
			isValid = false;
		}

		if ($("#percent_score").val() == "") {
			sweet_alert("<strong>กรุณาระบุเปอร์เซ็นต์ผ่าน!!!</strong>");
			$("#percent_score").focus();
			isValid = false;
		}
	}
	return isValid;
}

$("#btn_define_criteria").click(function () {
	var valid = validate();
	if (valid) {
		//console.log("data:" + JSON.stringify($("form").serializeJSON()));
		var action = $("#txt_action").val() == "" ? "create" : "update";
		$.ajax({
			method: "POST",
			url: "../Approve/insert_criteriaforexam",
			data: {
				dt: JSON.stringify($("form").serializeJSON()),
				action: action,
			},
			success: function (res) {
				//console.log("res:" + res);
				if (res == 1) {
					$("#modal_approvecriteria").modal("hide");
					success_alert("<strong>บันทึกข้อมูลเรียบร้อยแล้ว</strong>");
					search(1);
				}
			},
		});
	}
});
