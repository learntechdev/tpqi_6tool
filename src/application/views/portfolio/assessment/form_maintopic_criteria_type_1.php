<div>
    <form id="form_assessment" name="form_assessment">

        รายการแฟ้มสะสมผลงาน <?=$this->MasterDataModel->get_occ_name($occ_level_id)?>
        <?php
if ($assessment_detail != '') {?>
        <table class="table table-bordered">
            <thead>

                <tr style="background-color:#cccccc;">
                    <th scope="col" class="text-center" style="width:50%" colspan="3" rowspan="2">
                        <b>รายการเอกสาร</b>
                    </th>
                    <th scope="col" class="text-center" colspan="3"><b>คะแนนที่ได้</b>
                    </th>
                </tr>


            </thead>
            <?php
$i = 0;
    $maintopic_ = '';
    foreach ($assessment_detail as $row) {

        $n = 0;
        ?>


            <tbody>
                <?php if ($maintopic_ != $row->maintopic_id) {?>
                <tr>
                    <td colspan="6" style="background-color:#f1f1f1;">
                        <b><?=$i + 1?>.<?=$row->maintopic?></b>
                    </td>
                </tr>
                <?php }?>
                <?php $maintopic_ = $row->maintopic_id;?>

                <tr>
                    <td colspan="1">
                        <b><?=$row->tp_order_line?>) <?=$row->subtopic?> </b>
                        <input type="hidden" class="form-control" style=" background-color: #fff "
                            name="detail[<?=$i?>][exam_person_portfolio_id]" value="<?=$row->id?>" placeholder="" />

                        <input type="hidden" class="form-control" style=" background-color: #fff "
                            name="detail[<?=$i?>][uoc_code]" value="" placeholder="" />
                        <input type="hidden" class="form-control" style=" background-color: #fff "
                            name="detail[<?=$i?>][maintopic_id]" value="<?=$row->maintopic_id?>" placeholder="" />
                        <input type="hidden" class="form-control" style=" background-color: #fff "
                            name="detail[<?=$i?>][subtopic_id]" value="<?=$row->subtopic_id?>" placeholder="" />


                        <input type="hidden" class="form-control" style=" background-color: #fff "
                            name="detail[<?=$i?>][file_status]" value="" placeholder="" />


                    </td>

                    <td colspan="2" style="width:10%" class="text-center">
                        <a href="<?=base_url() . 'portfolio_file/' . $_POST["app_id"] . '/' . $row->file?>"
                            class="btn btn-success" target="_blank"> ดาวน์โหลด </a>
                    </td>




                    <td colspan="1" style="width:15%" class="text-center">
                        <input type="number" id="<?=$row->id?>" class="form-control score" name="detail[<?=$i?>][score]"
                            value="" min="0" onKeyup="calculateScore()" onChange="calculateScore()">
                    </td>


                </tr>
            </tbody>


            <?php $i++;}?>
        </table>
    </form>
</div>


<form id="form" name="form">
    <br />
    <div class="row">
        <div class="col-md-12">
            <?php require_once dirname(__FILE__) . "../../../shared/assessment_result.php";?>
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

<?php } else {?>
<div class="text-center">
    <span style="color:red;font-size:18px">
        <b>== ไม่พบข้อมูลการทำแบบประเมิน ==</b>
    </span>
</div>

<?php }?>