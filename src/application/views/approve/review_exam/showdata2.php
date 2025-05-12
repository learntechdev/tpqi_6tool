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
                <!--style="background-color:#EBDEF0"-->
                <th class="text-center" style="width: 5%;font-weight:bold;">ลำดับ</th>
                <th class="text-center" style="width: 35%;font-weight:bold;">คุณวุฒิวิชาชีพ</th>
                <th class="text-center" style="width: 10%;font-weight:bold;">เครื่องมือประเมิน</th>
                <th class="text-center" style="width: 20%;font-weight:bold;">แม่แบบ</th>
                <th class="text-center" style="width: 10%;font-weight:bold;">วันที่สร้าง</th>
                <th class="text-center" style="width: 10%;font-weight:bold;">ดูข้อสอบ</th>
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
                    <?= (($dataList["pageNo"] - 1) * $dataList["perPage"]) + $i; ?>
                </td>
                <td class="text-wrap tbl-td-content">
                    <?= $this->SharedModel->get_occlevelname($v['occ_level_id'])["levelName"]; ?>
                </td>
                <td class="text-center">
                    <?= $this->SharedModel->get_tool_type_name($v['tool_type'])['name']; ?>
                </td>
                <td class="text-left">
                    <strong><?= $this->SharedModel->get_exam_type($v['exam_type'])["name"]; ?></strong><br />
                    <?php // $this->SharedModel->get_template_type($v['template_type'])["name"]; 
                            ?>
                    <span style="font-size:14px;font-style:italic;color:green">รหัสชุดข้อสอบ
                        <?= $v['template_id'] ?></span>
                </td>
                <td class="text-center">
                    <?= $this->BaseModel->dateToThai($v['created_date'], false) ?>
                </td>
                <td class="text-center">

                    <button type="button" class="btn btn-primary btn-bg btn-md" id="btn_preview_exam"
                        name="btn_preview_exam"
                        onClick="preview_exam('<?= $v['template_id'] ?>','<?= $v['tool_type'] ?>','<?= $v['template_type'] ?>','<?= $v['exam_type'] ?>')">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </button>

                </td>
                <td class="text-center">
                    <?php if ($v['exam_status'] == "") { ?>
                    <button type="button" class="btn btn-success btn-bg" id="btn_approve" name="btn_approve"
                        onClick="update_approve_status('1','<?= $v['template_id'] ?>','<?= $v['tool_type'] ?>')">อนุมัติ
                    </button>
                    <button type="button" class="btn btn-warning btn-bg" id="btn_notapprove" name="btn_notapprove"
                        onClick="update_approve_status('2','<?= $v['template_id'] ?>','<?= $v['tool_type'] ?>')">ไม่อนุมัติ
                    </button>
                    <?php } else {
                                if ($v['exam_status'] == "1") { ?>
                    <button type="button" class="btn btn-circle btn-success btn-xs mb-5"><i
                            class="fa fa-check"></i></button>
                    <?php } else if ($v['exam_status'] == "2") { ?>
                    <button type="button" class="btn btn-circle btn-danger btn-xs mb-5"><i
                            class="fa fa-remove"></i></button>
                    <?php }
                            } ?>
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