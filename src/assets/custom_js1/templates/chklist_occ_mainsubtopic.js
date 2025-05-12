function add_main_topic(idx) {
	var i = $("#last_idx").val();
	var j = $("#last_sub_idx" + idx).val();
	if (j == "") {
		j = 1;
	} else {
		j = j;
	}
	//console.log('i='+i);
	++i;
	var form =
		"<div id='form_q" +
		i +
		"'>" +
		"<div id='f_topic" +
		i +
		"'>" +
		"<div class='row' id='port_type' style='padding-left:20px;padding-right:20px;'>" +
		"<div class='col-md-12'>" +
		"<div class='row'>" +
		"<div class='col-sm-12 py-2' style=' background-color: #eeeeee '>" +
		"<div class='col-md-12'>" +
		"<div class='input-group mb-1'>" +
		"<div class='input-group-prepend'>" +
		"<span class='label_head num_q'>" +
		i +
		".</span>" +
		"</div>" +
		"&nbsp;&nbsp;<input type='text' class='form-control' style='background-color: #fff' " +
		"id='topic_" +
		i +
		"' name='list[" +
		i +
		"][topic]' />" +
		"&nbsp;&nbsp;" +
		"<div class='btn-group  btn-group-sm' role='group'>" +
		"<button type='button' class='btn btn-success' id='btn_add_q_form' name='btn_add_q_form' onClick='add_main_topic(" +
		idx +
		")'>" +
		"<i class='fa fa-plus-circle' aria-hidden='true'></i>" +
		"</button>" +
		"<button type='button' class='btn btn-danger' id='btn_del_q_form' name='btn_del_q_form' onClick='remove_main_topic(" +
		i +
		")'>" +
		"<i class='fa fa-minus-circle' aria-hidden='true'></i>" +
		"</button>" +
		"</div>" +
		"</div>" +
		"</div>" +
		"</div>" +
		"</div>" +
		"</div>" +
		"<div class='col-md-12' id='subtopic_div_" +
		i +
		"'>" +
		"<input type='hidden' id='last_sub_idx_" +
		i +
		"' name='last_sub_idx_" +
		i +
		"' value='1'>" +
		"<div class='col-md-12 ' id='subtopic_" +
		i +
		"_1'>" +
		"<div id='f_subtopic" +
		i +
		"1'>" +
		"<div class='col-md-12'>" +
		"<div class='row'>" +
		"<div class='col-md-11 py-2'>" +
		"<div class='col-auto'>" +
		"<div class='input-group'>" +
		"<div class='input-group-prepend'>" +
		"<div class='num_subtopic" +
		i +
		"'>" +
		i +
		".1</div>" +
		"</div>" +
		"&nbsp;&nbsp;<input type='text' class='form-control' style='background-color: #fff'" +
		"id='sub_topic_" +
		i +
		"' name='list[" +
		i +
		"][detail][1][subtopic]'/>" +
		"</div>" +
		"</div>" +
		"</div>" +
		"<div class='col-md-1 py-2'>" +
		"<div class='btn-group  btn-group-sm' role='group'>" +
		"<button type='button' class='btn btn-info' id='btn_add_q_form' " +
		"name='btn_add_q_form' onClick='add_sub_topic(" +
		i +
		")'>" +
		"<i class='fa fa-plus-circle' aria-hidden='true'></i>" +
		"</button>" +
		/*"<button type='button' class = 'btn btn-danger' id = 'btn_del_q_form' " +
		"name = 'btn_del_q_form' onClick='remove_subtopic(" +
		i +
		",1)'>" +
		"<i class='fa fa-minus-circle' aria-hidden = 'true'></i>" +
		"</button>" +*/
		"</div>" +
		"</div>" +
		"</div>" +
		"</div>" +
		"</div>" +
		"</div>" +
		"</div>" +
		"</div>" +
		"</div>" +
		"</div>" +
		"</div>" +
		"</div>";

	$("#last_idx").val(i);
	//$("#last_sub_idx_"+i).val(j);
	$("#form_q" + idx).append(form);
	//$("#form_q_main").append(form);
}

