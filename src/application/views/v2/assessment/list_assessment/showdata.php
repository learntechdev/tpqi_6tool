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
                <th class="text-center" style="width: 10%;font-weight:bold;">รอบสอบ</th>
                <th class="text-center" style="width: 30%;font-weight:bold;">ชื่อองค์กรรับรอง/คุณวุฒิวิชาชีพ</th>
                <th class="text-center" style="width: 20%;font-weight:bold;">เครื่องมือประเมิน</th>
                <!-- <th class="text-center" style="width: 10%;font-weight:bold;">ชุดข้อสอบ</th>-->
                <th class="text-center" style="width: 20%;font-weight:bold;">สถานที่จัดสอบ</th>

                <th class="text-center" style="width: 10%;font-weight:bold;">วันที่จัดสอบ</th>
                <th class="text-center" style="width: 10%;font-weight:bold;">ประเมินผล</th>
            </tr>
        </thead>
        <?php
$i = 0;
    foreach ($dataList["result"] as $key => $v) {
        $i++;

        $ass_status = $v['assessment_status'] == 0 ? "ยังไม่ได้ประเมิน" : "ประเมินผลแล้ว";
        $ass_status_color = $v['assessment_status'] == 0 ? "#0C7CF3" : "#05842F";
        ?>
        <tbody>
            <tr>
                <td class="text-center">
                    <?=(($dataList["pageNo"] - 1) * $dataList["perPage"]) + $i;?>
                    <input type="hidden" value="<?=$v['tpqi_exam_no']?>" />
                </td>
                <td class="text-center wrapword">
                    <?=$v['tpqi_exam_no']?>
                </td>
                <td class="text-wrap tbl-td-content">
                    <?=$v['org_name']?>
                    <br />
                    <span style="font-weight:bold"> <?=$v['occ_level_name']?></span>
                </td>
                <td class="text-wrap tbl-td-content">
                    <?=$this->SharedModel->get_tool_type_name($v['asm_tool_type'])['name'];?>
                </td>
                <!--<td class="text-center">
                    <?=$v['exam_template_id']?>
                </td>-->
                <td class="text-center wrapword">
                    <?=$v['place']?>
                </td>

                <td class="text-center">
                    <?=$this->BaseModel->dateToThai($v['start_date'], false)?>
                </td>
                <!-- <td class="text-center">
                    <span style="color:<?=$ass_status_color?>"><strong><?=$ass_status?></strong></span>
                </td> -->
                <td class="text-center">
                    <?php if ($v['assessment_status'] == "0" || $v['assessment_status'] == "") {?>
                    <button type="button" class="btn btn-primary" id="btn_operation" name="btn_operation"
                        onClick="goto_applicant_assessment('<?=$v['org_id']?>','<?=$v['occ_level_name']?>','<?=$v['exam_template_id']?>','<?=$v['tpqi_exam_no']?>','<?=$v['asm_tool_type']?>','<?=$v['occ_level_id']?>')">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </button>
                    <?php }?>
                </td>
            </tr>

        </tbody>
        <!-- alert-->
        <div class=" col-md-12" sytle="display:none">


        </div>
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

<script type="text/javascript" src="<?=base_url();?>assets/custom_js/assessment/list_assessment.js?<?=date("YmdHis")?>">
</script>