$(document).ready(function () {
    for (i = 1; i <= 3; i++) {
        // initial_element(i);
    }
    console.log("i=" + i);
}
);

function initial_element(idx) {
    var i = idx;
    var form =
        "<div id='form_q_a'>" +
        "<div id='f" + i + "'>" +
        "<div class='col-md-12'>" +
        "<div class='row col-md-12' style='padding:5px'>" +
        "<div class='col-md-1'>" +
        "<span class='num_q" + uoc + "' id='q_num" + i + "'> ข้อที่ " + i + "</span>" +
        "</div>" +
        "<div class='col-md-10'>" +
        "<input type='text' class='form-control'>" +
        "</div>" +
        "<div class=' col-md-1'>" +
        "<div class='btn-group  btn-group-sm' role='group'>" +
        "<button type='button' class='btn btn-success' id='btn_add_q_form' name='btn_add_q_form' onClick='add_q_form(" + i + ")'>" +
        " <i class='fa fa-plus-circle' aria-hidden='true'></i>" +
        "</button>" +
        "<button type='button' class='btn btn-danger'" + "id='btn_del_q_form' name='btn_del_q_form'" +
        "onClick='rm_dynamic_uiform(" + i + ")'>" +
        "<i class='fa fa-minus-circle' aria-hidden='true'></i>" +
        "</button>" +
        "</div>" +
        "</div>" +
        "</div>" +
        "</div>" +
        "</div>" +
        "</div>";

    $("#last_idx").val(i);
    $("#form_q_a").append(form);
}

//เพิ่มคำถาม
function add_q_form(uoc) {
    var i = $("#last_idx" + uoc).val();
    console.log("i=" + i);
    ++i;
    var form =
        "<div id='form_q_a" + uoc + "_" + i + "'>" +
        "<div id='f" + uoc + i + "'>" +

        "<div class='row'>"+
            "<div class='col-md-1'>"+
                "<span class='num_q" + uoc + "' id='q_num_" + uoc + i + "'> ข้อที่ " + i + "</span>" +
            "</div>"+
            "<div class='col-md-7'>"+
                "<label>สถานะคำถาม</label>&nbsp; &nbsp; &nbsp;"+
                "<input type='radio' value='1' checked id='uocchklist[" + uoc + "][" + i + "][question_status1]'"+"name='uocchklist[" + uoc + "][" + i + "][question_status]'>"+
                        "&nbsp; ใช้งาน &nbsp; &nbsp; &nbsp;"+
                "<input type='radio' value='0' id='uocchklist[" + uoc + "][" + i + "][question_status2]'"+
                    "name='uocchklist[" + uoc + "][" + i + "][question_status]'>"+
                    " &nbsp; ไม่ใช้งาน "+
            "</div>"+
        "</div>"+

        "<div class='row'>" +
        "<div class='row col-md-12' style='padding:5px'>" +
        "<div class='col-md-11'>" +
        "<input type='hidden' class='form-control' name='uocchklist[" + uoc + "][" + i + "][order_line]'" +
        "value='" + i + "' />" +
        "<input type='hidden' class='form-control' name='uocchklist[" + uoc + "][" + i + "][uoc_code]'" +
        "value='" + uoc + "' />" +
        "<input type='text' class='form-control' name='uocchklist[" + uoc + "][" + i + "][topic]'/>" +
        "</div>" +
        "<div class=' col-md-1'>" +
        "<div class='btn-group  btn-group-sm' role='group'>" +
        "<button type='button' class='btn btn-success' id='btn_add_q_form' name='btn_add_q_form' onClick='add_q_form(" + uoc + ")'>" +
        " <i class='fa fa-plus-circle' aria-hidden='true'></i>" +
        "</button>" +
        "<button type='button' class='btn btn-danger'" + "id='btn_del_q_form' name='btn_del_q_form'" +
        "onClick='rm_dynamic_uiform(" + uoc + "," + i + ")'>" +
        "<i class='fa fa-minus-circle' aria-hidden='true'></i>" +
        "</button>" +
        "</div>" +
        "</div>" +
        "</div>" +
        "</div><br/>" +
        "</div>" +
        "</div>";

    $("#last_idx" + uoc).val(i);
    $("#form_q_a" + uoc + "_" + (i - 1)).append(form);

}

function rm_dynamic_uiform(uoc, idx) {
    // console.log("idx rm:"+uoc+idx);
    if (idx == 1) {
        sweet_alert("<strong>คำถามตั้งต้น กรุณาอย่าลบคำถามออกทั้งหมด!!!</strong>");
    } else {
        $("#f" + uoc + idx).remove();

        var total_row = $("#last_idx" + uoc).val();
        var total_row_after_rm = total_row - 1;
        $("#last_idx" + uoc).val(total_row_after_rm);

        var num_q = $('.num_q' + uoc);
        for (var i = 0; i < num_q.length; i++) {
            var show_idx = i + 1;
            $(num_q[i]).text("ข้อที่ " + show_idx);
        }
    }
}