function add_sub_topic(main_i, j) {
	if (j == null) {
		j = 1;
	}
	console.log(main_i + " => " + j);

	//var main_i = "";
	//var last_main = $("#last_idx").val();
	var j = $("#last_sub_idx_" + main_i).val();

	/*if (main_idx == last_main) {
		main_i = main_idx;
	} else if (main_idx < last_main) {
		main_i = last_main;
	} else {
		main_idx = last_main;
	}*/

	/*if (j == '') {
		j = 1;
	} else { j = j; }*/

	//console.log("j:" + j);

	++j;

	var form =
		//	"<div class='row'>" +
		"<div class='col-md-12' id='subtopic_" +
		main_i +
		"_" +
		j +
		"'>" +
		"<div id='f_subtopic" +
		main_i +
		j +
		"'>" +
		"<div class='col-md-12'>" +
		"<div class='row'>" +
		"<div class='col-md-11 py-2'>" +
		"<div class='col-auto'>" +
		"<div class='input-group'>" +
		"<div class='input-group-prepend'>" +
		"<div id='num_stopic" +
		j +
		"' class=' num_subtopic" +
		main_i +
		"'>" +
		main_i +
		"." +
		j +
		"</div>" +
		"</div>" +
		"&nbsp;&nbsp;<input type='text' class='form-control' style=' background-color: #fff'" +
		"id='sub_topic_" +
		j +
		"' name='list[" +
		main_i +
		"][detail][" +
		j +
		"][subtopic]'/>" +
		"</div>" +
		"</div>" +
		"</div>" +
		"<div class='col-md-1 py-2'>" +
		"<div class='btn-group  btn-group-sm' role='group'>" +
		"<button type='button' class='btn btn-info' id='btn_add_q_form' " +
		"name='btn_add_q_form' onClick='add_sub_topic(" +
		main_i +
		")'>" +
		"<i class='fa fa-plus-circle' aria-hidden='true'></i>" +
		"</button>" +
		"<button type='button' class = 'btn btn-danger' id = 'btn_del_q_form' " +
		"name = 'btn_del_q_form' onClick='remove_subtopic(" +
		main_i +
		"," +
		j +
		")'>" +
		"<i class='fa fa-minus-circle' aria-hidden = 'true'></i>" +
		"</button>" +
		"</div>" +
		"</div>" +
		"</div>" +
		"</div>" +
		"</div>" +
		"</div>"; /*+
		"</div>"*/

	$("#last_sub_idx_" + main_i).val(j);
	console.log(main_i + " " + j);

	//$("#subtopic_" + main_i + "_" + (j - 1)).append(form);
	$("#subtopic_div_" + main_i).append(form);
}

function remove_main_topic(idx) {
	if (idx == 1) {
		sweet_alert("<strong>คำถามตั้งต้น กรุณาอย่าลบคำถามออกทั้งหมด!!!</strong>");
	} else {
		$("#f_topic" + idx).remove();

		var total_row = $("#last_idx").val();
		var total_row_after_rm = total_row - 1;
		$("#last_idx").val(total_row_after_rm);

		var num_q = $(".num_q");
		for (var i = 1; i <= num_q.length; i++) {
			var show_idx = i + 1;
			$(num_q[i]).text(show_idx);
		}
		auto_numsubtopic(num_q.length);
	}
}

function auto_numsubtopic(idx) {
	var main_idx = idx + 1;
	//alert("idx_sub:" + main_idx);
	var num_q = $(".num_subtopic" + main_idx);
	for (var i = 0; i < num_q.length; i++) {
		var show_idx = i + 1;
		show_num = idx + "." + show_idx;
		$(num_q[i]).text(show_num);
	}
}

function remove_subtopic(idx, subtopic_idx) {
	if (idx == 1 && subtopic_idx == 1) {
		sweet_alert("<strong>คำถามตั้งต้น กรุณาอย่าลบคำถามออกทั้งหมด!!!</strong>");
	} else {
		$("#f_subtopic" + idx + subtopic_idx).remove();

		var total_row = $("#last_sub_idx_" + idx).val();
		var total_row_after_rm = total_row - 1;
		$("#last_sub_idx_" + idx).val(total_row_after_rm);

		var num_q = $(".num_subtopic" + idx);
		var show_num = "";
		for (var i = 0; i < num_q.length; i++) {
			var show_idx = i + 1;
			show_num = idx + "." + show_idx;
			$(num_q[i]).text(show_num);
		}
	}
}
