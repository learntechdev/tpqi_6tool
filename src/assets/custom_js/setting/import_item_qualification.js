$("#btn_process").click(function () {
	if ($("#api_url").val() == "") {
		sweet_alert("<strong>กรุณา ระบุลิงค์เอพีไอ!!!</strong>");
	} else if ($("#occ_level_id").val() == "") {
		sweet_alert("<strong>กรุณาระบุรหัสคุณวุฒิวิชาชีพ!!!</strong>");
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
			occ_level_id: $("#occ_level_id").val(),
		},
		success: function (data) {
			bp.hideLoading();
			console.log("uoc:" + data);
			if (data == 1) {
				success_alert("<strong>นำเข้าข้อมูลเรียบร้อยแล้ว</strong>");
				$("#occ_level_id").val("");
			} else {
				sweet_alert("<strong>ไม่สามารถนำเข้าข้อมูลได้!!!</strong>");
			}
		},
	});
}
