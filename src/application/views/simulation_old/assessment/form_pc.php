<div class="">
    <strong>การประเมินผล</strong>
</div>
<?php
if (is_array($template_detail)) {
    $tmp_uoc_code = "";
    $tmp_eoc_code = "";
    foreach ($template_detail as $v_detail) {
        $uoc_code = $this->SharedModel->get_uocname($v_detail->uoc_code);
        ?>

<?php
if ($tmp_uoc_code != $v_detail->uoc_code) {?>
<div class="col-md-12">
    <label for=""><strong>
            <?php echo $uoc_code["stdCode"] . " " . $uoc_code["stdName"]; ?></label>
    </strong>
</div>
<?php
$tmp_uoc_code = $v_detail->uoc_code;
        }?>

<table border="1" width="100%" style="border-collapse: collapse;">
    <thead>
        <tr style="background:#CFCFCF">
            <th width="25%" style="text-align:center;font-weight:bold">เกณฑ์การประเมิน
            </th>
            <th width="25%" style="text-align:center;font-weight:bold">คำถาม
            </th>
            <th width="35%" style="text-align:center;font-weight:bold">แนวทางคำตอบ
            </th>
            <th width="15%" style="text-align:center;font-weight:bold">การตัดสิน
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
if ($tmp_eoc_code != $v_detail->eoc_code) {
            $eoc_code = $this->SharedModel->get_eocname($v_detail->eoc_code);
            ?>
        <tr>
            <td colspan="4" style="background-color:#F1F1F1">
                <strong>
                    <?php echo $eoc_code["stdCode"] . " " . $eoc_code["stdName"]; ?>
                </strong>
            </td>
        </tr>
        <?php
$tmp_eoc_code = $v_detail->eoc_code;
        }?>
        <tr>
            <td>
                <?php echo $v_detail->pc_detail; ?>
            </td>
            <td>
                <?php echo $v_detail->question; ?>
            </td>
            <td>
                <?php echo $v_detail->guide_answer; ?>
            </td>
            <td>
                <input type="text" class="col-md-6 form-control" id="list[<?=$v_detail->pc_code?>][eoc_code]"
                    name="list[<?=$v_detail->pc_code?>][eoc_code]" value="<?=$v_detail->eoc_code?>" />
                <input type="text" class="col-md-6 form-control" id="list[<?=$v_detail->pc_code?>][pc_code]"
                    name="list[<?=$v_detail->pc_code?>][pc_code]" value="<?=$v_detail->pc_code?>" />
                <div class="row col-md-12">
                    <label class="col-md-6 col-form-label">
                        <input type="radio" id="exam_status0" name="list[<?=$v_detail->pc_code?>][exam_status]"
                            value="1" Checked />
                        ผ่าน
                    </label>
                    <label class="col-md-6 col-form-label">
                        <input type="radio" id="exam_status1" name="list[<?=$v_detail->pc_code?>][exam_status]"
                            value="0" />
                        ไม่ผ่าน
                    </label>
                </div>
                <div class="row col-md-12">
                    <label class="col-md-6 col-form-label">คะแนน</label>
                    <input type="number" class="col-md-6 form-control" id="list[<?=$v_detail->pc_code?>][score]"
                        name="list[<?=$v_detail->pc_code?>][score]" />
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <?php $this->load->view("richtext/richtext",
            array(
                "id" => "list[$v_detail->pc_code][answer]",
            ));?>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="text-right">
                <div id="div_sound<?=$v_detail->template_detail_id?>">
                </div>
            </td>
            <td colspan="1" class="text-center">
                <div class="btn-group  btn-group-sm " role="group">
                    <button style="padding:7px" type="button" class="btn btn-warning" id="btn_record" name="btn_record"
                        onClick="show_dialog_recorder('<?=$v_detail->template_detail_id?>','<?=$v_detail->uoc_code?>','<?=$v_detail->pc_code?>','<?=$v_detail->pc_detail?>','<?=$_POST['app_id']?>')">
                        <i class="fa fa-microphone" aria-hidden="true"></i> บันทึกเสียง</button>
                </div>
            </td>
        </tr>

    </tbody>
</table>
<?php
}
}
?>
<br />