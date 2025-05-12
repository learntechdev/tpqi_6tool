$(document).ready(function () {
	$('#reason_disapproval').prop('readonly', true);
	$(".occ_level").select2({ allowClear: true });
});

function show_criteria(occ_level_id, occ_level_name, place, exam_date, exam_schedule_id, status, tool_type) {
   if(occ_level_id != ""){
        populate_criteria(occ_level_id, occ_level_name, place, exam_date, exam_schedule_id, status, tool_type );
   }
}

function populate_criteria(occ_level_id, occ_level_name, place, exam_date, exam_schedule_id, tool_type) {
	$.ajax({
        method: "POST",
        dataType: "JSON",
		url: "../../approve/Approve/get_criteria",
		data: {
			occ_level_id: occ_level_id
		},
		success: function (res) {
                var rs = JSON.parse(JSON.stringify(res));
                var criteria_desc = rs[0].description;
            $("#modal_approvecriteria").modal("show");
            $(".modal-body #occ_level_id").val(occ_level_id);
            $(".modal-body #occ_level_name").text(occ_level_name);
            $(".modal-body #place").text(place);
            $(".modal-body #exam_date").text(exam_date);
            $(".modal-body #exam_schedule_id").val(exam_schedule_id);
            $(".modal-body #txt_tool_type").val(tool_type);
            $(".modal-body #span_criteria").text(criteria_desc);
		},
	});
}

$('input[type=radio][name=approve_status]').change(function () {
	if (this.value == '6') {
		$('#reason_disapproval').prop('readonly', false);
	} else {
		$('#reason_disapproval').prop('readonly', true);
		$('#reason_disapproval').val('');
	}
});

function validate() {
	var isValid = true;

	var status = $("input[name='approve_status']:checked").val();

	if (status == "6") {
		if ($("#reason_disapproval").val() == "") {
			sweet_alert("<strong>กรุณาระบุเหตุผล ที่ไม่อนุมัติเกณฑ์การประเมิน!!!</strong>");
			isValid = false;
		}
	}

	return isValid;
}

$("#btn_approve_criteria").click(function () {
	var valid = validate();
	if (valid) {
		$.ajax({
			method: "POST",
			url: "../Approve/approve_criteria",
			data: {
				exam_schedule_id: $("#exam_schedule_id").val(),
				template_id : $("#template_id").val(),
				status: $("input[name='approve_status']:checked").val(),
				reason_disapproval: $("#reason_disapproval").val()
			},
			success: function (res) {
				if (res == 1) {
					$("#modal_approvecriteria").modal("hide");
					success_alert("<strong>บันทึกข้อมูลเรียบร้อยแล้ว</strong>")
					search(1);
				}
			},
		});
	}
});

function search(prm_page_no) {
	//bp.showLoading();
	$.ajax({
		url: "../Approve/criteria_forapprove",
		method: "GET",
		data: {
			page_no: prm_page_no,
			per_page: "10",
			occ_level_id: $("#occ_level_id").val(),
			tool_type: $("#tool_type").val(),
			status: $("#status").val(),
			action : "search"
		},
		success: function (data) {
			//bp.hideLoading();
			$("#show_data").empty();
			$("#show_data").html(data);
		},
	});
}

function page(page_no) {
	search(page_no);
}

$("#btn_search").click(function () {
	search(1);
});

$("#btn_cleardata").click(function () {
	$("#occ_level_id").val('').trigger('change')
	$("#tool_type").val('0');
	$("#status").val('0');
	search(1);
})