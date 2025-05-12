<style type="text/css">
.printme {
    display: none;
}

@media print {
    .no-printme {
        display: none;
    }

    .printme {
        display: block;
    }
}
</style>
<div class="accordian-body collapse" id="template<?= $i ?>" style="padding:5px">
    <div>
        <?php
				
        $rs = $this->ExamlibraryModel->get_template($occ_level_id, $tool_type);

        if (count($rs) > 0) {
            $idx = 0;
            $str_status = "";
            $color = "";
            foreach ($rs as $v) {
                $idx++;
                if (($v->send_approve == "" && $v->exam_status == "") ||
                    ($v->send_approve == "0" && $v->exam_status == "0")
                ){
                    $str_status = "ยังไม่ได้ส่งข้อสอบ";
                    $color = "red";
                } else if ($v->exam_status == "1") {
                    $str_status = "อนุมัติ";
                    $color = "green";
                } else if ($v->exam_status == '2') {
                    $str_status = "ไม่อนุมัติ";
                    $color = "red";
                } else {
                    $str_status = "รออนุมัติ";
                    $color = "black";
                }
        ?>

        <div class="row">
            <div class="col-md-9">
                &nbsp;&nbsp;<?= $v->template_id ?>&nbsp;&nbsp;
                <strong> ข้อสอบชุดที่ <?= $idx ?> : </strong>
                <?= $this->MasterDataModel->get_template_type_name($v->template_type)['name'] ?>
                &nbsp;&nbsp; ( จัดทำ &nbsp; <?= $this->BaseModel->dateToThai($v->created_date, false) ?> )
                &nbsp;&nbsp; &nbsp;&nbsp; สถานะ :
                <span style="color:<?= $color ?>"><strong>
                        <?= $str_status; ?>
                    </strong> </span>
                &nbsp;&nbsp; &nbsp;&nbsp;
                <?php if ($v->exam_status == "2") { ?>
                <button class="btn btn-info btn-xs" onClick="fetch_reasondisapprove(<?= $v->template_id ?>)">
                    เหตุผลของการไม่อนุมัติ</button>
                <?php } ?>
            </div>

            <div class="col-md-2">
                <div class="btn-group  btn-group-sm" role="group">
                    <button type="button" title="ดูข้อสอบ" alt="ดูข้อสอบ" class="btn btn-primary" id="btn_exam_preview"
                        name="btn_exam_preview"
                        onClick="exam_preview(<?= $v->template_id ?>,<?= $_GET['tool_type'] ?>,<?= $v->template_type ?>,<?= $v->exam_type ?>)">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </button>
           <!--         <button type="button" title="คัดลอก" alt="คัดลอก" class="btn btn-secondary"
                        onClick="edit(<?//= $v->template_id ?>,<?//= $_GET['tool_type'] ?>,'<?//= $v->contract_no ?>','copy')">
                        <i class="fa fa-copy" aria-hidden="true"></i>
                    </button>   -->
					
					<?php if ($v->exam_status == "") { ?>
                    <button type="button" class="btn btn-success btn-bg" id="btn_approve" name="btn_approve"
                        onClick="update_approve_status('1','<?= $v->template_id ?>','<?= $_GET['tool_type'] ?>')">อนุมัติ
                    </button>
                    <button type="button" class="btn btn-warning btn-bg" id="btn_notapprove" name="btn_notapprove"
                        onClick="update_approve_status('2','<?= $v->template_id ?>','<?= $_GET['tool_type'] ?>')">ไม่อนุมัติ
                    </button>
                    <?php } else {
                                if ($v->exam_status == "1") { ?>
                    <button type="button" class="btn btn-circle btn-success btn-xs mb-5"><i
                            class="fa fa-check"></i></button>
                    <?php } else if ($v->exam_status == "2") { ?>
                    <button type="button" class="btn btn-circle btn-danger btn-xs mb-5"><i
                            class="fa fa-remove"></i></button>
                    <?php }
                            } ?>
                    <?php
            //                if ($v->send_approve != "1" || $v->exam_status == '2') { ?>
           <!--         <button type="button" title="แก้ไข" alt="แก้ไข" class="btn btn-info"
                        onClick="edit(<?//= $v->template_id ?>,<?//= $_GET['tool_type'] ?>,'<?//= $v->contract_no ?>','edit')">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </button>
                    <button type="button" title="ลบ" alt="ลบ" class="btn btn-danger"
                        onClick="cancel(<?//= $v->template_id ?>)">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </button>   -->
                   <?php // }  ?>
                </div>
            </div>
        </div>
        <?php
            }
        }
		
        ?>
    </div>
</div>

<div id="div_print" style="display: none;"></div>

<!-- alert-->
<div class="col-md-12" sytle="display:none">
    <?php require_once dirname(__FILE__) . "../../alert/modal_alert.php"; ?>
    <?php require_once dirname(__FILE__) . "../../alert/modal_confirm.php"; ?>
    <?php require_once dirname(__FILE__) . "../../shared/r_reason_disapprove.php"; ?>
</div>