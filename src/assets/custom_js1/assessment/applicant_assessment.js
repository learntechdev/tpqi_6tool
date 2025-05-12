function goto_create_assessment(
	template_id,
	app_id,
	name,
	tool_type,
	exam_schedule_id,
	occ_level_name,
	occ_level_id
) {
	if (tool_type == "3") {
		$.redirect("../../interview/InterviewTool/assessment_create", {
			template_id: template_id,
			app_id: app_id,
			name: name,
			exam_schedule_id: exam_schedule_id,
			occ_level_name: occ_level_name,
			tool_type: tool_type,
			occ_level_id,
		});
	} else if (tool_type == "5") {
		$.redirect("../../demonstration/DemonstrationTools/assessment_create", {
			template_id: template_id,
			app_id: app_id,
			name: name,
			exam_schedule_id: exam_schedule_id,
			occ_level_name: occ_level_name,
			tool_type: tool_type,
			occ_level_id,
		});
	} else if (tool_type == "2") {
		$.redirect("../../portfolio/PortfolioTools/assessment_create", {
			template_id: template_id,
			app_id: app_id,
			name: name,
			exam_schedule_id: exam_schedule_id,
			occ_level_name: occ_level_name,
			tool_type: tool_type,
			occ_level_id,
		});
	} else if (tool_type == "4") {
		$.redirect("../../simulation/SimulationTools/assessment_create", {
			template_id: template_id,
			app_id: app_id,
			name: name,
			exam_schedule_id: exam_schedule_id,
			occ_level_name: occ_level_name,
			tool_type: tool_type,
			occ_level_id,
		});
	} else if (tool_type == "7") {
		$.redirect("../../tools/Thirdparty/assessment_create", {
			template_id: template_id,
			app_id: app_id,
			name: name,
			exam_schedule_id: exam_schedule_id,
			occ_level_name: occ_level_name,
			tool_type: tool_type,
			occ_level_id,
		});
	} else if (tool_type == "6") {
		$.redirect("../../observation/Observation/assessment_create", {
			template_id: template_id,
			app_id: app_id,
			name: name,
			exam_schedule_id: exam_schedule_id,
			occ_level_name: occ_level_name,
			tool_type: tool_type,
			occ_level_id,
		});
	} else {
		sweet_alert("<strong>อยู่ระหว่างดำเนินการ!!!</strong>" + tool_type);
	}
}

$("#btn_search").click(function () {
	search("1");
});

function search(prm_page_no) {
	//bp.showLoading();
	$.ajax({
		url: "../../assessment/Assessment/search_applicant_assessment",
		method: "POST",
		data: {
			page_no: prm_page_no,
			per_page: "30",
			template_id: $("#template_id").val(),
			tool_type: $("#tool_type").val(),
			exam_schedule_id: $("#exam_schedule_id").val(),
			keyword: $("#keyword").val(),
			assessment_status: $("#assessment_status").val(),
			occ_level_name: $("#occ_level_name").val(),
			occ_level_id: $("#occ_level_id").val(),
		},
		success: function (data) {
			//bp.hideLoading();
			$("#show_data").empty();
			$("#show_data").html(data);
		},
	});
}

$("#btn_clear").click(function () {
	$("#keyword").val("");
	$("#assessment_status").val("");
	search(1);
});

function page(page_no) {
	search(page_no);
}
