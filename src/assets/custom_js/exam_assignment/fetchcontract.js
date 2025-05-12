function gotocreate(tool_type, contract_no, level_id) {
	var ac = "create";
	var template_id = "";
	if (tool_type == 2) {
		$.redirect("../../portfolio/PortfolioTools/create", {
			action: ac,
			template_id: template_id,
			asm_tool_type: tool_type,
			contract_no: contract_no,
		//	occ_level_name: levelName,
			level_id : level_id,
		});
	} else if (tool_type == 3) {
		$.redirect("../../interview/InterviewTool/create", {
			action: ac,
			template_id: template_id,
			asm_tool_type: tool_type,
			contract_no: contract_no,
		//	occ_level_name: levelName,
			level_id : level_id,
		});
	} else if (tool_type == 4) {
		$.redirect("../../simulation/SimulationTools/create", {
			action: ac,
			template_id: template_id,
			asm_tool_type: tool_type,
			contract_no: contract_no,
		//	occ_level_name: levelName,
			level_id : level_id,
		});
	} else if (tool_type == 5) {
		$.redirect("../../demonstration/DemonstrationTools/create", {
			action: ac,
			template_id: template_id,
			asm_tool_type: tool_type,
			contract_no: contract_no,
		//	occ_level_name: levelName,
			level_id : level_id,
		});
	} else if (tool_type == 6) {
		$.redirect("../../observation/Observation/create", {
			action: ac,
			template_id: template_id,
			asm_tool_type: tool_type,
			contract_no: contract_no,
		//	occ_level_name: levelName,
			level_id : level_id,
		});
	} else if (tool_type == 7) {
		$.redirect("../../tools/Thirdparty/create", {
			action: ac,
			template_id: template_id,
			asm_tool_type: tool_type,
			contract_no: contract_no,
		//	occ_level_name: levelName,
			level_id : level_id,
		});
	} else {
		sweet_alert("<strong>อยู่ระหว่างดำเนินการ!!!</strong>");
	}
}

function page(page_no) {
	search(page_no);
}

function search(prm_page_no) {
	bp.showLoading();
	$.ajax({
		url: "../ExamAssignment/searchFetchContract",
		method: "GET",
		data: {
			page_no: prm_page_no,
			per_page: "10",
			keyword: $("#keyword").val(),
		},
		success: function (data) {
			bp.hideLoading();
			$("#show_data").empty();
			$("#show_data").html(data);
		},
	});
}