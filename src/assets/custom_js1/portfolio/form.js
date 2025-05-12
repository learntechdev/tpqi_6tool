$(document).ready(function () {
	$(".occ_level").select2();
	$(".template_type").select2();
	$(".exam_type").select2();
	$("#occ").hide();
	$("#operation").hide();
	get_dataforedit();
});

$("#occ_level").change(function () {
	chk_tp_exam_type();
});

$("#exam_type").change(function () {
	var occ_level_id = $("#occ_level").val();
	var template_type = $("#template_type").val();

	if (occ_level_id != 0) {
		if (template_type != 0) {
			check_select_tp();
		}
	} else {
		sweet_alert("<strong>กรุณาเลือกคุณวุฒิวิชาชีพ</strong>");
	}
});

$("#template_type").on("select2:select", function (e) {
	chk_tp_exam_type();
});

//เช็คประเภทแม่แบบ และประเภทการสร้างชุดข้อสอบ
function chk_tp_exam_type() {
	var occ_level_id = $("#occ_level").val();

	//alert(occ_level_id);
	if (occ_level_id != 0) {
		check_select_tp();
	} else {
		sweet_alert("<strong>กรุณาเลือกคุณวุฒิวิชาชีพ</strong>");
	}
}

// ตรวจสอบการเลือกข้อมูลเมื่อมีการเลือกประเภทการสร้างชุดข้อสอบใหม่
function check_select_tp() {
	var exam_type_id = $("#exam_type").val();
	var template_type = $("#template_type").val();
	var occ_level_id = $("#occ_level").val();

	if (exam_type_id == "1") {
		//มีหัวข้อหลักและหัวข้อย่อย สร้างตามคุณวุฒิ
		if (template_type == "2") {
			$("#occ").show();
			$("#operation").show();
			$("#uoc").hide();
			get_mainsubtopic_list(occ_level_id);
		}
	} else if (exam_type_id == "2") {
		//มีหัวข้อหลัก สร้างตาม uoc
		if (template_type == "1") {
			$("#uoc").show();
			$("#occ").hide();
			$("#operation").show();
			get_uoc_list(occ_level_id);
		}
	} else {
		//sweet_alert("<strong>ยังไม่มีเทมเพลตสำหรับสิ่งที่ท่านเลือก กรุณาติดต่อผู้ดูแลระบบ!!!</strong>");
		$("#uoc").hide();
		$("#occ").hide();
	}
}

function toggle_row(num) {
	$("#div_checklist" + num).show();

	if ($("#col" + num).is(":visible")) {
		$("#toggle_row" + num).html("+");
	} else {
		$("#toggle_row" + num).html("-");
	}
}

function get_uoc_list(occ_level_id) {
	$.ajax({
		url: "../../portfolio/PortfolioTools/fetch_uoc",
		method: "POST",
		data: {
			occ_level_id: occ_level_id,
			template_id: $("#template_id").val(),
		},
		success: function (data) {
			//console.log("uoc:" + data);
			$("#uoc").empty();
			$("#uoc").show();
			$("#uoc").html(data);
		},
	});
}

function get_mainsubtopic_list(occ_level_id) {
	// console.log($("#template_id").val())
	$.ajax({
		url: "../../portfolio/PortfolioTools/fetch_mainsubtopic",
		method: "POST",
		data: {
			occ_level_id: occ_level_id,
			template_id: $("#template_id").val(),
		},
		success: function (data) {
			// console.log("uoc:" +data["template"]);
			$("#occ").empty();
			$("#occ").show();
			$("#occ").html(data);
		},
	});
}

function get_dataforedit() {
	if ($("#action").val() == "update" || $("#action").val() == "copy") {
		$.ajax({
			url: "../../portfolio/PortfolioTools/get_template",
			method: "POST",
			data: {
				template_id: $("#template_id").val(),
			},
			dataType: "JSON",
			success: function (data) {
				var rs = JSON.parse(JSON.stringify(data));
				console.log(rs);
				fill_data(
					rs[0].occ_level_id,
					rs[0].template_type,
					rs[0].exam_type,
					rs[0].criteria_used_byexamier,
					rs[0].criteria_type_byexamier,
					rs[0].template_id
				);

				for (var i in CKEDITOR.instances) {
					CKEDITOR.instances[i].updateElement();
				}

				CKEDITOR.instances["desc_for_examier"].setData(rs[0].desc_for_examier);
				CKEDITOR.instances["desc_for_applicant"].setData(
					rs[0].des_for_applicant
				);

				var occ_level_id = rs[0].occ_level_id;
				//get_uoc_list(occ_level_id[0]);
				hide_showdata(rs[0].exam_type, rs[0].template_type);
			},
		});
	}
}

