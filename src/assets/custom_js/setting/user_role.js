$(document).ready(function () {});

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

$("#btn_add").click(function (e) {
	e.preventDefault();
	$.redirect("../../settings/UserRole/create");
});

function modalExamround(username) {
	$("#form_examround").modal("show");
	$("#modal_title").text("สิทธิ์การเห็นรอบสอบ" + " " + "ของคุณ" + username);
	$("#txt_username").val(username);
	showauthorized_examround(username);
}

function search(prm_page_no) {
	bp.showLoading();
	$.ajax({
		url: "../../settings/UserRole/search",
		method: "GET",
		data: {
			page_no: prm_page_no,
			per_page: "10",
			keyword: $("#txt_search").val(),
		},
		success: function (data) {
			bp.hideLoading();
			$("#show_data").empty();
			$("#show_data").html(data);
		},
	});
}

function page(page_no) {
	search(page_no);
}

function showauthorized_examround(username) {
	$.ajax({
		url: "../../settings/UserRole/getAuthorizedExamround",
		method: "GET",
		data: {
			page_no: "1",
			per_page: "10",
			username: username,
		},
		success: function (data) {
			$("#show_data_examround").empty();
			$("#show_data_examround").html(data);
		},
	});
}

function cancel(username) {
	Swal.fire({
		title: "ยืนยัน!!!",
		text: "คุณต้องการลบข้อมูลใช่หรือไม่?",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		confirmButtonText: "ใช่",
		cancelButtonText: "ยกเลิก",
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				method: "POST",
				url: "../../settings/UserRole/cancelRole",
				data: {
					username: username,
				},
				dataType: "JSON",
				success: function (response) {
					if (response == 1) {
						success_alert("<strong>ลบข้อมูลเรียบร้อยแล้ว</strong>");
						search(1);
					}
				},
			});
		}
	});
}

$("#btn_clear").click(function () {
	$("#txt_search").val("");
	search(1);
});

//ไปยังหน้าจอกำหนดสิทธิ์การเห็นรอบสอบ
function gotoAER(username, user_id) {
	$.redirect("../../settings/UserRole/AERIndex", {
		username: username,
		user_id: user_id,
	});
}

//ไปยังหน้าจอกำหนดสิทธิ์การเห็นคุณวุฒิวิชาชีพ
function gotoAocc(username, user_id) {
	$.redirect("../../settings/UserRole/AoccIndex", {
		username: username,
		user_id: user_id,
	});
}
