$(document).ready(function () {
	calculateScore();

	$(".add_more").click(function (e) {
		e.preventDefault();
		var num_input = parseInt($("#num_input").val());
		$(this).before(
			"<div class='row row-form' id='row" +
				num_input +
				"'> " +
				"   <div class='col-md-3'> " +
				"       <input type='text' class='form-control name-file' id='' name='' value='' placeholder='ชื่อไฟล์'>" +
				"   </div>" +
				"   <div class='col-md-3'> " +
				"       <input type='file' class='form-control-file file-data' id='file" +
				num_input +
				"' name='' >" +
				"   </div>" +
				"   <div class='col-md-6'> " +
				"       <a herf='#' class='btn btn-danger' " +
				"           onclick='del_element(" +
				num_input +
				")'><i class='fa fa-trash'style='color: #ffffff'></i></a>" +
				"   </div>" +
				"</div>"
		);
		$("#num_input").val(num_input + 1);
	});
});

function del_element(num_input) {
	$("#row" + num_input).remove();
}

$("#btn_save").click(function () {
	for (var i in CKEDITOR.instances) {
		CKEDITOR.instances[i].updateElement();
	}

	var chk_input_score = true;
	var chk_file_data = true;
	var chk_name_file = true;

	$(".score").each(function () {
		if ($(this).val() == "") {
			chk_input_score = false;
		}
	});

	$(".name-file").each(function () {
		if ($(this).val() == "") {
			chk_name_file = false;
		}
	});

	$(".file-data").each(function () {
		var uploadFile = document.getElementById($(this).attr("id")).files;
		if (uploadFile.length == 0) {
			chk_file_data = false;
		}
	});

	if (chk_input_score) {
		if (!chk_file_data) {
			sweet_alert("<strong>กรุณาแนบเอกสาร!!!</strong>");
		} else if (!chk_name_file) {
			sweet_alert("<strong>กรุณากรอกชื่อเอกสารที่แนบ!!!</strong>");
		} else {
			confirmAssessment();
		}
	} else {
		Swal.fire({
			title: "ยืนยัน!!!",
			text:
				"คุณยังกรอกคะนนไม่ครบทุกข้อ ข้อที่ไม่ได้กรอกคะแนนจะเป็น 0 ต้องการบันทึกข้อมูลหรือไม่?",
			showCancelButton: true,
			confirmButtonColor: "red",
			confirmButtonText: "ใช่",
			cancelButtonText: "ยกเลิก",
		}).then((result) => {
			if (result.isConfirmed) {
				if (!chk_file_data) {
					sweet_alert("<strong>กรุณาแนบเอกสาร!!!</strong>");
				} else if (!chk_name_file) {
					sweet_alert("<strong>กรุณากรอกชื่อเอกสารที่แนบ!!!</strong>");
				} else {
					confirmAssessment();
				}
			}
		});
	}
});

function confirmAssessment() {
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
		}
	});
}

function save_assessment() {
	//console.log(JSON.stringify($("form").serializeJSON(), null, 2))

	var nameFile = [];
	var fileData = [];

	$(".name-file").each(function () {
		nameFile.push($(this).val());
	});

	$(".file-data").each(function () {
		var uploadFile = document.getElementById($(this).attr("id")).files;
		fileData.push(uploadFile);
	});
	app_id = $("#app_id").val();

	$.ajax({
		method: "POST",
		url: "../../tools/Thirdparty/insert_assessment_applicant",
		data: {
			dt: JSON.stringify($("form").serializeJSON()),
			exam_schedule_id: $("#exam_schedule_id").val(),
			app_id: app_id,
			action: "create",
			tool_type: "7",
		},
		dataType: "JSON",
		success: function (response) {
			if (response.status == "1") {
				uploadFileAssessment(
					fileData,
					nameFile,
					app_id,
					response.assessment_id
				);

				$("#btn_save").attr("disabled", true);
				//success_alert("<strong>บันทึกข้อมูลเรียบร้อยแล้ว!!!</strong>");
				confirm_applicant_assessment();
			} else {
				sweet_alert("<strong>ไม่สามารถบันทึกข้อมูลได้!!!</strong>");
			}
		},
	});
}

function uploadFileAssessment(fileData, nameFile, app_id, assessment_id) {
	name_ = [];
	for (u = 0; u < fileData.length; u++) {
		file = fileData[u];

		for (i = 0; i < file.length; i++) {
			var date_now = Date.now();

			if (file[i] != null) {
				myfile = file[i].name;
				var ext = myfile.split(".").pop(); //ดึงนามสกุลไฟล์

				var url = "../../tools/Thirdparty/saveFileAssessment";
				var xhr = new XMLHttpRequest();
				var fd = new FormData();

				xhr.open("POST", url, true);
				xhr.onreadystatechange = function () {
					if (xhr.readyState == 4 && xhr.status == 200) {
					}
				};

				fd.append("upload_file", file[i]);
				fd.append(
					"name_flie",
					app_id + "_" + date_now + "_" + (u + 1) + "." + ext
				); //ชื่อไฟล์ใหม่+นามสกุล
				name_.push(app_id + "_" + date_now + "_" + (u + 1) + "." + ext);
				fd.append("app_id", app_id); //ชื่อโฟลเดอร์ที่บันทึกไฟล์
				xhr.send(fd);
			}
		}
	}

	var detailFile = [];
	for (var i = 0; i < nameFile.length; i++) {
		detailFile.push({
			name: nameFile[i],
			file: name_[i],
		});
	}
	saveDetailFile(detailFile, assessment_id);
}

function saveDetailFile(data, assessment_id) {
	$.ajax({
		method: "POST",
		url: "../../tools/Thirdparty/saveDetailFile",
		data: {
			data: data,
			assessment_id: assessment_id,
		},
		dataType: "JSON",
		success: function (response) {
			if (response.status == "1") {
				success_alert("<strong>บันทึกข้อมูลเรียบร้อยแล้ว!!!</strong>");
			} else {
				sweet_alert("<strong>ไม่สามารถบันทึกข้อมูลได้!!!</strong>");
			}
		},
	});
}

/*

$("#btn_confirm_assessment").click(function () {
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
});
*/
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
		tool_type: "7",
		template_id: $("#template_id").val(),
		occ_level_id: $("#occ_level_id").val(),
	});
}

/*
function calculateScore() {
  var totalScore = 0;
  $('.score').each(function () {

	console.log($(this).val())
	if ($(this).val() == '') {
	  val_ = 0;
	} else {
	  val_ = $(this).val()
	}
	totalScore += parseInt(val_);
  });
  $('#total_score').val(totalScore);
}*/
function calculateScore() {
	var totalScore = 0;
	var sum_max_score = 0;
	var exam_percent_score = 0.0;
	var max_score = $("#criteria_max_score").val();
	var percent_passexam = $("#percent_passexam").val();
	var exam_result = "";

	$(".score").each(function () {
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
