$("#btn_process").click(function () {
	if ($("#api_url").val() == "") {
		sweet_alert("<strong>กรุณา ระบุลิงค์เอพีไอ!!!</strong>");
	} else if ($("#start_page").val() == "" || $("#end_page").val() == "") {
		sweet_alert(
			"<strong>กรุณาจำนวนเพจเริ่มต้น หรือจำนวนเพจสิ้นสุด!!!</strong>"
		);
	} else {
		process();
	}
});

function process() {
	bp.showLoading();
	$.ajax({
		url: "../../settings/Importdata/process_item_qualification",
		method: "POST",
		data: {
			api_url: $("#api_url").val(),
			start_page: $("#start_page").val(),
			end_page: $("#end_page").val(),
		},
		success: function (data) {
			bp.hideLoading();
			console.log("uoc:" + data);
			if (data == 1) {
				success_alert("<strong>นำเข้าข้อมูลเรียบร้อยแล้ว</strong>");
				$("#start_page").val("");
				$("#end_page").val("");
			} else {
				sweet_alert("<strong>ไม่สามารถนำเข้าข้อมูลได้!!!</strong>");
			}
		},
	});
}