function hide_showdata(exam_type, template_type) {
	var occ_level_id = $("#occ_level").val();
	if (exam_type == "1" && template_type == "2") {
		$("#occ").show();
		$("#uoc").hide();
		$("#operation").show();
		//get_mainsubtopic_list(occ_level_id[0]);
		get_mainsubtopic_list(occ_level_id);
	} else if (exam_type == "2" && template_type == "1") {
		$("#occ").hide();
		$("#uoc").show();
		$("#operation").show();
		//get_uoc_list(occ_level_id[0]);
		get_uoc_list(occ_level_id);
	}
}

function fill_data(
	occ_level_id,
	template_type,
	exam_type,
	criteria_used_byexamier,
	criteria_type_byexamier,
	template_id
) {
	$("#occ_level").val(occ_level_id).trigger("change");
	$("#txt_occ_level").val(occ_level_id);
	$("#template_type").val(template_type).trigger("change");
	$("#exam_type").val(exam_type).trigger("change");
	$("#txt_exam_type").val(exam_type);
	$("#txt_template_type").val(template_type);
	$("#template_id").val(template_id);

	if (criteria_used_byexamier == 0) {
		$("#criteria_used_byexamier_0").prop("checked", true);
	} else {
		$("#criteria_used_byexamier_1").prop("checked", true);
		$("#criteria_type_byexamier")
			.val(criteria_type_byexamier)
			.trigger("change");
		$("#criteria_type_byexamier").prop("disabled", false);
	}

	disable_blueprint_element();
}

function disable_blueprint_element() {
	$("#occ_level").select2("enable", true);
	$("#exam_type").select2("enable", true);
	$("#template_type").select2("enable", true);
}

//บันทึกข้อมูล
$("#btn_save").click(function () {
	//console.log(JSON.stringify($("form").serializeJSON(), null, 2));
	var valid = validate(); //เช็คว่ากรอกข้อมูลครบหรือไม่
	if (valid) {
		save();
	}
});

/*function checkForm() {
	return $('input[type=text]').filter(function () {
	  return $(this).val().length === 0;
	}).length;
  }
  */

function validate() {
	var isValid = true;

	/*$('#form input[type="text"]').each(function(){
		if(!$(this).val()){
			isValid = false;
			sweet_alert("<strong>กรุณากรอกข้อมูลรายการประเมิน!!!</strong>");
		} else{
			isValid = true;
		}
	});*/

	for (var i in CKEDITOR.instances) {
		CKEDITOR.instances[i].updateElement();
	}

	var desc_examier = CKEDITOR.instances["desc_for_examier"].document
		.getBody()
		.getChild(0)
		.getText();
	var desc_applicant = CKEDITOR.instances["desc_for_applicant"].document
		.getBody()
		.getChild(0)
		.getText();

	if (desc_examier == "") {
		sweet_alert("<strong>กรุณากรอกข้อมูลสำหรับผู้ประเมิน!!!</strong>");
		isValid = false;
	}

	if (desc_applicant == "") {
		sweet_alert("<strong>กรุณากรอกข้อมูลสำหรับผู้เข้ารับประเมิน!!!</strong>");
		isValid = false;
	}

	var criteria_byexamier = $(
		"input[name='criteria_used_byexamier']:checked"
	).val();
	if (criteria_byexamier == "1") {
		if ($("#criteria_type_byexamier").val() == 0) {
			sweet_alert("<strong>กรุณาเลือกเกณฑ์การประเมิน!!!</strong>");
			isValid = false;
		}
	}

	if ($("#template_type").val() == "2") {
		if ($("#topic_1").val() == "") {
			sweet_alert(
				"<strong>กรุณาระบุรายการประเมินที่เป็นหัวข้อหลักอย่างน้อย 1 รายการ!!!</strong>"
			);
			isValid = false;
		}

		if ($("#sub_topic_1").val() == "") {
			sweet_alert(
				"<strong>กรุณาระบุรายการประเมินของหัวข้อย่อยอย่างน้อย 1 รายการ!!!</strong>"
			);
			isValid = false;
		}
	}

	return isValid;
}

$("#files").change(function () {
	if ($("#files").val() != "") {
		$.each($("#files").prop("files"), function (k, v) {
			var filename = v["name"];
			var ext = filename.split(".").pop().toLowerCase();
			if ($.inArray(ext, ["pdf", "doc", "docx"]) == -1) {
				sweet_alert(
					"<strong>กรุณาเลือกประเภทไฟล์เป็น pdf และ doc เท่านั้น!!!</strong>"
				);

				$("#files").val("");

				return false;
			}
		});
	}
});

