$(document).ready(function () {
	$(".ckeditor").each(function (_, ckeditor) {
		CKEDITOR.replace(ckeditor, {
			fullPage: false,
			allowedContent: true,
			autoGrow_onStartup: true,
			enterMode: CKEDITOR.ENTER_BR,
			extraPlugins: "wysiwygarea",
		});
	});
});

/*
	$(".template .edit-area .del").click(function () {
	$(this).parents("template").remove();
	//alert($(this).attr("id"));
	});
*/

function add_q_form(uoc_code, eoc_code, row_idx) {
	console.log(uoc_code + " : " + row_idx);

	var tmp_last_ele = $("#tmplast_idx_" + uoc_code + eoc_code).val();
	var ele_id = "";
	var i = $("#last_idx_sub_" + uoc_code + eoc_code).val();
	var n_question = 0;

	/*if (row_idx < tmp_last_ele) {
		ele_id = parseInt(tmp_last_ele) + 1;
		old_q = $("#last_idx_" + uoc_code).val();
		n_question = parseInt(old_q) + 1;
		i = ++i;
		} else if (row_idx == tmp_last_ele) {
		ele_id = parseInt(tmp_last_ele) + 1;
		i = ++i;
		n_question = i;
		} else {
		i = ++i;
		n_question = i;
		ele_id = i;
		console.log("มากกว่า : " + i);
	}*/
	//console.log("last_idx_sub_ : " + i);

	++i;
	var form =
		"<div id='f" +
		uoc_code +
		eoc_code +
		i +
		"'>" +
		"<div class='card'>" +
		"<div class='row' style='padding-right:10px;padding-left:10px;padding-top:10px'>" +
		"<div class='col-md-7'>" +
		"<label >สถานะคำถาม</label> &nbsp; &nbsp; &nbsp; " +
		"<input type='radio' value='1' checked id='list[" +
		uoc_code +
		"][" +
		eoc_code +
		"][" +
		i +
		"][question_status1]'" +
		"name='list[" +
		uoc_code +
		"][" +
		eoc_code +
		"][" +
		i +
		"][question_status]'>" +
		"&nbsp; ใช้งาน &nbsp; &nbsp; " +
		"<input type='radio' value='0' id='list[" +
		uoc_code +
		"][" +
		eoc_code +
		"][" +
		i +
		"][question_status2]'" +
		"name='list[" +
		uoc_code +
		"][" +
		eoc_code +
		"][" +
		i +
		"][question_status]'>" +
		"&nbsp; ไม่ใช้งาน" +
		"</div>" +
		"<div class='col-md-5 text-right'>" +
		"<div class='btn-group  btn-group-sm' role='group'>" +
		"<button type='button' class='btn btn-success' id='btn_add_q_form' name='btn_add_q_form' onClick='add_q_form(" +
		uoc_code +
		"," +
		eoc_code +
		"," +
		i +
		")' >" +
		"<i class='fa fa-plus-circle' aria-hidden='true'></i>" +
		"</button>" +
		"<button type='button' class='btn btn-danger' id='btn_del_q_form' name='btn_del_q_form' onClick='rm_dynamic_uiform(" +
		uoc_code +
		"," +
		eoc_code +
		"," +
		i +
		")'>" +
		"<i class='fa fa-minus-circle' aria-hidden='true'></i>" +
		"</button>" +
		"</div>" +
		"</div>" +
		"</div>" +
		"<hr/>" +
		"<div class='card-body row'>" +
		"<input type='hidden' class='form-control' name='list[" +
		uoc_code +
		"][" +
		eoc_code +
		"][" +
		i +
		"][order_line]' value='" +
		i +
		"' />" +
		"<input type='hidden' class='form-control' name='list[" +
		uoc_code +
		"][" +
		eoc_code +
		"][" +
		i +
		"][uoc_code]' value='" +
		uoc_code +
		"' />" +
		"<input type='hidden' class='form-control' name='list[" +
		uoc_code +
		"][" +
		eoc_code +
		"][" +
		i +
		"][eoc_code]' value='" +
		eoc_code +
		"' />" +
		"<div class='col-md-6'>" +
		"<label for=''><strong>คำถาม ข้อที่ <span class='num_q" +
		uoc_code +
		eoc_code +
		"' id='q_num_" +
		uoc_code +
		eoc_code +
		i +
		"' >" +
		i +
		"</span></strong></label>" +
		"<textarea id='list[" +
		uoc_code +
		"][" +
		eoc_code +
		"][" +
		i +
		"][question]' name='list[" +
		uoc_code +
		"][" +
		eoc_code +
		"][" +
		i +
		"][question]'></textarea>" +
		"</div>" +
		"<div class=' col-md-6'>" +
		"<label for=''><strong>แนวทางคำตอบ" +
		"</strong></label>" +
		"<textarea id='list[" +
		uoc_code +
		"][" +
		eoc_code +
		"][" +
		i +
		"][answer]' name='list[" +
		uoc_code +
		"][" +
		eoc_code +
		"][" +
		i +
		"][answer]'></textarea>" +
		"</div>" +
		"</div>" +
		"</div>" +
		"</div>";

	$("#last_idx_" + uoc_code + eoc_code).val(i);
	$("#last_idx_sub_" + uoc_code + eoc_code).val(i);

	$("#tmplast_idx_" + uoc_code + eoc_code).val(i);
	$("#form_q_a" + uoc_code + eoc_code).append(form);
	/*console.log(
		"last_idx_sub_ : " + $("#last_idx_sub_" + uoc_code + eoc_code).val()
	);*/

	reorder(uoc_code, eoc_code);
	CKEDITOR.replace(
		"list[" + uoc_code + "][" + eoc_code + "][" + i + "][question]",
		{
			fullPage: false,
			allowedContent: true,
			autoGrow_onStartup: true,
			enterMode: CKEDITOR.ENTER_BR,
			extraPlugins: "wysiwygarea",
		}
	);

	CKEDITOR.replace(
		"list[" + uoc_code + "][" + eoc_code + "][" + i + "][answer]",
		{
			fullPage: false,
			allowedContent: true,
			autoGrow_onStartup: true,
			enterMode: CKEDITOR.ENTER_BR,
			extraPlugins: "wysiwygarea",
		}
	);
}

function rm_dynamic_uiform(uoc, eoc, idx) {
	//console.log(uoc + " : " + idx);

	if (idx == 1) {
		sweet_alert("<strong>คำถามตั้งต้น กรุณาอย่าลบคำถามออกทั้งหมด!!!</strong>");
		//console.log("idx:" + idx);
	} else {
		var chk_last_idx = $("#tmplast_idx_" + uoc + eoc).val();
		//console.log("uoc:" + uoc + " idx:" + chk_last_idx);
		$("#f" + uoc + eoc + idx).remove();

		var total_row = $("#last_idx_" + uoc + eoc).val();
		var total_row_after_rm = total_row - 1;
		$("#last_idx_" + uoc + eoc).val(total_row_after_rm);

		reorder(uoc, eoc);
	}
}

function reorder(uoc, eoc) {
	var num_q = $(".num_q" + uoc + eoc);
	for (var i = 0; i < num_q.length; i++) {
		var show_idx = i + 1;
		$(num_q[i]).text(show_idx);
		//console.log("ข้อที่ :" + show_idx);
	}
}
