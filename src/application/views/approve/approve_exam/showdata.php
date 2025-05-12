<?php if (number_format($dataList["numRowsAll"]) == 0) {?>
<div style="font-weight:bold;color:red;text-align:center">
    <br> == ไม่พบข้อมูล ==
</div>
<?php }?>
<?php if (is_array($dataList)) {?>
<div class="table-responsive">
    <table class="table text-nowrap table-bordered">
        <thead class="bg-primary">
            <tr>
                <th class="text-center" style="width: 5%;font-weight:bold;">ลำดับ</th>
                <th class="text-center" style="width: 50%;font-weight:bold;">ชื่อองค์กรรับรอง/คุณวุฒิวิชาชีพ</th>
                <th class="text-center" style="width: 10%;font-weight:bold;">เครื่องมือประเมิน</th>
                <th class="text-center" style="width: 20%;font-weight:bold;">สถานที่จัดสอบ</th>
                <th class="text-center" style="width: 10%;font-weight:bold;">วันที่จัดสอบ</th>
                <th class="text-center" style="width: 10%;font-weight:bold;">สถานะ</th>
            </tr>
        </thead>
        <?php
$i = 0;
    foreach ($dataList["result"] as $key => $v) {
        $i++;
        ?>
        <tbody>
            <tr>
                <td class="text-center">
                <?=(($dataList["pageNo"] - 1) * $dataList["perPage"]) + $i;?>
                    <input type="hidden" value="<?=$v['exam_schedule_id']?>" />
                </td>
                <td class="text-wrap tbl-td-content">
                    <?=$v['orgName']?>
                    <br />
                    <span style="font-weight:bold"><?=$v['occ_level_name']?></span>
                </td>
                <td class="text-center">
                    <?=$this->SharedModel->get_tool_type_name($v['asm_tool_type'])['name'];?>
                </td>
                <td class="text-center wrapword">
                    <?=$v['place']?>
                </td>
                <td class="text-center">
                    <?=$this->BaseModel->dateToThai($v['start_date'], false)?>
                </td>
                <td class="text-center">
                    <?php if ($v["status"] == 5) {?>
                    <button type="button" class="btn btn-primary btn-bg" id="btn_approve" name="btn_approve"
                        onClick="show_criteria('<?=$v['occ_level_id']?>','<?=$v['occ_level_name']?>','<?=$v['place']?>','<?=$this->BaseModel->dateToThai($v['start_date'], false)?>','<?=$v['exam_schedule_id']?>','<?=$v['status']?>','<?=$v['asm_tool_type']?>','<?=$v['exam_template_id']?>')">ตรวจสอบชุดข้อสอบ
                    </button>
                    <?php }if ($v["status"] == 7) {?>
                    <button type="button" class="btn btn-circle btn-success btn-xs mb-5"><i
                            class="fa fa-check"></i></button>

                    <?php }if ($v["status"] == 3 && $v["exam_template_id"] != "") {?>
                    <button type="button" class="btn btn-circle btn-danger btn-xs mb-5"><i
                            class="fa fa-remove"></i></button>
                    <?php }?>
                </td>
            </tr>
        </tbody>
        <?php }?>
    </table>

</div>
<?php }

if (!empty($dataList)) {
    $this->load->view("pagination/show_pagination", array(
        "dataList" => $dataList,
    ));
}
?>

<div class=" col-md-12" sytle="display:none">
    <?php
require_once dirname(__FILE__) . "../../../criteria_asm/form_approve_exam.php";?>
</div>