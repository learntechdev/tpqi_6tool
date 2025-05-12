$(document).ready(function () {
	$(".occ_level").select2({ allowClear: true });

	$("#tp_created_date_start")
		.datepicker({
			language: "th-th",
			autoclose: true,
		})
		.on("changeDate", function (ev) {
			$("#tp_created_date_start").datepicker("hide");
		});

	$("#tp_created_date_end")
		.datepicker({
			language: "th-th",
			autoclose: true,
		})
		.on("changeDate", function (ev) {
			$("#tp_created_date_end").datepicker("hide");
		});

	//search(1);
});

//pagination คลิกไปหน้าอื่น
function page(page_no) {
	search(page_no);
}

function search(prm_page_no) {
	bp.showLoading();
	//alert($("#tp_created_date_start").val());
	$.ajax({
		url: "../Examlibrary/search",
		method: "GET",
		data: {
			tool_type: $("#tool_type").val(),
			page_no: prm_page_no,
			per_page: "15",
			occ_level_id: $("#occ_level_id").val(),
			tp_created_date_start: $("#tp_created_date_start").val(),
			tp_created_date_end: $("#tp_created_date_end").val(),
			contract_no: $("#contract_no").val(),
		},
		success: function (data) {
			bp.hideLoading();
			//$(".modal-backdrop").remove();
			$("#show_data").empty();
			$("#show_data").html(data);
		},
	});
}

function tg_tp_row(num) {
	if ($("#template" + num).is(":visible")) {
		$("#tg_tp_row" + num).html("+");
	} else {
		$("#tg_tp_row" + num).html("-");
	}
}

