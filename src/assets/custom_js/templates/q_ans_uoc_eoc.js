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

function add_q_form(eoc_code, uoc_code) {
	var i = $("#last_idx_" + eoc_code).val();

	//console.log("i="+i);

	//console.log("eoc_code ="+eoc_code);

	//var i = $("#last_idx_"+eoc_code).val();

	i = ++i;

	var form =
		"<div id='form_q_a" +
		eoc_code +
		"_" +
		i +
		"'>" +
		"<div id='f" +
		eoc_code +
		i +
		"'>" +
		"<div class='card'>" +
		"<div class='text-right' style='padding-right:10px;padding-top:10px'>" +
		"<div class='btn-group  btn-group-sm' role='group'>" +
		"<button type='button' class='btn btn-success' id='btn_add_q_form' name='btn_add_q_form' onClick='add_q_form(" +
		eoc_code +
		")' >" +
		"<i class='fa fa-plus-circle' aria-hidden='true'></i>" +
		"</button>" +
		"<button type='button' class='btn btn-danger' id='btn_del_q_form' name='btn_del_q_form' onClick='rm_dynamic_uiform(" +
		eoc_code +
		"," +
		i +
		")'>" +
		"<i class='fa fa-minus-circle' aria-hidden='true'></i>" +
		"</button>" +
		"</div>" +
		"</div>" +
		"<hr/>" +
		"<div class='card-body row'>" +
		"<input type='hidden' class='form-control' name='list[" +
		eoc_code +
		"][" +
		i +
		"][uoc_code]' value='" +
		uoc_code +
		"' />" +
		"<input type='hidden' class='form-control' name='list[" +
		eoc_code +
		"][" +
		i +
		"][order_line]' value='" +
		i +
		"' />" +
		"<input type='hidden' class='form-control' name='list[" +
		eoc_code +
		"][" +
		i +
		"][eoc_code]' value='" +
		eoc_code +
		"' />" +
		"<div class='col-md-6'>" +
		"<label for=''><strong>คำถาม ข้อที่ <span class='num_q" +
		eoc_code +
		"' id='q_num_" +
		eoc_code +
		i +
		"' >" +
		i +
		"</span></strong></label>" +
		"<textarea id='list[" +
		eoc_code +
		"][" +
		i +
		"][question]' name='list[" +
		eoc_code +
		"][" +
		i +
		"][question]'></textarea>" +
		"</div>" +
		"<div class=' col-md-6'>" +
		"<label for=''><strong>แนวทางคำตอบ" +
		"</strong></label>" +
		"<textarea id='list[" +
		eoc_code +
		"][" +
		i +
		"][answer]' name='list[" +
		eoc_code +
		"][" +
		i +
		"][answer]'></textarea>" +
		"</div>" +
		"</div>" +
		"</div>" +
		"</div>" +
		"</div>";

	$("#last_idx_" + eoc_code).val(i);

	$("#form_q_a" + eoc_code + "_" + (i - 1)).append(form);

	CKEDITOR.replace("list[" + eoc_code + "][" + i + "][question]", {
		fullPage: false,

		allowedContent: true,

		autoGrow_onStartup: true,

		enterMode: CKEDITOR.ENTER_BR,

		extraPlugins: "wysiwygarea",
	});

	CKEDITOR.replace("list[" + eoc_code + "][" + i + "][answer]", {
		fullPage: false,

		allowedContent: true,

		autoGrow_onStartup: true,

		enterMode: CKEDITOR.ENTER_BR,

		extraPlugins: "wysiwygarea",
	});

	/*var numrun = 0;

	$(".q_num").each(function () {

		numrun++;

		$("#" + $(this).attr('id')).text(numrun + ".")

	});

	*/
}

function rm_dynamic_uiform(uoc, idx) {
	if (idx == 1) {
		sweet_alert("<strong>คำถามตั้งต้น กรุณาอย่าลบคำถามออกทั้งหมด!!!</strong>");
	} else {
		$("#f" + uoc + idx).remove();

		var total_row = $("#last_idx_" + uoc).val();

		var total_row_after_rm = total_row - 1;

		$("#last_idx_" + uoc).val(total_row_after_rm);

		var num_q = $(".num_q" + uoc);

		for (var i = 0; i < num_q.length; i++) {
			var show_idx = i + 1;

			$(num_q[i]).text(show_idx);

			console.log("ข้อที่ :" + show_idx);
		}
	}
}
