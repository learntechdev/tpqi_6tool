<div>
    <div><strong> รายการแฟ้มสะสมผลงาน</strong></div>
    <form id="form_assessment" name="form_assessment">
        <?php
        if ($assessment_detail != '') { ?>
        <table class="table table-bordered">
            <thead>
                <tr style="background-color:#cccccc;">
                    <th width="80%" class="text-center" rowspan="2" colspan="3">
                        <strong>รายการเอกสาร</strong>
                    </th>
                    <th width="10%" colspan="2" class="text-center">คำตอบ</th>
                </tr>
                <tr style="background-color:#cccccc;">
                    <th width="5%" class="text-center"><b>มี</b>
                    </th>
                    <th width="5%" class="text-center"><b>ไม่มี</b>
                    </th>
                </tr>
            </thead>

            <?php
                $i = 0;
                $j = 1;
                $maintopic_ = '';
                foreach ($assessment_detail as $row) {
                    $j++;
                ?>
            <tbody>
                <?php if ($maintopic_ != $row->maintopic_id) { ?>
                <tr>
                    <td colspan="6" style="background-color:#f1f1f1;">
                        <strong> <?= $i + 1 ?>.<?= $row->maintopic ?></strong>
                    </td>
                </tr>

                <?php
                            $maintopic_ = $row->maintopic_id;
                            $j = 1;
                        } ?>


                <tr>
                    <td colspan="1">
                        <?= $j ?>)
                        <?= $row->subtopic ?>


                        <input type="hidden" class="form-control" style=" background-color: #fff "
                            name="detail[<?= $i ?>][exam_person_portfolio_id]" value="<?= $row->id ?>" placeholder="" />
                        <input type="hidden" class="form-control" style=" background-color: #fff "
                            name="detail[<?= $i ?>][uoc_code]" value="<?= $row->tp_uoc_code ?>" placeholder="" />
                        <input type="hidden" class="form-control" style=" background-color: #fff "
                            name="detail[<?= $i ?>][maintopic_id]" value="<?= $row->maintopic_id ?>" placeholder="" />
                        <input type="hidden" class="form-control" style=" background-color: #fff "
                            name="detail[<?= $i ?>][subtopic_id]" value="<?= $row->subtopic_id ?>" placeholder="" />

                        <input type="hidden" class="form-control" style=" background-color: #fff "
                            name="detail[<?= $i ?>][score]" value="" placeholder="" />
                    </td>

                    <td width="10%" colspan="2" class="text-center">
                        <a href="<?= base_url() . 'portfolio_file/' . $_POST["app_id"] . '/' . $row->file ?>"
                            class="btn btn-success" target="_blank"> ดาวน์โหลด </a>
                    </td>

                    <td colspan="1">
                        <input style=" width: 100%; height: 1.5em; margin-top:10px" type="radio" id="<?= $row->id ?>"
                            name="detail[<?= $i ?>][file_status]" value="1" checked>
                    </td>

                    <td colspan="1">
                        <input style=" width: 100%; height: 1.5em; margin-top:10px" type="radio" id="<?= $row->id ?>"
                            name="detail[<?= $i ?>][file_status]" value="0">
                    </td>
                </tr>
            </tbody>
            <?php $i++;
                } ?>

        </table>
        <br>
        <div class="col-md-12">
            <b>สรุปผลการประเมิน</b>
        </div>

        <div class="col-md-12">
            &nbsp;&nbsp; <input type="radio" name="assessment_status" value="1" checked> ผ่าน &nbsp; &nbsp;
            <input type="radio" name="assessment_status" value="0"> ไม่ผ่าน
        </div>
    </form>
</div>





<form id="form" name="form">
    <br />
    <div class="row">
        <div class="col-md-12">
            <?php require_once dirname(__FILE__) . "../../../shared/assessment_result.php"; ?>
        </div>
    </div>



    <div class="row">
        <div class="col-md-12 text-center">
            <button type="button" class="btn btn-primary" id="btn_save">
                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                <strong>บันทึก</strong> </button>
            &nbsp;
            <button type="button" class="btn btn-danger" id="btn_cancel" name="btn_cancel">
                <i class="fa fa-repeat" aria-hidden="true"></i>
                <strong>ยกเลิก</strong> </button>
            &nbsp;
            <button type="button" class="btn btn-success" id="btn_confirm_assessment" name="btn_confirm_assessment">
                <i class="fa fa-check-circle" aria-hidden="true"></i>
                <strong>ยืนยันส่งผลการสอบ</strong>
            </button>
        </div>
    </div>
</form>

<?php } else { ?>

<div class="text-center">
    <span style="color:red;font-size:18px">
        <b>== ไม่พบข้อมูลการทำแบบประเมิน ==</b>
    </span>
</div>
<?php } ?>

<script>
$('.assessment-result-form').hide()
</script>