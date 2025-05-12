$(document).ready(function () {
	$(".occ_level").select2();
	$(".exam_type").select2();
	$(".template_type").select2();
	$("#operation").hide();

	get_dataforedit();
});

$("#occ_level_id").change(function () {
	chk_tp_exam_type();
});

$("#exam_type").change(function () {
	var occ_level_id = $("#occ_level_id").val();
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
	var occ_level_id = $("#occ_level_id").val();
	occ_level_id = occ_level_id;

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
	var occ_level_id = $("#occ_level_id").val();

	if (exam_type_id == "1") {
		//มีหัวข้อหลักและหัวข้อย่อย สร้างตามคุณวุฒิ
		if (template_type == "2") {
			// $("#div_occ").show();
			$("#operation").show();
			$("#uoc").hide();
			$("#eoc").hide();
			//get_mainsubtopic_list(occ_level_id[0]);
		}
	} else if (exam_type_id == "2") {
		//มีหัวข้อหลัก สร้างตาม uoc
		if (template_type == "1") {
			$("#uoc").show();
			$("#eoc").hide();
			// $("#div_occ").hide();
			$("#operation").show();
			get_uoc_list(occ_level_id);
		}
	} else if (exam_type_id == "3") {
		get_uoc_eoc(occ_level_id);
		$("#eoc").show();
		$("#operation").show();
		$("#uoc").hide();
	} else {
		//sweet_alert("<strong>ยังไม่มีเทมเพลตสำหรับสิ่งที่ท่านเลือก กรุณาติดต่อผู้ดูแลระบบ!!!</strong>");
		$("#uoc").hide();
		// $("#div_occ").hide();
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

//ดึงข้อมูล uoc
function get_uoc_list(occ_level_id) {
	$.ajax({
		url: "../../observation/Observation/fetch_uoc",
		method: "POST",
		data: {
			occ_level_id: occ_level_id,
			template_id: $("#template_id").val(),
		},
		success: function (data) {
			$("#uoc").empty();
			$("#uoc").show();
			$("#uoc").html(data);
		},
	});
}

function get_uoc_eoc(occ_level_id) {
	//alert(occ_level_id);
	$.ajax({
		url: "../../shared/Shared/get_eoc",
		method: "POST",
		data: {
			asm_tool: "6",
			occ_level_id: occ_level_id,
			template_id: $("#template_id").val(),
		},
		success: function (data) {
			//alert(data);
			//console.log("uoc:" + data);
			$("#eoc").empty();
			$("#eoc").show();
			$("#eoc").html(data);
		},
	});
}

function get_dataforedit() {
	if ($("#action").val() == "update" || $("#action").val() == "copy") {
		$.ajax({
			url: "../../observation/Observation/get_template",
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
					rs[0].criteria_type_byexamier
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

function fill_data(
	occ_level_id,
	template_type,
	exam_type,
	criteria_used_byexamier,
	criteria_type_byexamier
) {
	$("#occ_level_id").val(occ_level_id).trigger("change");
	$("#template_type").val(template_type).trigger("change");
	$("#exam_type").val(exam_type).trigger("change");
	$("#txt_exam_type").val(exam_type);
	$("#txt_template_type").val(template_type);
	$("#txt_occ_level").val(occ_level_id);

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
	$("#occ_level_id").select2("enable", true);
	$("#exam_type").select2("enable", true);
	$("#template_type").select2("enable", true);
}

function hide_showdata(exam_type, template_type) {
	var occ_level_id = $("#occ_level_id").val();
	if (exam_type == "1" && template_type == "2") {
		$("#div_occ").show();
		$("#div_checklist_single").hide();
		$("#operation").show();
		get_mainsubtopic_list(occ_level_id);
	} else if (exam_type == "2" && template_type == "1") {
		$("#div_occ").hide();
		$("#div_checklist_single").show();
		$("#operation").show();
		get_uoc_list(occ_level_id);
	} else if (exam_type == "3" && template_type == "3") {
		$("#eoc").show();
		$("#operation").show();
		$("#div_occ").hide();
		$("#div_checklist_single").hide();
		get_uoc_eoc(occ_level_id);
	}
}

//เช็คว่ามีเทมเพลตหรือไม่
function valid_template() {
	var valid = false;

	if ($("#action").val() == "copy" && $("#template_id").val() != "") {
		valid = true;
	} else {
		if ($("#template_id").val() == "") {
			valid = false;
		} else {
			valid = true;
		}
	}
	return valid;
}

function validate() {
	var isValid = true;

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

	return isValid;
}

$("#files").change(function () {
	if ($("#files").val() != "") {
		$.each($("#files").prop("files"), function (k, v) {
			var filename = v["name"];
			var ext = filename.split(".").pop().toLowerCase();
			if ($.inArray(ext, ["pdf", "doc", "docx", "mp4", "zip"]) == -1) {
				sweet_alert(
					"<strong>กรุณาเลือกประเภทไฟล์เป็น pdf mp4 zip และ doc เท่านั้น!!!</strong>"
				);

				$("#files").val("");

				return false;
			}
		});
	}
});

$("#btn_save").click(function () {
	// console.log(JSON.stringify($("form").serializeJSON(), null, 2))
	var valid = validate(); //เช็คว่ากรอกข้อมูลครบหรือไม่
	if (valid) {
		save();
	}
});

function save() {
	for (var i in CKEDITOR.instances) {
		CKEDITOR.instances[i].updateElement();
	}

	$url = "";
	if ($("#exam_type").val() == "3") {
		$url = "../../templates/Longanswer/insert";
	} else {
		$url = "../../observation/Observation/insert";
	}

	$.ajax({
		method: "POST",
		url: $url,
		data: {
			dt: JSON.stringify($("form").serializeJSON()),
			tool_type: "6",
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

$("#btn_preview").click(function () {
	if (valid_template()) {
		var template_id = $("#template_id").val();
		if ($("#template_type").val() == "3" && $("#exam_type").val() == "3") {
			window.open(
				"../../templates/Longanswer/preview?template_id=" +
					template_id +
					"&tool_type=6",
				"_blank"
			);
		} else {
			window.open(
				"../../observation/Observation/exam_preview?template_id=" + template_id,
				"_blank"
			);
		}
	} else {
		sweet_alert("<strong>กรุณาบันทึกข้อสอบ!!! ก่อนส่งข้อสอบไปตรวจ</strong>");
	}
});

$("#btn_sendapprove").click(function () {
	if (valid_template()) {
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
	} else {
		sweet_alert("<strong>กรุณาบันทึกข้อสอบ!!! ก่อนส่งข้อสอบไปตรวจ</strong>");
	}
});

function sendtemplate_approve() {
	$.ajax({
		method: "POST",
		url: "../../observation/Observation/sendtemplate_approve",
		data: {
			template_id: $("#template_id").val(),
		},
		dataType: "JSON",
		success: function (response) {
			if (response == 1) {
				success_alert("<strong>ส่งข้อสอบไปตรวจเรียบร้อยแล้ว</strong>");
				window.location.replace(
					"../../exam_library/Examlibrary/index?tool_type=6&contract_no=" +
						$("#contract_no").val()
				);
			}
		},
	});
}

function toggle_row_eoc(uoc, eoc, idx_uoc, idx_eoc) {
	if ($("#col_eoc" + idx_uoc + idx_eoc).is(":visible")) {
		$("#toggle_row_eoc" + idx_uoc + idx_eoc).html("+");
	} else {
		$("#toggle_row_eoc" + idx_uoc + idx_eoc).html("-");
	}
	initial_element(uoc, eoc);
}

function initial_element(uoc, eoc) {
	var i = $("#last_idx_" + uoc + eoc).val();
	//alert(i);
	//console.log("initial uoc="+uoc);
	console.log("initial i=" + i);
	//++i;
	for (n = 1; n <= 1; n++) {
		CKEDITOR.replace("list[" + uoc + "][" + eoc + "][" + n + "][question]", {
			fullPage: false,
			allowedContent: true,
			autoGrow_onStartup: true,
			enterMode: CKEDITOR.ENTER_BR,
			extraPlugins: "wysiwygarea",
		});

		CKEDITOR.replace("list[" + uoc + "][" + eoc + "][" + n + "][answer]", {
			fullPage: false,
			allowedContent: true,
			autoGrow_onStartup: true,
			enterMode: CKEDITOR.ENTER_BR,
			extraPlugins: "wysiwygarea",
		});
	}
}
