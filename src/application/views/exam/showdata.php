<?php if (number_format($dataList["numRowsAll"]) == 0) { ?>
<div style="font-weight:bold;color:red;text-align:center">
    <br> == ไม่พบข้อมูล ==
</div>
<?php } ?>
<?php if (is_array($dataList)) { ?>
<div class="table-responsive">
    <table class="table text-nowrap table-bordered">
        <thead class="bg-primary">
            <tr>
                <th class="text-center" style="width: 3%;font-weight:bold;">ลำดับ</th>
                <th class="text-center" style="width: 50%;font-weight:bold;">ชื่อองค์กรรับรอง/คุณวุฒิวิชาชีพ</th>
                <th class="text-center" style="width: 10%;font-weight:bold;">เครื่องมือประเมิน</th>
                <th class="text-center" style="width: 20%;font-weight:bold;">สถานที่จัดสอบ</th>
                <th class="text-center" style="width: 8%;font-weight:bold;">วันที่จัดสอบ</th>
                <th class="text-center" style="width: 5%;font-weight:bold;">สถานะข้อสอบ</th>
                <th class="text-center" style="width: 5%;font-weight:bold;">นำไปใช้งาน</th>
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
                    <?= (($dataList["pageNo"] - 1) * $dataList["perPage"]) + $i; ?>
                    <input type="hidden" value="<?= $v['exam_schedule_id'] ?>" />

                </td>
                <td class="text-wrap tbl-td-content">
                    <?= $v['org_name'] ?>
                    <br />
                    <span style="font-weight:bold"> <?= $v['occ_level_name'] ?></span>
                </td>
                <td class="text-wrap tbl-td-content">
                    <?= $this->SharedModel->get_tool_type_name($v['asm_tool_type'])['name']; ?>
                </td>
                <td class="text-left wrapword">
                    <?= $v['place'] ?>
                </td>
                <td class="text-center">
                    <?= $this->BaseModel->dateToThai($v['start_date'], false) ?>
                </td>
                <td class="text-center">
                    <?php
                            $exam_used = $v['exam_used'] == 0 ? "ยังไม่ได้นำไปใช้งาน" : "นำไปใช้งานแล้ว";
                            $exam_used_color = $v['exam_used'] == 0 ? "#0C7CF3" : "#05842F";
                            ?>
                    <span style="color:<?= $exam_used_color ?>"><strong><?= $exam_used ?></strong></span>
                </td>
                <td class="text-center">
                    <div class="btn-group  btn-group-sm" role="group">
                        <?php if ($v['exam_used'] != '1') { ?>
                        <button type="button" class="btn btn-primary btn-sm" id="btn_print" name="btn_print"
                            onClick="exam_print('<?= $v['exam_template_id'] ?>','<?= $v['asm_tool_type'] ?>','<?= $v['exam_schedule_id'] ?>')">
                            <i class="fa fa-print" aria-hidden="true"></i></button>

                        <?php } ?>
                    </div>
                </td>
            </tr>
        </tbody>
        <!-- alert-->
        <div class=" col-md-12" sytle="display:none">
        </div>
        <?php } ?>
    </table>
</div>
<?php }

if (!empty($dataList)) {
    $this->load->view("pagination/show_pagination", array(
        "dataList" => $dataList,
    ));
}
?>