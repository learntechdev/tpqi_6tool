<?php if (number_format($dataList["numRowsAll"]) == 0) { ?>
<div style="font-weight:bold;color:red;text-align:center">
    <br> == ไม่พบข้อมูล ==
</div>
<?php } ?>
<?php if (is_array($dataList)) { ?>
<div class="col-md-12">
    <span>
        <button type="button" class="btn btn-warning btn-sm">
            <i class="fa fa-print" aria-hidden="true"></i></button> หมายถึง ชุดคำถาม (สำหรับผู้เข้ารับการประเมิน)
    </span> &nbsp;&nbsp;
    <span><button type="button" class="btn btn-success btn-sm">
            <i class="fa fa-print" aria-hidden="true"></i></button> หมายถึง ชุดคำตอบ (สำหรับผู้ประเมิน)
        <span>
</div>
<div class="table-responsive" style="margin-top:5px">
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
                    <?php if ($v['exam_used'] != '1') { ?>
                    <div class="btn-group  btn-group-sm" role="group">
                        <button type="button" class="btn btn-warning btn-sm" id="btn_print" name="btn_print"
                            onClick="printDocs('<?= $v['exam_template_id'] ?>','<?= $v['asm_tool_type'] ?>','<?= $v['exam_schedule_id'] ?>','1')">
                            <i class="fa fa-print" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-success btn-sm" id="btn_print" name="btn_print_assessor"
                            onClick="printDocs('<?= $v['exam_template_id'] ?>','<?= $v['asm_tool_type'] ?>','<?= $v['exam_schedule_id'] ?>','2')">
                            <i class="fa fa-print" aria-hidden="true"></i></button>
                    </div>
                    <?php } ?>
                    <?php
                            //เช็คว่ามีเอกสารเพิ่มเติมหรือไม่?
                            $isdocs_exam = $this->SharedModel->getDocsFiles($v['exam_template_id']);
                            if ($isdocs_exam != 0) { ?>
                    <a data-toggle="modal" onclick="show_docsexam(<?= $v['exam_template_id'] ?>)">
                        <br />
                        เอกสารเพิ่มเติม</a>
                    <?php }
                            ?>
                </td>
            </tr>
        </tbody>
        <!-- alert-->
        <div class=" col-md-12" sytle="display:none">
        </div>
        <?php } ?>
    </table>
</div>
<!--modal เอกสารเพิ่มเติม -->
<div>
    <?php require_once dirname(__FILE__) . "../../../shared/modal_docsexam.php"; ?>
</div>

<div id="div_print" style="display: none;">
</div>

<?php }

if (!empty($dataList)) {
    $this->load->view("pagination/show_pagination", array(
        "dataList" => $dataList,
    ));
}
?>