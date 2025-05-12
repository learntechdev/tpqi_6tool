function gotocreate(tool_type, contract_no) {
	var ac = "create";
	var template_id = "";
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
