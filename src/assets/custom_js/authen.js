function logout() {
	$.ajax({
		type: "POST",

		url: "../../authen/Authentication/logout",

		dataType: "JSON",

		success: function (response) {
			if (response == 1) {
				// $.redirect("../../authen/Authentication/index");
				//location.href = "https://147.50.138.201/tpqi_net63/public/login";
				location.href =
					"https://tpqi-net.tpqi.go.th/";
					 
			}
		},
	});
}
