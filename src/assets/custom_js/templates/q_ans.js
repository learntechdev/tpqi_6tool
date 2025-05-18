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

/*		document.getElementById("showPopup").addEventListener("click", function() {
            document.getElementById("popup").style.display = "block";
            document.getElementById("overlay").style.display = "block";
        });

        document.getElementById("closePopup").addEventListener("click", function() {
            document.getElementById("popup").style.display = "none";
            document.getElementById("overlay").style.display = "none";
        }); */

document.addEventListener("click", function (event) {
  // Check if the clicked element is or contains #showPopup
  let showPopupBtn =
    event.target.id === "showPopup"
      ? event.target
      : event.target.closest("#showPopup");
  if (showPopupBtn) {
    // รับ parameter จาก attribute data-uoc_code (หรือชื่ออื่นที่ต้องการ)
    const uoc_code = showPopupBtn.getAttribute("data-uoc_code");
    // Show the popup
    document.getElementById("popup").style.display = "block";
    document.getElementById("overlay").style.display = "block";
    const checkboxes = document.querySelectorAll('input[name="options[]"]');
    checkboxes.forEach((checkbox) => {
      checkbox.parentElement.style.display = "";
    });
    //alert("uoc_code : " + uoc_code);
    // ถ้ามี parameter ส่งต่อไปใช้
    if (uoc_code) {
      checkboxes.forEach((checkbox) => {
        if (checkbox.value !== uoc_code) {
          checkbox.parentElement.style.display = "";
        } else {
          checkbox.parentElement.style.display = "none";
        }
      });
    }
  }
});

document.getElementById("closePopup").addEventListener("click", function () {
  document.getElementById("popup").style.display = "none";
  document.getElementById("overlay").style.display = "none";
});

document.getElementById("submitPopup").addEventListener("click", function () {
  const checkedBoxes = document.querySelectorAll(
    'input[name="options[]"]:checked'
  );
  const selectedValues = Array.from(checkedBoxes).map(
    (checkbox) => checkbox.value
  );
  document.getElementById("uoc_selected").value = selectedValues;
  document.getElementById("popup").style.display = "none";
  document.getElementById("overlay").style.display = "none";

});
/*
	$(".template .edit-area .del").click(function () {
	$(this).parents("template").remove();
	//alert($(this).attr("id"));
	});
*/

function score_type() {
  var scoretype = document.getElementById("scoretype").value;
  if (scoretype != 0) {
    if (scoretype == 1) {
      document.getElementById("marks_for_q").style.display = "none";
    }
    if (scoretype == 2) {
      document.getElementById("marks_for_q").style.display = "inline";
    }
  } else {
    sweet_alert("<strong>โปรดเลือกประเภทคะแนน</strong>");
  }
}

