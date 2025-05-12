$(document).ready(function () {
	$(".occ_level").select2();
	$(".exam_type").select2();
	$(".template_type").select2();

	CKEDITOR.replace("desc_for_examier", {
		fullPage: false, // ถ้ากำหนดเป็น false จะลบแท็ก HEAD/BODY/HTML ออกไม่ต้องเก็บลง db
		allowedContent: true,
		autoGrow_onStartup: true,
		enterMode: CKEDITOR.ENTER_BR,
		extraPlugins: "wysiwygarea",
	});
	CKEDITOR.replace("desc_for_applicant", {
		fullPage: false, // ถ้ากำหนดเป็น false จะลบแท็ก HEAD/BODY/HTML ออกไม่ต้องเก็บลง db
		allowedContent: true,
		autoGrow_onStartup: true,
		enterMode: CKEDITOR.ENTER_BR,
		extraPlugins: "wysiwygarea",
	});
	CKEDITOR.replace("case_study", {
		fullPage: false, // ถ้ากำหนดเป็น false จะลบแท็ก HEAD/BODY/HTML ออกไม่ต้องเก็บลง db
		allowedContent: true,
		autoGrow_onStartup: true,
		enterMode: CKEDITOR.ENTER_BR,
		extraPlugins: "wysiwygarea",
	});

	get_dataforedit();
});

