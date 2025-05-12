$("#btn_process").click(function () {
	//console.log(JSON.stringify($("form").serializeJSON(), null, 2))
	if ($("#api_url").val() == "") {
		sweet_alert("<strong>กรุณา ระบุลิงค์เอพีไอ!!!</strong>");
	} else if ($("#tpqi_exam_no").val() == "") {
		sweet_alert("<strong>กรุณา ระบุรอบสอบ!!!</strong>");
	} else {
		process();
	}
});

function process() {
	bp.showLoading();
	$.ajax({
		url: "../../settings/Importdata/process",
		method: "POST",
		data: {
			api_url: $("#api_url").val(),
			page_no: "1",
			tpqi_exam_no: $("#tpqi_exam_no").val(),
			import_type: "2",
		},
		success: function (data) {
			bp.hideLoading();
			//console.log("uoc:" + data);
			if (data == 1) {
				success_alert("<strong>นำเข้าข้อมูลเรียบร้อยแล้ว</strong>");
				$("#tpqi_exam_no").val("");
			} else if (data == 2) {
				sweet_alert("<strong>รอบสอบนี้ เคยมีการนำเข้าข้อมูลแล้ว!!!</strong>");
				$("#tpqi_exam_no").val("");
			} else {
				sweet_alert("<strong>ไม่สามารถนำเข้าข้อมูลได้!!!</strong>");
			}
		},
	});
}