function add_q_form(uoc_code, eoc_code, row_idx) {
  console.log(uoc_code + " : " + row_idx);

  var tmp_last_ele = $("#tmplast_idx_" + uoc_code + eoc_code).val();
  var ele_id = "";
  var x = $("#count").val();
  var i = $("#last_idx_sub_" + uoc_code + eoc_code).val();
  var n_question = 0;
  var default_score = $("#default_score").val();

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
    "<div class='col-md-8'>" +
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
    "&nbsp; &nbsp; &nbsp;" +
    "<select data-dropup-auto='false' onChange='score_type()' id='scoretype' name='scoretype'" +
    "required='' data-live-search='true'>" +
    "<option value='0'>--กรุณาเลือก--</option>" +
    "<option value='1'>ผ่าน/ไม่ผ่าน</option>" +
    "<option value='2' selected>คะแนนผ่าน</option>" +
    "</select> " +
    "<input class='col-md-2 marks_for_q_new' style='display:inline' type='text' id='marks_for_q' name='marks_for_q' value='" +
    default_score +
    "'>" +
    "</div>" +
    "<div class='col-md-4 text-right'>" +
    "<div class='btn-group  btn-group-sm edit-area' role='group'>";
  if (x != 1) {
    form +=
      "<input type='hidden' id='uoc_selected' name='uoc_selected' value='" +
      x +
      "'>";
    "<button type='button' class='btn btn-success2 add' onClick='' id='showPopup' data-uoc_code='" +
      uoc_code +
      "'>" +
      "<i class='fa fa-plus-circle' aria-hidden='true'><label style='padding-left:2px;'>UOC</label></i>" +
      "</button>&nbsp; &nbsp; &nbsp;";
  }

  form +=
    "<button type='button' class='btn btn-success add' onClick='add_q_form(" +
    uoc_code +
    "," +
    eoc_code +
    "," +
    i +
    ")'>" +
    "<i class='fa fa-plus-circle' aria-hidden='true'><label style='padding-left:2px;'>คำถาม</label></i>" +
    "</button>&nbsp; &nbsp; &nbsp;" +
    "<button type='button' class='btn btn-success3 add' onClick='add_q_grp_form(" +
    uoc_code +
    "," +
    eoc_code +
    "," +
    i +
    ")'>" +
    "<i class='fa fa-plus-circle' aria-hidden='true'><label style='padding-left:2px;'>กลุ่มคำถาม</label></i>" +
    "</button>&nbsp; &nbsp; &nbsp;" +
    "<button type='button' class='btn btn-danger' id='btn_del_q_form' name='btn_del_q_form' onClick='rm_dynamic_uiform(" +
    uoc_code +
    "," +
    eoc_code +
    "," +
    i +
    ")'>" +
    "<i class='fa fa-minus-circle' aria-hidden='true' style='padding-left:2px;'></i>" +
    "</button></div></div>" +
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
    "<div class='col-md-12' style='padding:5px;'>" +
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
    "&nbsp; &nbsp; &nbsp;" +
    '<button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#criteriaModal' +
    uoc_code +
    eoc_code +
    i +
    '">' +
    '<i class="fa fa-list-alt"></i> เกณฑ์การให้คะแนน' +
    "</button>" +
    "<!-- Modal -->" +
    '<div class="modal fade" id="criteriaModal' +
    uoc_code +
    eoc_code +
    i +
    '" tabindex="-1" role="dialog" aria-labelledby="criteriaModalLabel' +
    uoc_code +
    eoc_code +
    i +
    '" aria-hidden="true">' +
    '<div class="modal-dialog modal-dialog-centered" role="document">' +
    '<div class="modal-content">' +
    '<div class="modal-header">' +
    '<h5 class="modal-title" id="criteriaModalLabel' +
    uoc_code +
    eoc_code +
    i +
    '">เกณฑ์การให้คะแนน</h5>' +
    '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
    '<span aria-hidden="true">&times;</span>' +
    "</button>" +
    "</div>" +
    '<div class="modal-body">' +
    '<textarea class="form-control" rows="5" name="list[' +
    uoc_code +
    "][" +
    eoc_code +
    "][" +
    i +
    '][criteria]" placeholder="พิมพ์เกณฑ์การให้คะแนนที่นี่..."></textarea>' +
    "</div>" +
    '<div class="modal-footer">' +
    '<button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>' +
    "</div>" +
    "</div>" +
    "</div>" +
    "</div>" +
    "<br />" +
    "<br />" +
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
    "<div class=' col-md-12'>" +
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

function add_q_form2(uoc_code, eoc_code, row_idx, groupContainerId) {
  console.log(uoc_code + " : " + row_idx);

  var tmp_last_ele = $("#tmplast_idx_" + uoc_code + eoc_code).val();
  var ele_id = "";
  var i = $("#last_idx_sub_" + uoc_code + eoc_code).val();
  var n_question = 0;
  var default_score = $("#default_score").val();

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
    "<div class='col-md-8'>" +
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
    "][g_question_status]'>" +
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
    "][g_question_status]'>" +
    "&nbsp; ไม่ใช้งาน" +
    "&nbsp; &nbsp; &nbsp;" +
    "<select data-dropup-auto='false' onChange='score_type()' id='g_scoretype' name='g_scoretype'" +
    "required='' data-live-search='true'>" +
    "<option value='0'>--กรุณาเลือก--</option>" +
    "<option value='1'>ผ่าน/ไม่ผ่าน</option>" +
    "<option value='2' selected>คะแนนผ่าน</option>" +
    "</select> " +
    "<input class='col-md-2 marks_for_q_new' style='display:inline' type='text' id='g_marks_for_q' name='g_marks_for_q' value='" +
    default_score +
    "'>" +
    "</div>" +
    "<div class='col-md-4 text-right'>" +
    "<div class='btn-group  btn-group-sm edit-area' role='group'>" +
    /*        "<button type='button' class='btn btn-success2 add' onClick='' id='showPopup'>" +
        "<i class='fa fa-plus-circle' aria-hidden='true'><label style='padding-left:2px;'>UOC</label></i>"+
        "</button>&nbsp; &nbsp; &nbsp;"+   */
    "<button type='button' class='btn btn-success add' onClick='add_q_form2(" +
    uoc_code +
    "," +
    eoc_code +
    "," +
    i +
    ', "' +
    groupContainerId +
    "\")'>" +
    "<i class='fa fa-plus-circle' aria-hidden='true'><label style='padding-left:2px;'>คำถาม</label></i>" +
    "</button>&nbsp; &nbsp; &nbsp;" +
    "<button type='button' class='btn btn-danger' id='btn_del_q_form' name='btn_del_q_form' onClick='rm_dynamic_uiform(" +
    uoc_code +
    "," +
    eoc_code +
    "," +
    i +
    ")'>" +
    "<i class='fa fa-minus-circle' aria-hidden='true' style='padding-left:2px;'></i>" +
    "</button></div></div>" +
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
    "<div class='col-md-12' style='padding:5px;'>" +
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
    "&nbsp; &nbsp; &nbsp;" +
    '<button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#criteriaModal' +
    uoc_code +
    eoc_code +
    i +
    '">' +
    '<i class="fa fa-list-alt"></i> เกณฑ์การให้คะแนน' +
    "</button>" +
    "<!-- Modal -->" +
    '<div class="modal fade" id="criteriaModal' +
    uoc_code +
    eoc_code +
    i +
    '" tabindex="-1" role="dialog" aria-labelledby="criteriaModalLabel' +
    uoc_code +
    eoc_code +
    i +
    '" aria-hidden="true">' +
    '<div class="modal-dialog modal-dialog-centered" role="document">' +
    '<div class="modal-content">' +
    '<div class="modal-header">' +
    '<h5 class="modal-title" id="criteriaModalLabel' +
    uoc_code +
    eoc_code +
    i +
    '">เกณฑ์การให้คะแนน</h5>' +
    '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
    '<span aria-hidden="true">&times;</span>' +
    "</button>" +
    "</div>" +
    '<div class="modal-body">' +
    '<textarea class="form-control" rows="5" name="list[' +
    uoc_code +
    "][" +
    eoc_code +
    "][" +
    i +
    '][criteria]" placeholder="พิมพ์เกณฑ์การให้คะแนนที่นี่..."></textarea>' +
    "</div>" +
    '<div class="modal-footer">' +
    '<button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>' +
    "</div>" +
    "</div>" +
    "</div>" +
    "</div>" +
    "<br />" +
    "<br />" +
    "<textarea id='list[" +
    uoc_code +
    "][" +
    eoc_code +
    "][" +
    i +
    "][g_question]' name='list[" +
    uoc_code +
    "][" +
    eoc_code +
    "][" +
    i +
    "][g_question]'></textarea>" +
    "</div>" +
    "<div class=' col-md-12'>" +
    "<label for=''><strong>แนวทางคำตอบ" +
    "</strong></label>" +
    "<textarea id='list[" +
    uoc_code +
    "][" +
    eoc_code +
    "][" +
    i +
    "][g_answer]' name='list[" +
    uoc_code +
    "][" +
    eoc_code +
    "][" +
    i +
    "][g_answer]'></textarea>" +
    "</div>" +
    "</div>" +
    "</div>" +
    "</div>";

  $("#last_idx_" + uoc_code + eoc_code).val(i);
  $("#last_idx_sub_" + uoc_code + eoc_code).val(i);

  $("#tmplast_idx_" + uoc_code + eoc_code).val(i);
  //	$("#form_q_g" + uoc_code + eoc_code).append(form);
  $("#" + groupContainerId).append(form);
  /*console.log(
		"last_idx_sub_ : " + $("#last_idx_sub_" + uoc_code + eoc_code).val()
	);*/

  reorder(uoc_code, eoc_code);
  setTimeout(() => {
    CKEDITOR.replace(
      "list[" + uoc_code + "][" + eoc_code + "][" + i + "][g_question]",
      {
        fullPage: false,
        allowedContent: true,
        autoGrow_onStartup: true,
        enterMode: CKEDITOR.ENTER_BR,
        extraPlugins: "wysiwygarea",
      }
    );
  }, 0);

  setTimeout(() => {
    CKEDITOR.replace(
      "list[" + uoc_code + "][" + eoc_code + "][" + i + "][g_answer]",
      {
        fullPage: false,
        allowedContent: true,
        autoGrow_onStartup: true,
        enterMode: CKEDITOR.ENTER_BR,
        extraPlugins: "wysiwygarea",
      }
    );
  }, 0);
}

function add_q_grp_form(uoc_code, eoc_code, row_idx) {
  console.log(uoc_code + " : " + row_idx);

  var tmp_last_ele = $("#tmplast_idx_" + uoc_code + eoc_code).val();
  var ele_id = "";
  var i = $("#last_idx_sub_" + uoc_code + eoc_code).val();
  var x = $("#count").val();
  var n_question = 0;
  var groupContainerId = "group_q_section_" + uoc_code + eoc_code + i;
  var default_score = $("#default_score").val();
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
    "<div id='g" +
    uoc_code +
    eoc_code +
    i +
    "'>" +
    "<div class='card'>" +
    "<div class='row' style='padding-right:10px;padding-left:10px;padding-top:10px'>" +
    "<div class='col-md-7'>" +
    "<label for=''><strong>คำถามกลุ่ม</strong></label>&nbsp; &nbsp; &nbsp;" +
    "<input type='radio' value='1' checked id='list[" +
    uoc_code +
    "][" +
    eoc_code +
    "][" +
    i +
    "][" +
    groupContainerId +
    "][question_status1]'" +
    "name='list[" +
    uoc_code +
    "][" +
    eoc_code +
    "][" +
    i +
    "][" +
    groupContainerId +
    "][main_question_status]'>" +
    "&nbsp; ใช้งาน &nbsp; &nbsp; " +
    "<input type='radio' value='0' id='list[" +
    uoc_code +
    "][" +
    eoc_code +
    "][" +
    i +
    "][" +
    groupContainerId +
    "][question_status2]'" +
    "name='list[" +
    uoc_code +
    "][" +
    eoc_code +
    "][" +
    i +
    "][" +
    groupContainerId +
    "][main_question_status]'>" +
    "&nbsp; ไม่ใช้งาน" +
    "&nbsp; &nbsp; &nbsp;" +
    "</div>" +
    "<div class='col-md-5 text-right'>" +
    "<div class='btn-group  btn-group-sm edit-area' role='group'>";
  if (x != 1) {
    form +=
      "<input type='hidden' id='g_uoc_selected' name='g_uoc_selected' value='" +
      x +
      "'>";
    "<button type='button' class='btn btn-success2 add' onClick='' id='showPopup' data-uoc_code='" +
      uoc_code +
      "'>" +
      "<i class='fa fa-plus-circle' aria-hidden='true'><label style='padding-left:2px;'>UOC</label></i>" +
      "</button>&nbsp; &nbsp; &nbsp;";
  }

  form +=
    "<button type='button' class='btn btn-success add' onClick='add_q_form(" +
    uoc_code +
    "," +
    eoc_code +
    "," +
    i +
    ")'>" +
    "<i class='fa fa-plus-circle' aria-hidden='true'><label style='padding-left:2px;'>คำถาม</label></i>" +
    "</button>&nbsp; &nbsp; &nbsp;" +
    "<button type='button' class='btn btn-success3 add' onClick='add_q_grp_form(" +
    uoc_code +
    "," +
    eoc_code +
    "," +
    i +
    ")'>" +
    "<i class='fa fa-plus-circle' aria-hidden='true'><label style='padding-left:2px;'>กลุ่มคำถาม</label></i>" +
    "</button>&nbsp; &nbsp; &nbsp;" +
    "<button type='button' class='btn btn-danger' id='btn_del_q_form' name='btn_del_q_form' onClick='rm_dynamic_uiform2(" +
    uoc_code +
    "," +
    eoc_code +
    "," +
    i +
    ")'>" +
    "<i class='fa fa-minus-circle' aria-hidden='true' style='padding-left:2px;'></i>" +
    "</button>" +
    "</div>" +
    "</div>" +
    "<div class='col-md-12' style='padding:5px;'>" +
    "<textarea class='ckeditor chgrpq' id='list[" +
    uoc_code +
    "][" +
    eoc_code +
    "][" +
    i +
    "][grpquestion]' name='list[" +
    uoc_code +
    "][" +
    eoc_code +
    "][" +
    i +
    "][grpquestion]'></textarea>" +
    "</div>" +
    "</div>" +
    "<div id='" +
    groupContainerId +
    "'>" +
    "<div class='card'>" +
    "<div class='row' style='padding-right:10px;padding-left:10px;padding-top:10px'>" +
    "<div class='col-md-8'>" +
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
    "][g_question_status]'>" +
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
    "][g_question_status]'>" +
    "&nbsp; ไม่ใช้งาน" +
    "&nbsp; &nbsp; &nbsp;" +
    "<select data-dropup-auto='false' onChange='score_type()' id='g_scoretype' name='g_scoretype'" +
    "required='' data-live-search='true'>" +
    "<option value='0'>--กรุณาเลือก--</option>" +
    "<option value='1'>ผ่าน/ไม่ผ่าน</option>" +
    "<option value='2' selected>คะแนนผ่าน</option>" +
    "</select> " +
    "<input class='col-md-2 marks_for_q_new' style='display:inline' type='text' id='g_marks_for_q' name='g_marks_for_q' value='" +
    default_score +
    "'>" +
    "</div>" +
    "<div class='col-md-4 text-right'>" +
    "<div class='btn-group  btn-group-sm edit-area' role='group'>" +
    /*        "<button type='button' class='btn btn-success2 add' onClick='' id='showPopup'>" +
        "<i class='fa fa-plus-circle' aria-hidden='true'><label style='padding-left:2px;'>UOC</label></i>"+
        "</button>&nbsp; &nbsp; &nbsp;"+   */
    "<button type='button' class='btn btn-success add' onClick='add_q_form2(" +
    uoc_code +
    "," +
    eoc_code +
    "," +
    i +
    ', "' +
    groupContainerId +
    "\")'>" +
    "<i class='fa fa-plus-circle' aria-hidden='true'><label style='padding-left:2px;'>คำถาม</label></i>" +
    "</button>&nbsp; &nbsp; &nbsp;" +
    "</div></div>" +
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
    "<div class='col-md-12' style='padding:5px;'>" +
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
    "&nbsp; &nbsp; &nbsp;" +
    '<button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#criteriaModal' +
    uoc_code +
    eoc_code +
    i +
    '">' +
    '<i class="fa fa-list-alt"></i> เกณฑ์การให้คะแนน' +
    "</button>" +
    "<!-- Modal -->" +
    '<div class="modal fade" id="criteriaModal' +
    uoc_code +
    eoc_code +
    i +
    '" tabindex="-1" role="dialog" aria-labelledby="criteriaModalLabel' +
    uoc_code +
    eoc_code +
    i +
    '" aria-hidden="true">' +
    '<div class="modal-dialog modal-dialog-centered" role="document">' +
    '<div class="modal-content">' +
    '<div class="modal-header">' +
    '<h5 class="modal-title" id="criteriaModalLabel' +
    uoc_code +
    eoc_code +
    i +
    '">เกณฑ์การให้คะแนน</h5>' +
    '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
    '<span aria-hidden="true">&times;</span>' +
    "</button>" +
    "</div>" +
    '<div class="modal-body">' +
    '<textarea class="form-control" rows="5" name="list[' +
    uoc_code +
    "][" +
    eoc_code +
    "][" +
    i +
    '][criteria]" placeholder="พิมพ์เกณฑ์การให้คะแนนที่นี่..."></textarea>' +
    "</div>" +
    '<div class="modal-footer">' +
    '<button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>' +
    "</div>" +
    "</div>" +
    "</div>" +
    "</div>" +
    "<br />" +
    "<br />" +
    "<textarea id='list[" +
    uoc_code +
    "][" +
    eoc_code +
    "][" +
    i +
    "][g_question]' name='list[" +
    uoc_code +
    "][" +
    eoc_code +
    "][" +
    i +
    "][g_question]'></textarea>" +
    "</div>" +
    "<div class=' col-md-12'>" +
    "<label for=''><strong>แนวทางคำตอบ" +
    "</strong></label>" +
    "<textarea id='list[" +
    uoc_code +
    "][" +
    eoc_code +
    "][" +
    i +
    "][g_answer]' name='list[" +
    uoc_code +
    "][" +
    eoc_code +
    "][" +
    i +
    "][g_answer]'></textarea>" +
    "</div>" +
    "</div>" +
    "</div>" +
    "</div>" +
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
    "list[" + uoc_code + "][" + eoc_code + "][" + i + "][grpquestion]",
    {
      fullPage: false,
      allowedContent: true,
      autoGrow_onStartup: true,
      enterMode: CKEDITOR.ENTER_BR,
      extraPlugins: "wysiwygarea",
    }
  );

  CKEDITOR.replace(
    "list[" + uoc_code + "][" + eoc_code + "][" + i + "][g_question]",
    {
      fullPage: false,
      allowedContent: true,
      autoGrow_onStartup: true,
      enterMode: CKEDITOR.ENTER_BR,
      extraPlugins: "wysiwygarea",
    }
  );

  CKEDITOR.replace(
    "list[" + uoc_code + "][" + eoc_code + "][" + i + "][g_answer]",
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

function rm_dynamic_uiform2(uoc, eoc, idx) {
	//console.log(uoc + " : " + idx);

	if (idx == 1) {
		sweet_alert("<strong>คำถามตั้งต้น กรุณาอย่าลบคำถามออกทั้งหมด!!!</strong>");
		//console.log("idx:" + idx);
	} else {
		var chk_last_idx = $("#tmplast_idx_" + uoc + eoc).val();
		//console.log("uoc:" + uoc + " idx:" + chk_last_idx);
		$("#g" + uoc + eoc + idx).remove();

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