function cancel(prm_tp_id) {
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
				url: "../Examlibrary/cancel",
				data: {
					tp_id: prm_tp_id,
					tool_type: $("#tool_type").val(),
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

function update_approve_status(status, template_id, tool_type) {
	if (status == "2") {
		//ไม่อนุมัติต้องระบุเหตุผล
		(async () => {
			const { value: text } = await Swal.fire({
				input: "textarea",
				inputLabel: "เหตุผลที่ไม่อนุมัติ",
				inputPlaceholder: "กรุณากรอก เหตุผลที่ไม่อนุมัติ",
				inputAttributes: {
					"aria-label": "",
				},
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				confirmButtonText: "บันทึก",
				cancelButtonText: "ยกเลิก",
			});

			if (text) {
				sendtoapprove_reviewexam(status, template_id, text, tool_type);
			} else {
				sweet_alert("<strong>กรุณากรอก เหตุผลที่ไม่อนุมัติ!!!</strong>");
			}
		})();
	} else {
		Swal.fire({
			title: "ยืนยัน!!!",
			text: "คุณต้องการส่งข้อสอบไปอนุมัติใช่หรือไม่?",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			confirmButtonText: "ใช่",
			cancelButtonText: "ยกเลิก",
		}).then((result) => {
			if (result.isConfirmed) {
				sendtoapprove_reviewexam(status, template_id, "", tool_type);
			}
		});
	}
}

function sendtoapprove_reviewexam(
	status,
	template_id,
	reason_disapprove,
	tool_type
) {
	
	
	//bp.showLoading();
	$.ajax({
		url: "../Examlibrary/approve_review_exam",
		method: "POST",
		data: {
			template_id: template_id,
			status: status,
			tool_type: tool_type,
			reason_disapprove: reason_disapprove,
		},
		
		success: function (res) {
			//bp.hideLoading();
			
			if (res == 1) {
				success_alert("<strong>บันทึกข้อมูลเรียบร้อยแล้ว</strong>");
				search(1);
			}
		},
	});
}
/*
function exam_preview(template_id, tool_type, template_type, exam_type) {
	if (tool_type == 3) {
		printDiv(template_id, "3");
	} else if (tool_type == 4) {
		update_exam_status(template_id, exam_schedule_id, tool_type);
		window.open(
			"../../simulation/SimulationTools/exam_preview?template_id=" +
				template_id,
			"_blank"
		);
	} else if (tool_type == 5) {
		update_exam_status(template_id, exam_schedule_id, tool_type);
		window.open(
			"../../demonstration/DemonstrationTools/exam_preview?template_id=" +
				template_id,
			"_blank"
		);
	} else if (tool_type == 6) {
		printDiv(template_id, "6");
	} else if (tool_type == 7) {
		update_exam_status(template_id, exam_schedule_id, tool_type);
		window.open(
			"../../tools/Thirdparty/exam_preview?template_id=" + template_id,
			"_blank"
		);
	} else {
		sweet_alert(
			"<strong>เครื่องมือประเมินนี้ ไม่อนุญาตให้นำข้อสอบไปใช้!!!</strong>"
		);
	}
}
*/

$("#btn_add_exam").click(function (e) {
	e.preventDefault();
	$.redirect("../../" + $("#url_create").val(), {
		asm_tool_type: $("#tool_type").val(),
		contract_no: $("#contract_no").val(),
	});
});

function exam_preview_old(template_id, tool_type, template_type, exam_type) {
	//เช็คประเภทเทมเพลต

	if (tool_type == 2) {
		window.open(
			"../../portfolio/PortfolioTools/exam_preview?template_id=" + template_id,
			"_blank"
		);
	} else if (tool_type == 3) {
		window.open(
			"../../interview/InterviewTool/preview?template_id=" + template_id,
			"_blank"
		);
	} else if (tool_type == 4) {
		window.open(
			"../../templates/Longanswer/new_preview?template_id=" +
				template_id +
				"&tool_type=4" +
				"&doc_type=2",
			"_blank"
		);
		/*window.open(
			"../../simulation/SimulationTools/exam_preview?template_id=" +
				template_id,
			"_blank"
		);*/
	} else if (tool_type == 5) {
		window.open(
			"../../demonstration/DemonstrationTools/exam_preview?template_id=" +
				template_id,
			"_blank"
		);
	} else if (tool_type == 6) {
		if (template_type == "3" && exam_type == "3") {
			window.open(
				"../../templates/Longanswer/preview?template_id=" +
					template_id +
					"&tool_type=6",
				"_blank"
			);
		} else {
			window.open(
				"../../observation/Observation/exam_preview?template_id=" + template_id,
				"_blank"
			);
		}
	} else if (tool_type == 7) {
		window.open(
			"../../tools/Thirdparty/exam_preview?template_id=" + template_id,
			"_blank"
		);
	} else {
		sweet_alert("<strong>อยู่ระหว่างดำเนินการ!!!</strong>");
	}
}

function edit(template_id, tool_type, contract_no, action) {
	var ac = action == "copy" ? "copy" : "update";

	if (tool_type == 2) {
		$.redirect("../../portfolio/PortfolioTools/create", {
			action: ac,
			template_id: template_id,
			asm_tool_type: tool_type,
			contract_no: contract_no,
		});
	} else if (tool_type == 3) {
		$.redirect("../../interview/InterviewTool/create", {
			action: ac,
			template_id: template_id,
			asm_tool_type: tool_type,
			contract_no: contract_no,
		});
	} else if (tool_type == 4) {
		$.redirect("../../simulation/SimulationTools/create", {
			action: ac,
			template_id: template_id,
			asm_tool_type: tool_type,
			contract_no: contract_no,
		});

		//window.location.replace("../../simulation/SimulationTools/create?action=update&template_id=" + template_id);
	} else if (tool_type == 5) {
		$.redirect("../../demonstration/DemonstrationTools/create", {
			action: ac,
			template_id: template_id,
			asm_tool_type: tool_type,
			contract_no: contract_no,
		});
	} else if (tool_type == 6) {
		$.redirect("../../observation/Observation/create", {
			action: ac,
			template_id: template_id,
			asm_tool_type: tool_type,
			contract_no: contract_no,
		});
	} else if (tool_type == 7) {
		$.redirect("../../tools/Thirdparty/create", {
			action: ac,
			template_id: template_id,
			asm_tool_type: tool_type,
			contract_no: contract_no,
		});
	} else {
		sweet_alert("<strong>อยู่ระหว่างดำเนินการ!!!</strong>");
	}
}

$("#btn_search").click(function () {
	var date_start = $("#tp_created_date_start").val();
	var date_end = $("#tp_created_date_end").val();
	var d1 = date_start.split("/");
	var d2 = date_end.split("/");
	d1 = d1[2] + "" + d1[1] + "" + d1[0];
	d2 = d2[2] + "" + d2[1] + "" + d2[0];
	if (d1 != "" && d2 == "") {
		sweet_alert("<strong>กรุณาระบุวันที่สิ้นสุด</strong>");
	} else if (d1 == "" && d2 != "") {
		sweet_alert("<strong>กรุณาระบุวันที่เริ่มต้น</strong>");
	} else if (d1 > d2) {
		sweet_alert("<strong>วันที่เริ่มต้นต้องน้อยกว่าวันที่สิ้นสุด</strong>");
	} else {
		search(1);
	}
});

$("#btn_clear").click(function () {
	$("input[type=text]").val("");
	$("#occ_level_id").val("").trigger("change");
	search(1);
});

function fetch_reasondisapprove(template_id) {
	populate_reasondisapprove(template_id);
}

function populate_reasondisapprove(template_id) {
	$.ajax({
		method: "POST",
		dataType: "JSON",
		url: "../../approve/Approve/get_r_reason_disapprove",
		data: {
			template_id: template_id,
		},
		success: function (res) {
			$("#modal_reason_disapprove").modal("show");
			$(".modal-body #reason_disapprove").text(res.reason_disapprove);
		},
	});
}

/** print with html */

function exam_preview(template_id, tool_type, template_type, exam_type) {
	// if (tool_type == 2) {
	//     //printDiv(template_id, "2");
	//     //window.open(
	//     //	"../../portfolio/PortfolioTools/exam_preview?template_id=" + template_id,
	//     //	"_blank"
	//     //);
	//     printHTML(template_id, "2");
	// } else if (tool_type == 3) {
	//     printHTML(template_id, "3");
	// } else if (tool_type == 4) {
	//     printHTML(template_id, "4");
	//     //printDiv(template_id, "4");
	// } else if (tool_type == 5) {
	//     printHTML(template_id, "5");
	//     //printDiv(template_id, "5");
	// } else if (tool_type == 6) {
	//     if (template_type == "3" && exam_type == "3") {
	//         printHTML(template_id, "6");
	//         //printDiv(template_id, "6");
	//     } else {
	//         printHTML(template_id, "6");
	//         //printDiv(template_id, "6");
	//     }
	// } else if (tool_type == 7) {
	//     printHTML(template_id, "7");
	//     //printDiv(template_id, "7");
	// } else {
	//     sweet_alert("<strong>อยู่ระหว่างดำเนินการ!!!</strong>");
	// }
	
	if (tool_type == 6) {
		window.open(
			"../../observation/Observation/exam_preview?template_id=" +
				template_id,
			"_blank"
		);
	} else if (tool_type == 2) {
		window.open(
			"../../portfolio/PortfolioTools/exam_preview?template_id=" +
				template_id,
			"_blank"
		);
	} else if (tool_type == 7) {
		window.open(
			"../../tools/Thirdparty/exam_preview?template_id=" +
				template_id,
			"_blank"
		);
	} else {
		window.open(
			"../../templates/Longanswer/exam_preview_html?template_id=" +
				template_id +
				"&tool_type=" +
				tool_type + 
				"&doc_type=2",
			"_blank"
		);
	}
}

function printHTML(template_id, tool_type) {
	window.open(
		"../../templates/Longanswer/exam_preview_html?template_id=" +
			template_id +
			"&tool_type=" +
			tool_type,
		"_blank"
	);
}

function printDiv(template_id, tool_type) {
	$.ajax({
		url: "../../templates/Longanswer/exam_preview",
		method: "GET",
		data: {
			template_id: template_id,
			tool_type: tool_type,
		},
		success: function (data) {
			/*var divContents = document.getElementById("div_print").innerHTML;
			var a = window.open("", "", "height=500, width=500");
			a.document.write("<html>");
			a.document.write("<body>");
			a.document.write(divContents);
			a.document.write("</body></html>");
			a.document.close();
			a.print();*/
			var oldPage = document.body.innerHTML;
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

			window.print();

			$("#div_print").remove();
			$("#div_print").hide();
			document.body.innerHTML = oldPage;
			//location.reload();
		},
	});
}
