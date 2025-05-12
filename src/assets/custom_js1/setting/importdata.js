$("#btn_process").click(function () {
	//console.log(JSON.stringify($("form").serializeJSON(), null, 2))
	if ($("#api_url").val() == "") {
		sweet_alert("<strong>กรุณา ระบุลิงค์เอพีไอ!!!</strong>");
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
		},
		success: function (data) {
			bp.hideLoading();
			console.log("uoc:" + data);
		},
	});
}
