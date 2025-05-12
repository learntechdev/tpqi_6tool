$("#btn_save").click(function () {
	for (var i in CKEDITOR.instances) {
		CKEDITOR.instances[i].updateElement();
	}

	//var data = JSON.stringify($("form").serializeJSON(), null, 2);
	//console.log("data:" + JSON.stringify($("form").serializeJSON(), null, 2));

	var chk_input_score = true;

	$(".score").each(function () {
		if ($(this).val() == "") {
			chk_input_score = false;
		}
	});

	if (chk_input_score) {
		save_assessment();
	} else {
		Swal.fire({
			title: "ยืนยัน!!!",
			text: "คุณยังกรอกคะนนไม่ครบทุกข้อ ข้อที่ไม่ได้กรอกคะแนนจะเป็น 0 ต้องการบันทึกข้อมูลหรือไม่?",
			showCancelButton: true,
			confirmButtonColor: "red",
			confirmButtonText: "ใช่",
			cancelButtonText: "ยกเลิก",
		}).then((result) => {
			if (result.isConfirmed) {
				save_assessment();
			}
		});
	}
});

function save_assessment() {
	//console.log("form:" + JSON.stringify($("form").serializeJSON()));
	//alert("555");
	$.ajax({
		method: "POST",
		url: "../../portfolio/PortfolioTools/insert_assessment_applicant",
		data: {
			dt: JSON.stringify($("form").serializeJSON()),
			exam_schedule_id: $("#exam_schedule_id").val(),
			app_id: $("#app_id").val(),
			tool_type: "2",
		},
		dataType: "JSON",
		success: function (response) {
			//console.log(response);
			if (response.status == "1") {
				$("#btn_save").attr("disabled", true);
				success_alert("<strong>บันทึกข้อมูลเรียบร้อยแล้ว!!!</strong>");
				goto_applicant_assessment();
			} else {
				sweet_alert("<strong>ไม่สามารถบันทึกข้อมูลได้!!!</strong>");
			}
		},
	});
}

$("#btn_confirm_assessment").click(function () {
	Swal.fire({
		title: "ยืนยัน!!!",
		text: "คุณต้องการส่งผลสอบใช่หรือไม่?",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		confirmButtonText: "ใช่",
		cancelButtonText: "ยกเลิก",
	}).then((result) => {
		if (result.isConfirmed) {
			save_assessment();
			//confirm_applicant_assessment();
		}
	});
});

function confirm_applicant_assessment() {
	$.ajax({
		method: "POST",
		url: "../../assessment/Assessment/confirm_applicant_assessment",
		data: {
			exam_schedule_id: $("#exam_schedule_id").val(),
			app_id: $("#app_id").val(),
		},
		dataType: "JSON",
		success: function (response) {
			if (response == 1) {
				success_alert("<strong>ยืนยันการส่งผลสอบเรียบร้อยแล้ว</strong>");
				goto_applicant_assessment();
			}
		},
	});
}

function goto_applicant_assessment() {
	$.redirect("../../assessment/Assessment/applicant_assessment", {
		exam_schedule_id: $("#exam_schedule_id").val(),
		occ_level_name: $("#occ_level_name").val(),
		tool_type: "2",
		template_id: $("#template_id").val(),
		occ_level_id: $("#occ_level_id").val(),
	});
}

function calculateScore() {
	var totalScore = 0;
	var sum_max_score = 0;
	var exam_percent_score = 0.0;
	var max_score = $("#criteria_max_score").val();
	var percent_passexam = $("#percent_passexam").val();
	var exam_result = "";

	$(".score").each(function () {
		//console.log($(this).val())
		if ($(this).val() == "") {
			val_ = 0;
		} else {
			val_ = $(this).val();
		}
		totalScore += parseInt(val_);
		sum_max_score += parseInt(max_score);
	});

	if (totalScore != 0) {
		exam_percent_score = ((totalScore * 100) / sum_max_score).toFixed(2);
		if (parseFloat(exam_percent_score) >= parseFloat(percent_passexam)) {
			exam_result = "ผ่าน";
		} else {
			exam_result = "ไม่ผ่าน";
		}
	} else {
		exam_result = "ไม่ผ่าน";
	}

	//console.log(exam_result);
	$("#total_score").val(totalScore);
	$("#full_score").val(sum_max_score);
	$("#exam_percent_score").val(exam_percent_score);
	$("#exam_result").val(exam_result);
}

$("input.score").on("change keyup", function () {
	calculateScore();
	chkInputMaxScore();
});

function chkInputMaxScore() {
	$(".score").each(function () {
		if ($(this).val() > $("#criteria_max_score").val()) {
			sweet_alert(
				"<strong>คุณได้กรอกคะแนน เกินกว่าคะแนนสูงสุดของเกณฑ์การประเมิน!!!</strong>"
			);
			$(this).val("");
		}
	});
}
