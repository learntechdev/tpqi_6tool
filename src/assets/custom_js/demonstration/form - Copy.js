$(document).ready(function () {
	$(".occ_level").select2();
	$(".exam_type").select2();
	$(".template_type").select2();
	get_dataforedit();
});

function get_dataforedit() {
	if ($("#action").val() == "update" || $("#action").val() == "copy") {
		$.ajax({
			url: "../../demonstration/DemonstrationTools/get_template",
			method: "POST",
			data: {
				template_id: $("#template_id").val(),
			},
			dataType: "JSON",
			success: function (data) {
				//console.log("data:" + JSON.stringify(data));
				var rs = JSON.parse(JSON.stringify(data));
				fill_data(
					rs[0].occ_level_id,
					rs[0].template_type,
					rs[0].exam_type,
					rs[0].criteria_used_byexamier,
					rs[0].criteria_type_byexamier,
					rs[0].template_id
				);

				

				CKEDITOR.instances["desc_for_examier"].setData(rs[0].desc_for_examier);
				CKEDITOR.instances["desc_for_applicant"].setData(
					rs[0].des_for_applicant
				);
				
				/*for (var i in CKEDITOR.instances) {
					CKEDITOR.instances[i].updateElement();
				}*/
				
				/*CKEDITOR.instances["desc_for_examier"].setData(
					CKEDITOR.instances["desc_for_examier"].getData +
						rs[0].desc_for_examier,
					function () {
						this.checkDirty(); // true
					}
				);*/
				
				var occ_level_id = rs[0].occ_level_id;
				get_uoc_list(occ_level_id);
				show_btn_action();
			},
		});
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
	$("#occ_level_id").val(occ_level_id).trigger("change");
	$("#exam_type").val(exam_type).trigger("change");
	$("#template_type").val(template_type).trigger("change");
	$("#txt_exam_type").val(exam_type);
	$("#txt_template_type").val(template_type);
	$("#template_id").val(template_id);
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
		//$('#exam_type').select2("0", null);

		//$("#exam_type").val('0').trigger('change');

		//$('#exam_type').trigger('change');

		sweet_alert("<strong>กรุณาเลือกคุณวุฒิวิชาชีพ</strong>");
	}
});

$("#template_type").change(function () {
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
	var exam_type = $("#exam_type").val();

	//var asm_tool = $("#asm_tool").val();

	if (exam_type == "2") {
		//ตาม uoc ถาม-ตอบ

		var occ_level_id = $("#occ_level_id").val();

		//alert(occ_level_id);

		get_uoc_list(occ_level_id);

		show_btn_action();
	} else {
		//sweet_alert("<strong>ยังไม่มีเทมเพลตสำหรับสิ่งที่ท่านเลือก กรุณาติดต่อผู้ดูแลระบบ!!!</strong>");

		$("#uoc").hide();

		$("#operation").hide();
	}
}

function show_btn_action() {
	$("#operation").show();
}

function toggle_row(uoc, idx) {
	$("#div_q_ans" + idx).show();

	if ($("#col" + idx).is(":visible")) {
		$("#toggle_row" + idx).html("+");
	} else {
		$("#toggle_row" + idx).html("-");
	}

	initial_element(uoc);
}

function initial_element(uoc) {
	var i = $("#last_idx_" + uoc).val();

	for (n = 1; n <= i; n++) {
		CKEDITOR.replace("list[" + uoc + "][" + n + "][question]", {
			fullPage: false,

			allowedContent: true,

			autoGrow_onStartup: true,

			enterMode: CKEDITOR.ENTER_BR,

			extraPlugins: "wysiwygarea",
		});

		CKEDITOR.replace("list[" + uoc + "][" + n + "][answer]", {
			fullPage: false,

			allowedContent: true,

			autoGrow_onStartup: true,

			enterMode: CKEDITOR.ENTER_BR,

			extraPlugins: "wysiwygarea",
		});
	}
}

//ดึงข้อมูล uoc
function get_uoc_list(occ_level_id) {
	$.ajax({
		url: "../../shared/Shared/get_uoc",
		method: "POST",
		data: {
			asm_tool: "4",
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

$("#btn_save").click(function () {
	// console.log(JSON.stringify($("form").serializeJSON(), null, 2))

	var valid = validate(); //เช็คว่ากรอกข้อมูลครบหรือไม่

	if (valid) {
		save();
	}
});

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
		sweet_alert("<strong>กรุณากรอกข้อมูล คำอธิบายสำหรับผู้ประเมิน!!!</strong>");
		isValid = false;
	}

	if (desc_applicant == "") {
		sweet_alert(
			"<strong>กรุณากรอกข้อมูล คำอธิบายสำหรับผู้เข้ารับประเมิน!!!</strong>"
		);
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

//บันทึกข้อมูล
function save() {
	for (var i in CKEDITOR.instances) {
		CKEDITOR.instances[i].updateElement();
	}

	//console.log("data:" + JSON.stringify($("form").serializeJSON()));

	$.ajax({
		method: "POST",
		url: "../../templates/Longanswer/insert",
		data: {
			dt: JSON.stringify($("form").serializeJSON()),
			tool_type: "5",
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
		//console.log(template_id);
		success_alert("<strong>บันทึกข้อมูลเรียบร้อยแล้ว</strong>");
		$("#template_id").val(template_id);
		$("#action").val() == "copy"
			? $("#copy_tp_id").val(template_id)
			: $("#copy_tp_id").val("");
			
	}
}

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

$("#btn_preview").click(function () {
	if (valid_template()) {
		/*var template_id = $("#template_id").val();
		window.open(
			"../../templates/Longanswer/preview?template_id=" +
				template_id +
				"&tool_type=5",
			"_blank"
		);*/
		printHTML($("#template_id").val(), "5", "1");
	} else {
		sweet_alert("<strong>กรุณาบันทึกข้อสอบ!!! ก่อนส่งข้อสอบไปตรวจ</strong>");
	}
});

function printHTML(template_id, tool_type, doc_type) {
	window.open(
		"../../templates/Longanswer/exam_preview_html?template_id=" +
			template_id +
			"&tool_type=" +
			tool_type +
			"&doc_type=" +
			doc_type,
		"_blank"
	);
	/*ของเก่า แก้ไขโดยดิษฐ์
	window.open(
		"../../templates/Longanswer/exam_used_new_html?template_id=" +
			template_id +
			"&tool_type=" +
			tool_type +
			"&doc_type=" +
			doc_type,
		"_blank"
	);*/
}

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
		url: "../../demonstration/DemonstrationTools/sendtemplate_approve",
		data: {
			template_id: $("#template_id").val(),
		},
		dataType: "JSON",
		success: function (response) {
			if (response == 1) {
				success_alert("<strong>ส่งข้อสอบไปตรวจเรียบร้อยแล้ว</strong>");
				window.location.replace(
					"../../exam_library/Examlibrary/index?tool_type=5&contract_no=" +
						$("#contract_no").val()
				);
			}
		},
	});
}
