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
                <th class="text-center" style="width: 5%;font-weight:bold;">ลำดับ</th>
                <th class="text-center" style="width: 15%;font-weight:bold;">รอบสอบ</th>
                <th class="text-center" style="width: 20%;font-weight:bold;">วันที่ประเมิน</th>
                <th class="text-left" style="width: 30%;font-weight:bold;">คุณวุฒิวิชาชีพ</th>
                <th class="text-center" style="width: 20%;font-weight:bold;">เครื่องมือประเมิน</th>
                <th class="text-center" style="width: 5%;font-weight:bold;">จำนวนผู้สอบ <br />(คน)</th>
                <th class="text-center" style="width: 5%;font-weight:bold;">สอบผ่าน <br />(คน)</th>
                <th class="text-center" style="width: 5%;font-weight:bold;">สอบไม่ผ่าน <br />(คน)</th>
                <th class="text-center" style="width: 5%;font-weight:bold;"></th>
            </tr>
        </thead>
        <?php
            $i = 0;
            $asm_tool = $this->MasterDataModel->tool_type_array();

            foreach ($dataList["result"] as $key => $v) {
                $i++;
                $tool_type = $v['tool_type'];

                $sql = "SELECT occ_level_name FROM exam_schedule
        WHERE tpqi_exam_no =  '" . $v['exam_schedule_id'] . "'
        AND  asm_tool_type =  '" . $v['tool_type'] . "'
        LIMIT 0,1   ";

                $query = $this->db->query($sql);
                $result = $query->row_array();
                $occ_level_name = $result["occ_level_name"];
            ?>
        <tbody>
            <tr>
                <td class="text-left">
                    <?= (($dataList["pageNo"] - 1) * $dataList["perPage"]) + $i; ?>
                </td>
                <td class="text-center">
                    <?= $v['exam_schedule_id'] ?>
                </td>
                <td class="text-center">
                    <?= $this->BaseModel->dateToThai($v['assessment_date'], false) ?>
                </td>

                <td class="text-left text-wrap tbl-td-content">
                    <?= $occ_level_name ?>
                </td>
                <td class="text-center">
                    <?= $asm_tool[$tool_type]['name'] ?>

                </td>
                <td class="text-right">
                    <?= number_format($v['nums_user']) ?>
                </td>
                <td class="text-right">
                    <?= number_format($v['nums_pass']) ?>
                </td>
                <td class="text-right">
                    <?= number_format($v['nums_no_pass']) ?>
                </td>
                <td class="text-right">
                    <button type="button" class="btn btn-primary btn-bg btn-md" id="btn_detail"
                        onClick="detailRoundExamResult('<?= $v['exam_schedule_id'] ?>','<?= $v['tool_type'] ?>')">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </button>
                </td>
            </tr>
        </tbody>
        <?php

            } ?>
    </table>

</div>


<?php }

if (!empty($dataList)) {
    $this->load->view("pagination/show_pagination", array(
        "dataList" => $dataList,
    ));
}
?>