//บันทึกข้อมูล
function save() {
	for (var i in CKEDITOR.instances) {
		CKEDITOR.instances[i].updateElement();
	}

	$.ajax({
		method: "POST",
		url: "../../portfolio/PortfolioTools/insert",
		data: {
			dt: JSON.stringify($("form").serializeJSON()),
			tool_type: "2",
		},
		success: function (response) {
			uploadFiles(response);
		},
	});
}

function uploadFiles(template_id) {
	var form_data = new FormData();
	var totalfiles = document.getElementById("files").files.length;

	if (totalfiles != 0) {
		for (var index = 0; index < totalfiles; index++) {
			form_data.append(
				"files[]",
				document.getElementById("files").files[index]
			);
		}

		form_data.append("template_id", template_id);

		$.ajax({
			url: "../../shared/Shared/upload_docs_forexam",
			method: "POST",
			data: form_data,
			dataType: "json",
			contentType: false,
			processData: false,
			success: function (response) {
				success_alert("<strong>บันทึกข้อมูลเรียบร้อยแล้ว</strong>");
				$("#template_id").val(response);
				$("#action").val() == "copy"
					? $("#copy_tp_id").val(response)
					: $("#copy_tp_id").val("");
			},
		});
	} else {
		success_alert("<strong>บันทึกข้อมูลเรียบร้อยแล้ว</strong>");
		$("#template_id").val(template_id);
		$("#action").val() == "copy"
			? $("#copy_tp_id").val(template_id)
			: $("#copy_tp_id").val("");
	}
}

function valid_template() {
	var valid = false;
	if ($("#template_id").val() == "") {
		valid = false;
	} else {
		valid = true;
	}
	return valid;
}

$("#btn_preview").click(function () {
	if (valid_template()) {
		var template_id = $("#template_id").val();
		window.open(
			"../../portfolio/PortfolioTools/exam_preview?template_id=" + template_id,
			"_blank"
		);
	} else {
		sweet_alert("<strong>กรุณาบันทึกข้อสอบ!!! ก่อนส่งข้อสอบไปตรวจ</strong>");
	}
});

function valid_uoc_subtopic_list() {
	let formData = $("form").serializeJSON();

	console.log($("form").serializeJSON());

	let valid_uocchklist = false;
	if ($("#txt_template_type").val() == "1") {
		for (key in formData.uocchklist) {
			if (
				formData.uocchklist.hasOwnProperty(key) && // These checks are
				/^0$|^[1-9]\d*$/.test(key) && // explained
				key <= 4294967294 // below
			) {
				//	console.log(formData.uocchklist[key][1].topic);
				if (formData.uocchklist[key][1].topic != "") {
					valid_uocchklist = true;
				}
			}
		}
	} else {
		for (key in formData.list) {
			if (
				formData.list.hasOwnProperty(key) && // These checks are
				/^0$|^[1-9]\d*$/.test(key) && // explained
				key <= 4294967294 // below
			) {
				if (formData.list[key].detail[1].subtopic != "") {
					valid_uocchklist = true;
				}
			}
		}
	}

	return valid_uocchklist;
}

$("#btn_sendapprove").click(function () {
	if (valid_template()) {
		//if (valid_uoc_subtopic_list()) {
		Swal.fire({
			title: "ยืนยัน!!!",
			text: "คุณต้องการส่งข้อสอบไปตรวจใช่หรือไม่?",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			confirmButtonText: "ใช่",
			cancelButtonText: "ยกเลิก",
		}).then((result) => {
			if (result.isConfirmed) {
				sendtemplate_approve();
			}
		});
		/*} else {
			sweet_alert("<strong>กรุณากรอกข้อคำถาม!!! ก่อนส่งข้อสอบไปตรวจ </strong>");
		}*/
	} else {
		sweet_alert("<strong>กรุณาบันทึกข้อสอบ!!! ก่อนส่งข้อสอบไปตรวจ</strong>");
	}
});

function sendtemplate_approve() {
	$.ajax({
		method: "POST",
		url: "../../portfolio/PortfolioTools/sendtemplate_approve",
		data: {
			template_id: $("#template_id").val(),
		},
		dataType: "JSON",
		success: function (response) {
			if (response == 1) {
				success_alert("<strong>ส่งข้อสอบไปตรวจเรียบร้อยแล้ว</strong>");
				window.location.replace(
					"../../exam_library/Examlibrary/index?tool_type=2&contract_no=" +
						$("#contract_no").val()
				);
			}
		},
	});
}
