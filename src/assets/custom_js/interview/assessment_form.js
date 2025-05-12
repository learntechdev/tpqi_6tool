$(document).ready(function () {
	$("#sound_upload").change(function () {
		if ($(this).get(0).files[0] != undefined) {
			var file_name = $(this).get(0).files[0].name; //ชื่อไฟล์

			var size = $(this).get(0).files[0].size; // ขนาดไฟล์

			var max = 50000000; //ขนาดไฟล์กำหนดสูงสุด

			var ext = file_name.split(".").pop(); //นามสกุลไฟล์

			if (size < max) {
				if (
					ext != "mp3" &&
					ext != "aac" &&
					ext != "wav" &&
					ext != "cda" &&
					ext != "wmv" &&
					ext != "m4a" &&
					ext != "ogg"
				) {
					sweet_alert("<strong>นามสกุลไฟล์ไม่ถูกต้อง</strong>");

					$(this).val("");
				}
			} else {
				sweet_alert("<strong>ขนาดไฟล์เกิน 50 mb</strong>");

				$(this).val("");
			}
		}
	});
});

function show_dialog_recorder(template_detail_id, uoc_code, eoc_code, app_id) {
	//$(".modal-body #span_msg").text(pc_detail);
	//$(".modal-body #txt_pc_code").val(pc_code);
	$(".modal-body #txt_app_id").val(app_id);
	$(".modal-body #template_detail_id").val(template_detail_id);
	$(".modal-body #txt_uoc_code").val(uoc_code);
	$("#modal_recorder").modal("show");
	$("#recordingsList").empty();
}

function show_dialog_upload(template_detail_id, uoc_code, eoc_code, app_id) {
	//$(".modal-body #span_msg").text(pc_detail);
	//$(".modal-body #txt_pc_code").val(pc_code);
	$(".modal-body #txt_app_id").val(app_id);
	$(".modal-body #template_detail_id").val(template_detail_id);
	$(".modal-body #txt_uoc_code").val(uoc_code);
	$("#modal_upload").modal("show");
}

$("#saveSound").on("click", function () {
	file = document.getElementById("sound_upload").files;
	var template_detail_id = $("#template_detail_id").val();
	var app_id = $("#txt_app_id").val();
	var exam_schedule_id = $("#exam_schedule_id").val();
	var filename =
		formatDate(new Date().toISOString()) + "_" + template_detail_id;
	blob = file[0];
	var xhr = new XMLHttpRequest();
	xhr.onload = function (e) {
		if (this.readyState === 4) {
			show_clip(e.target.responseText, template_detail_id);
			$("#modal_upload").modal("hide");
			$("#sound_upload").val("");
		} else {
			sweet_alert("<strong>ไม่สามารถบันทึกได้</strong>");
		}
	};
	var fd = new FormData();
	fd.append("audio_data", blob, filename);
	fd.append("app_id", app_id);
	fd.append("template_detail_id", template_detail_id);
	fd.append("exam_schedule_id", exam_schedule_id);
	fd.append("tool_type", "3");
	xhr.open(
		"POST",
		"../../upload/UploadFiles/uploadfile?app_id='" + app_id + "'&tool_type=3",
		true
	);
	xhr.send(fd);
});

