$(document).ready(function () {
	$(".occ_level").select2({ allowClear: true });
	$("#user_exam_assign").select2({
		allowClear: true,
		placeholder: "ค้นหาชื่อ...",
	});
	$("#user_assessor").select2({
		allowClear: true,
		placeholder: "ค้นหาชื่อ...",
	});
	$("#start_date")
		.datepicker({
			language: "th-th",
			autoclose: true,
		})
		.on("changeDate", function (ev) {
			$("#start_date").datepicker("hide");
		});

	$("#end_date")
		.datepicker({
			language: "th-th",
			autoclose: true,
		})
		.on("changeDate", function (ev) {
			$("#end_date").datepicker("hide");
		});
});

/*
$(".js-example-basic-multiple").select2({
	maximumSelectionLength: 2,
});*/
/* 
$(".js-select2").select2({
	closeOnSelect: false,
	placeholder: "Placeholder",
	allowHtml: true,
	allowClear: true,
	tags: true, // создает новые опции на лету
});
*/

/*
$("#user_examassignment").autocomplete({
	source: function (request, response) {
		//alert(request.term);
		$.ajax({
			method: "POST",
			url: "../../exam/ExamAssignment/getUsers",
			data: {
				term: request.term,
			},
			dataType: "json",
			success: function (data) {
				//alert(data);
				var resp = $.map(data, function (obj) {
					return obj.first_name;
				});
				response(resp);
			},
		});
	},
	minLength: 1,
});
*/

$("#btn_save").click(function () {
	if (validate() == true) {
		save();
	}
});

function validate() {
	var isValid = true;

	var date_start = $("#start_date").val();
	var date_end = $("#end_date").val();
	var d1 = date_start.split("/");
	var d2 = date_end.split("/");
	d1 = d1[2] + "" + d1[1] + "" + d1[0];
	d2 = d2[2] + "" + d2[1] + "" + d2[0];
	console.log("d1:" + d1);

	var today = new Date();
	var dd = String(today.getDate()).padStart(2, "0");
	var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
	var yyyy = today.getFullYear();
	today = yyyy + 543 + mm + dd;
	today1 = mm + "/" + dd + "/" + yyyy;

	//console.log("today:" + today);

	if ($("#contract_no").val() == "") {
		$("#contract_no").focus();
		sweet_alert("<strong>กรุณากรอกข้อมูล เลขที่สัญญา!!!</strong>");
		isValid = false;
	} else if ($("#start_date").val() == "") {
		$("#start_date").focus();
		sweet_alert("<strong>กรุณากรอกข้อมูล วันที่เริ่มต้นสัญญา!!!</strong>");
		isValid = false;
	} else if ($("#end_date").val() == "") {
		$("#end_date").focus();
		sweet_alert("<strong>กรุณากรอกข้อมูล วันที่สิ้นสุดสัญญา!!!</strong>");
		isValid = false;
	} else if ($("#project_name").val() == "") {
		$("#project_name").focus();
		sweet_alert("<strong>กรุณากรอกข้อมูล ชื่อโครงการ!!!</strong>");
		isValid = false;
	} else if ($("#occ_level_id").val() == "0") {
		$("#occ_level_id").focus();
		sweet_alert("<strong>กรุณาเลือกคุณวุฒิวิชาชีพ!!!</strong>");
		isValid = false;
	} else if ($("#user_exam_assign").val() == "") {
		$("#user_exam_assign").focus();
		sweet_alert("<strong>กรุณาระบุผู้ออกข้อสอบ!!!</strong>");
		isValid = false;
	} else if ($("#user_assessor").val() == "") {
		$("#user_assessor").focus();
		sweet_alert("<strong>กรุณาระบุผู้ตรวจข้อสอบ!!!</strong>");
		isValid = false;
	} else if (d1 > d2) {
		sweet_alert("<strong>วันที่เริ่มทำสัญญาต้องน้อยกว่าวันที่สิ้นสุด</strong>");
		isValid = false;
	}

	return isValid;
}

function save() {
	console.log("data:" + JSON.stringify($("form").serializeJSON()));
	var str_user_exam_assign = $(".user_exam_assign").val();
	var str_user_assessor = $(".user_assessor").val();

	$.ajax({
		method: "POST",
		url: "../../exam/ExamAssignment/insert",
		data: {
			dt: JSON.stringify($("form").serializeJSON()),
			user_exam_assign1: str_user_exam_assign,
			user_assessor1: str_user_assessor,
			exam_assign_id: $("#exam_assign_id").val(),
		},
		success: function (response) {
			success_alert("<strong>บันทึกข้อมูลเรียบร้อยแล้ว</strong>");
			$.redirect("../../exam/ExamAssignment/index");
		},
	});
}
