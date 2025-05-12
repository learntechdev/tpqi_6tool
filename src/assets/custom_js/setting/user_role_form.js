$("#ckAll").click(function (event) {
	if (this.checked) {
		// Iterate each checkbox
		$(":checkbox").each(function () {
			this.checked = true;
		});
	} else {
		$(":checkbox").each(function () {
			this.checked = false;
		});
	}
});

$("#btn_save").click(function () {
	if (validate() == true) {
		save();
	}
});

function validate() {
	var isValid = true;

	if ($("#name").val() == "") {
		$("#name").focus();
		sweet_alert("<strong>กรุณากรอกข้อมูล ชื่อ-นามสกุล!!!</strong>");
		isValid = false;
	} else if ($("#username").val() == "") {
		$("#username").focus();
		sweet_alert("<strong>กรุณากรอกข้อมูล ชื่อผู้ใช้งาน!!!</strong>");
		isValid = false;
	} else if ($("#pwd").val() == "") {
		$("#pwd").focus();
		sweet_alert("<strong>กรุณากรอกข้อมูล รหัสผ่าน!!!</strong>");
		isValid = false;
	} else if ($("#re_pwd").val() == "") {
		$("#re_pwd").focus();
		sweet_alert("<strong>กรุณากรอกข้อมูล ยืนยันรหัสผ่าน!!!</strong>");
		isValid = false;
	} else if ($("#org").val() == "0") {
		$("#org").focus();
		sweet_alert("<strong>กรุณาเลือกองค์กรรับรอง!!!</strong>");
		isValid = false;
	}

	return isValid;
}

function save() {
	var menu_id = [];
	$.each($("input[name='menu']:checked"), function () {
		menu_id.push($(this).val());
	});
	//alert("My favourite sports are: " + menu_id.join(", "));
	$.ajax({
		method: "POST",
		url: "../../settings/UserRole/insert",
		data: {
			action: $("#action").val(),
			username: $("#username").val(),
			password: $("#pwd").val(),
			name: $("#name").val(),
			flag: $("#flag").val(),
			menu_authorized: menu_id.join(", "),
		},
		success: function (res) {
			if (res == "2") {
				sweet_alert("<strong>ชื่อผู้ใช้งานนี้ มีอยู่ในระบบแล้ว!!!</strong>");
			} else {
				success_alert("<strong>บันทึกข้อมูลเรียบร้อยแล้ว</strong>");
				$.redirect("../../settings/UserRole/index");
			}
		},
	});
}