function show_clip(file, template_detail_id) {
	console.log(file);
	console.log(template_detail_id);

	if (file != "") {
		$("#sound_play" + template_detail_id).remove();
	}

	var base_url = $("#base_url").val();
	var div_sound = document.getElementById("div_sound" + template_detail_id);
	var sound_play = document.getElementById("sound_play" + template_detail_id);
	var sound_play = document.createElement("audio");

	sound_play.classList.add("audio");
	sound_play.classList.add("audio-play" + template_detail_id);

	if (sound_play.canPlayType("audio/wav")) {
		sound_play.setAttribute("src", base_url + file);
	}

	sound_play.setAttribute("controls", "controls");

	setTimeout(() => {
		div_sound.appendChild(sound_play);
	}, 500);
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

$("#btn_save").click(function () {
	var valid = checkForm(); //เช็คว่ากรอกข้อมูลครบหรือไม่
	var validFile = checkFile(); //เช็คว่าอัพโหลดไฟล์ครบหรือไม่
	// console.log(validFile)
	//alert(valid);
	if (valid == true) {
		if (validFile == true) {
			save();
		} else {
			Swal.fire({
				title: "ยืนยัน!!!",
				text: "คุณยังอัพโหลดไฟล์ไม่ครบทุกรายการ คุณต้องการบันทึกใช่หรือไม่?",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				confirmButtonText: "ใช่",
				cancelButtonText: "ยกเลิก",
			}).then((result) => {
				if (result.isConfirmed) {
					save();
				}
			});
		}
	} else {
		sweet_alert("<strong>กรุณากรอกข้อมูลให้ครบทุกรายการ!!!</strong>");
	}
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

function checkFile() {
	var chk = 0;
	$(".audio").each(function () {
		chk++;
	});

	if ($("#uoc_code_count").val() != chk) {
		return false;
	} else {
		return true;
	}
}

function checkForm() {
	var valid = true;
	if ($("#criteria_used_byexamier").val() == "0") {
		var exam_result = $("input[name=exam_result]").is(":checked");
		if (exam_result == true) {
			valid = true;
		} else {
			valid = false;
		}
	} else {
		$(".score").each(function () {
			if ($(this).val()) {
				valid = true;
			} else {
				valid = false;
			}
		});
	}

	return valid;
}

$('input[type="number"]').keyup(function (e) {
	if (/\D/g.test(this.value)) {
		this.value = this.value.replace(/\D/g, "");
	}
});

function save() {
	Swal.fire({
		title: "ยืนยัน!!!",
		text: "คุณต้องการส่งผลสอบใช่หรือไม่?",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		confirmButtonText: "ใช่",
		cancelButtonText: "ยกเลิก",
	}).then((result) => {
		if (result.isConfirmed) {
			for (var i in CKEDITOR.instances) {
				CKEDITOR.instances[i].updateElement();
			}

			//console.log("form:" + JSON.stringify($("form").serializeJSON()));

			$.ajax({
				method: "POST",
				url: "../../assessment/AssessmentResult/insert_ass_longanswer",
				data: {
					dt: JSON.stringify($("form").serializeJSON()),
					exam_schedule_id: $("#exam_schedule_id").val(),
					app_id: $("#app_id").val(),
					tool_type: "3",
				},
				success: function (response) {
					//console.log(response);
					var rs = JSON.parse(response);
					//alert(rs.status);
					if (rs.status == 1) {
						success_alert("<strong>บันทึกข้อมูลเรียบร้อยแล้ว!!!</strong>");
						goto_applicant_assessment();
					} else {
						sweet_alert("<strong>ไม่สามารถบันทึกข้อมูลได้!!!</strong>");
					}
				},
			});
		}
	});
}

/*$("#btn_confirm_assessment").click(function () {

  Swal.fire({

	title: 'ยืนยัน!!!',

	text: 'คุณต้องการส่งผลสอบใช่หรือไม่?',

	showCancelButton: true,

	confirmButtonColor: '#3085d6',

	confirmButtonText: 'ใช่',

	cancelButtonText: 'ยกเลิก',

  }).then((result) => {

	if (result.isConfirmed) {

	  confirm_applicant_assessment();

	}

  });

});*/

/*function confirm_applicant_assessment() {

  $.ajax({

	method: "POST",

	url: "../../assessment/Assessment/confirm_applicant_assessment",

	data: {

	  exam_schedule_id: $("#exam_schedule_id").val(),

	  app_id: $("#app_id").val()

	},

	dataType: "JSON",

	success: function (response) {

	  if (response == 1) {

		success_alert("<strong>ยืนยันการส่งผลสอบเรียบร้อยแล้ว</strong>")

		goto_applicant_assessment();

	  }

	},

  });

}*/

function goto_applicant_assessment() {
	//รายชื่อผู้เข้ารับการประเมิน
	$.redirect("../../assessment/Assessment/applicant_assessment", {
		exam_schedule_id: $("#exam_schedule_id").val(),
		occ_level_name: $("#occ_level_name").val(),
		tool_type: "3",
		template_id: $("#template_id").val(),
		occ_level_id: $("#occ_level_id").val(),
	});
}