function get_dataforedit() {
	if ($("#action").val() == "update" || $("#action").val() == "copy") {
		//var asm_tool = $("#asm_tool").val();

		$.ajax({
			url: "../../interview/InterviewTool/get_template",
			method: "POST",
			data: {
				template_id: $("#template_id").val(),
			},
			dataType: "JSON",
			success: function (data) {
				var rs = JSON.parse(JSON.stringify(data));
				//console.log("data:" + rs[0].desc_for_examier);
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

				//var desc_for_examier = CKEDITOR.replace("desc_for_examier");
				//desc_for_examier.InnerHtml = rs[0].desc_for_examier;

				//$("#desc_for_examier").html(rs[0].desc_for_examier);
				//$("#desc_for_applicant").html(rs[0].des_for_applicant);
				//$("#case_study").html(rs[0].case_study);

				CKEDITOR.instances["desc_for_examier"].setData(rs[0].desc_for_examier);
				CKEDITOR.instances["desc_for_applicant"].setData(
					rs[0].des_for_applicant
				);
				CKEDITOR.instances["case_study"].setData(rs[0].case_study);

				//var occ_level_id = rs[0].occ_level_id;
				//get_uoc_list(occ_level_id[0], asm_tool);
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
	$("#txt_occ_level").val(occ_level_id);
	$("#template_id").val(template_id);
	//$("#contract_no").val(contract_no);

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

//ประเภทการสร้างข้อสอบ
$("#exam_type").change(function () {
	var occ_level_id = $("#occ_level_id").val();
	var template_type = $("#template_type").val();

	if (occ_level_id != 0) {
		if (template_type != 0) {
			$("#eoc").empty();
			$("#uoc").empty();
			$("#eoc").hide();
			$("#uoc").hide();
			//$("#template_type").val(0).trigger("change");
			//check_select_tp();
		}
	} else {
		//$('#exam_type').select2("0", null);
		//$("#exam_type").val('0').trigger('change');
		//$('#exam_type').trigger('change');
		sweet_alert("<strong>กรุณาเลือกคุณวุฒิวิชาชีพ</strong>");
	}
});

//แม่แบบ
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
	var asm_tool = $("#asm_tool").val();
	var occ_level_id = $("#occ_level_id").val();

	if (exam_type == "2") {
		//ตาม uoc ถาม-ตอบ
		get_uoc_list(occ_level_id, asm_tool);
		show_btn_action();
		$("#eoc").hide();
	} else if (exam_type == "3") {
		//alert(exam_type);
		get_uoc_eoc(occ_level_id, asm_tool);
		$("#eoc").show();
		$("#uoc").hide();
		show_btn_action();
	} else {
		//sweet_alert("<strong>ยังไม่มีเทมเพลตสำหรับสิ่งที่ท่านเลือก กรุณาติดต่อผู้ดูแลระบบ!!!</strong>");
		$("#uoc").hide();
		$("#eoc").hide();
		$("#div_manage").hide();
	}
}

//ดึงข้อมูล uoc มาแสดง
function get_uoc_list(occ_level_id, asm_tool) {
	/*console.log("occ_level_id => " + occ_level_id);
	console.log("asm_tool => " + asm_tool);*/

	$.ajax({
		url: "../../interview/InterviewTool/get_uoc",
		method: "POST",
		data: {
			asm_tool: asm_tool,
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

function get_uoc_eoc(occ_level_id, asm_tool) {
	$.ajax({
		url: "../../shared/Shared/get_eoc",
		method: "POST",
		data: {
			asm_tool: asm_tool,
			occ_level_id: occ_level_id,
			template_id: $("#template_id").val(),
		},
		success: function (data) {
			//console.log("uoc:" + data);
			$("#eoc").empty();
			$("#eoc").show();
			$("#eoc").html(data);
		},
	});
}

/*function toggle_row(uoc, idx) {
	$("#div_q_ans" + idx).show();

	if ($("#col" + idx).is(":visible")) {
		$("#toggle_row" + idx).html("+");
	} else {
		$("#toggle_row" + idx).html("-");
	}
	initial_element(uoc);
}*/

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

function show_btn_action() {
	$("#div_manage").show();
}

$("#btn_save").click(function () {
	event.preventDefault();
	var valid = validate(); //เช็คว่ากรอกข้อมูลครบหรือไม่
	if (valid) {
		//save();
		var chk_q = checkInputQuestion();
		if (chk_q) {
			save();
		} else {
			sweet_alert("<strong>กรุณากรอกคำถามและแนวคำตอบ!!!</strong>");
		}
	}
});

function checkInputQuestion() {
	var hasData = false;
	$(".ckq").each(function () {
		//	var q = "";
		var ele = $(this).attr("id");
		var q = CKEDITOR.instances[ele].document.getBody().getChild(0).getText();
		if (q != "") {
			hasData = true;
		}
	});
	return hasData;
}

function validate() {
	var isValid = true;

	/*	for (var i in CKEDITOR.instances) {
		CKEDITOR.instances[i].updateElement();
	}*/

	var desc_examier = CKEDITOR.instances["desc_for_examier"].document
		.getBody()
		.getChild(0)
		.getText();
	var desc_applicant = CKEDITOR.instances["desc_for_applicant"].document
		.getBody()
		.getChild(0)
		.getText();

	if (desc_examier == "" || desc_examier == null) {
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

	/*var form_data = new FormData();

	var totalfiles = document.getElementById("files").files.length;
	for (var index = 0; index < totalfiles; index++) {
		form_data.append("files[]", document.getElementById("files").files[index]);
	}
	*/

	/*var form_data = new FormData();
	$.each(files, function (key, value) {
		form_data.append(key, value);
	});*/

	console.log("data:" + JSON.stringify($("form").serializeJSON()));
	let formdata = {};
	$("#form").serializeArray().forEach(function(item){
		formdata[item.name] = item.value;
	});
	//alert("Before calling ajax");
	$.ajax({
		type: "POST",
		url: "../../interview/InterviewTool/insert",
		
		contentType: "application/json",
		processData: false,
		data: JSON.stringify({
			dt: formdata,
		//	dt: JSON.stringify($("form").serializeArray()),
			tool_type: "3"
			//files: form_data,
		}),
		success: function (response) {
		//	alert("Success alert");
			uploadFiles(response);
			//alert(response);
			console.log("json Data is:", response);
			/*
			success_alert("<strong>บันทึกข้อมูลเรียบร้อยแล้ว</strong>");
			$("#template_id").val(response);
			
			$("#action").val() == "copy"
				? $("#copy_tp_id").val(response)
				: $("#copy_tp_id").val("");
*/
		},
	});
	
	
}

function uploadFiles(template_id) {
//	alert("Upload files");
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

function printDiv(template_id, tool_type) {
	var oldPage = document.body.innerHTML;

	$.ajax({
		url: "../../templates/Longanswer/exam_preview",
		method: "GET",
		data: {
			template_id: template_id,
			tool_type: tool_type,
		},
		success: function (data) {
			//console.log(data);
			$("#div_print").empty();
			$("#div_print").html(data);

			$("#div_print").addClass("printable");
			$("#div_print").show();
			var graphElements = "";
			var divElements = document.getElementById("div_print").innerHTML;

			document.body.innerHTML =
				"<html><head>" +
				"<title></title>" +
				"</head><body>" +
				graphElements +
				divElements +
				"</body>";

			//Print Page
			window.print();

			//Restore orignal HTML
			$("#div_print").remove();
			$("#div_print").hide();
			document.body.innerHTML = oldPage;
			//location.reload();
		},
	});
}

$("#btn_preview").click(function () {
	if (valid_template()) {
		var template_id = $("#template_id").val();
		var asm_tool_type = $("#asm_tool_type").val();
		
		window.open(
			"../../templates/Longanswer/exam_preview_html?template_id=" +
				template_id +
				"&tool_type=" +
				asm_tool_type,
			"_blank"
		);
		//printDiv(template_id, "3");
		/*window.open(
			"../../interview/InterviewTool/preview?template_id=" + template_id,
			"_blank"
		);*/
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
		url: "../../interview/InterviewTool/sendtemplate_approve",
		data: {
			template_id: $("#template_id").val(),
		},
		dataType: "JSON",
		success: function (response) {
			if (response == 1) {
				success_alert("<strong>ส่งข้อสอบไปตรวจเรียบร้อยแล้ว</strong>");
				window.location.replace(
					"../../exam_library/Examlibrary/index?tool_type=3&contract_no=" +
						$("#contract_no").val()
				);
			}
		},
	});
}
