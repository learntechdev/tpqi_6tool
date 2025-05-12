<?php $this->load->view("breadcrumb/breadcrumb", $breadcrumb); ?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="min-height:480px">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <span class="label_head">กำหนดสิทธิ์ในการเห็นคุณวุฒิวิชาชีพ ของ <strong><?= $name ?></strong></span>
                            <hr />
                        </div>
                        <div class="col-md-12">
                            <form>
                                <div class="row">
                                    <input type="hidden" class="form-control" id="txt_username" value="<?= $name ?>">
                                    <label class="col-md-3 col-form-label text-right"> คุณวุฒิวิชาชีพ<span class="span-req-field">*</span></label>
                                    <div class="col-md-6" style="padding-bottom:5px">
                                        <select class="form-control occ_level" data-dropup-auto="false" id="occ_level_id" name="occ_level_id" required="" data-live-search="true">
                                            <option value="">--ทั้งหมด--</option>
                                            <?php
                                            $tmp_occ_level = $this->MasterDataModel->getAllOCC();
                                            foreach ($tmp_occ_level as $v) { ?>
                                            <option value="<?php echo $v->id; ?>">
                                                <?php echo $v->occ_level; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10 text-center" style="margin-top:5px">
                                        <button type="button" class="btn btn-primary" onclick="saveAocc()">บันทึก</button>
                                        <button type="button" class="btn btn-secondary">ยกเลิก</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12">
                            <hr />
                            <h4>แสดงสิทธิ์ในการเห็นรอบสอบ</h4>
                            <div class=" row" id="showdata_aocc">
                                <?php
                                if (!empty($dataListAocc)) {
                                    $this->load->view("settings/user_role/show_authorized_occ", array(
                                        "dataListAocc" => $dataListAocc,
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
$(document).ready(function() {
    $(".occ_level").select2({
        allowClear: true
    });
});

function saveAocc() {
    if (validate() == true) {
        save();
    }
}

function validate() {
    var isValid = true;
    if ($("#occ_level_id").val() == "0" || $("#occ_level_id").val() == "") {
        $("#occ_level_id").focus();
        sweet_alert("<strong>กรุณาเลือกคุณวุฒิวิชาชีพ!!!</strong>");
        isValid = false;
    }
    return isValid;
}

function save() {
    $.ajax({
        method: "POST",
        url: "../../settings/UserRole/insertAuthorizedOcc",
        data: {
            username: $("#txt_username").val(),
            occ_level_id: $("#occ_level_id").val(),
        },
        success: function(res) {
            if (res == "0") {
                sweet_alert("<strong>ไม่สามารถบันทึกข้อมูลได้!!!</strong>");
            } else if (res == "2") {
                sweet_alert("<strong>สิทธิ์ในการเห็นคุณวุฒิวิชาชีพนี้ มีในระบบแล้ว!!!</strong>");
            } else {
                success_alert("<strong>บันทึกข้อมูลเรียบร้อยแล้ว</strong>");
                $("#occ_level_id").val("").trigger("change");
                showAocc(1);
            }
        },
    });
}

function showAocc(prm_page_no) {
    $.ajax({
        url: "../../settings/UserRole/searchAocc",
        method: "GET",
        data: {
            page_no: prm_page_no,
            per_page: "10",
            username: $("#txt_username").val()
        },
        success: function(data) {
            $("#showdata_aocc").empty();
            $("#showdata_aocc").html(data);
        },
    });
}
</script>