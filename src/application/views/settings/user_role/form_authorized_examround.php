<?php $this->load->view("breadcrumb/breadcrumb", $breadcrumb); ?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="min-height:480px">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <span class="label_head">กำหนดสิทธิ์ในการเห็นรอบสอบของ <strong><?= $name ?></strong></span>
                            <hr />
                        </div>
                        <div class="col-md-12">
                            <form>
                                <div class="row">
                                    <input type="hidden" class="form-control" id="txt_username" value="<?= $name ?>">
                                    <label class="col-md-3 col-form-label text-right"> รอบสอบ<span class="span-req-field">*</span></label>
                                    <div class="col-md-4" style="padding-bottom:5px">
                                        <input type="text" class="form-control" id="examround">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10 text-center" style="margin-top:5px">
                                        <button type="button" class="btn btn-primary" onclick="authorized_examround()">บันทึก</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12">
                            <hr />
                            <h4>แสดงสิทธิ์ในการเห็นรอบสอบ</h4>
                            <div class=" row" id="show_data_examround">
                                <?php
                                if (!empty($dataListExamRound)) {
                                    $this->load->view("settings/user_role/show_authorized_examround", array(
                                        "dataListExamRound" => $dataListExamRound,
                                    ));
                                } else { ?>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="font-weight:bold;color:red;text-align:center">
                                    == ไม่พบข้อมูล ==
                                </div>
                            </div>
                            <?php   } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function authorized_examround() {
    if (validate() == true) {
        save();
    }
}

function validate() {
    var isValid = true;
    if ($("#examround").val() == "") {
        $("#examround").focus();
        sweet_alert("<strong>กรุณากรอกข้อมูล รอบสอบ!!!</strong>");
        isValid = false;
    }
    return isValid;
}

function save() {
    $.ajax({
        method: "POST",
        url: "../../settings/UserRole/insert_authorized_examround",
        data: {
            username: $("#txt_username").val(),
            examround: $("#examround").val(),
        },
        success: function(res) {
            if (res == "0") {
                sweet_alert("<strong>ไม่สามารถบันทึกข้อมูลได้!!!</strong>");
            } else if (res == "2") {
                sweet_alert("<strong>มีรอบสอบนี้แล้ว!!!</strong>");
            } else {
                success_alert("<strong>บันทึกข้อมูลเรียบร้อยแล้ว</strong>");
                $("#examround").empty();
                $("#examround").val("");
                showauthorized_examround(1);
            }
        },
    });
}
</script>