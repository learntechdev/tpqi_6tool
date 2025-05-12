<?php if (number_format($dataList["numRowsAll"]) == 0) { ?>
<div style="font-weight:bold;color:red;text-align:center">
    <br> == ไม่พบข้อมูล ==
</div>
<?php } ?>
<?php if (is_array($dataList)) { ?>
<div class="table-responsive">
    <?php if ($tool_type == '2') { ?>
    <div class="col-md-12">
        <strong>คำอธิบาย</strong>
    </div>
    <div class="col-md-12">

        <span><i class="fa-lg fa fa-check-circle" style="color:green"></i> หมายถึง
            ผู้เข้ารับการประเมินอัพโหลดหลักฐานเรียบร้อยแล้ว</span>
        <span><span><i class="fa-lg  fa fa-times-circle" style="color:red"></i></span> หมายถึง
            ผู้เข้ารับการประเมินยังไม่ได้อัพโหลดหลักฐาน</span>
    </div>
    <?php } ?>
    <br />
    <table class="table text-nowrap table-bordered">
        <thead class="bg-primary">
            <tr>
                <th class="text-center" style="width: 5%;font-weight:bold;">ลำดับ</th>
                <th class="text-center" style="width: 10%;font-weight:bold;">เลขที่สมัคร</th>
                <th class="text-center" style="width: 40%;font-weight:bold;">ชื่อ-นามสกุล</th>
                <th class="text-center" style="width: 15%;font-weight:bold;">เลขบัตรประชาชน</th>
                <th class="text-center" style="width: 20%;font-weight:bold;">วันที่สอบ</th>
                <?php if ($tool_type == '2') { ?>
                <th class="text-center" style="width: 20%;font-weight:bold;">หลักฐาน</th>
                <?php } ?>
                <th class="text-center" style="width: 20%;font-weight:bold;">สถานะ</th>
                <th class="text-center" style="width: 10%;font-weight:bold;">ประเมินผล</th>
            </tr>
        </thead>
        <?php
            $i = 0;
            foreach ($dataList["result"] as $key => $v) {
                $i++;
                $name = $v['initial_name'] . $v['name'] . " " . $v['lastname'];
            ?>
        <tbody>
            <tr>
                <td class="text-center">
                    <?= (($dataList["pageNo"] - 1) * $dataList["perPage"]) + $i; ?>
                    <input type="hidden" value="<?= $v['org_id'] ?>" />
                </td>
                <td class="text-left">
                    <?php echo $v['app_id'] ?>
                </td>
                <td class="text-left">
                    <?= $name ?>
                </td>
                <td class="text-center">
                    <?php echo $v['citizen_id'] ?>
                </td>
                <td class="text-center">
                    <?php
                            echo
                            $v['schedule_exam_date'] != "0000-00-00" ? $this->BaseModel->dateToThai($v['schedule_exam_date'], false) : "" ?>
                </td>
                <?php if ($tool_type == '2') { ?>
                <td class="text-center" style="font-size:medium">
                    <?php
                                $is_uploadevident = $this->AssessmentModel->is_uploadevident($v['exam_schedule_id'], $v['app_id']);
                                if ($is_uploadevident > 0) {
                                    echo "<span style='color:green'><i class='fa-lg fa fa-check-circle'></i></span>";
                                } else {
                                    echo "<span style='color:red'><i class='fa-lg  fa fa-times-circle'></i></span>";
                                }
                                ?>
                </td>
                <?php } ?>

                <td class="text-center">
                    <?php
                            $ass_status = $v['assessment_status'] == 0 ? "ยังไม่ได้ประเมิน" : "ประเมินผลแล้ว";
                            $ass_status_color = $v['assessment_status'] == 0 ? "#0C7CF3" : "#05842F";
                            ?>
                    <span style="color:<?= $ass_status_color ?>"><strong><?= $ass_status ?></strong></span>
                </td>
                <td class="text-center">
                    <?php
                            if ($v['assessment_status'] != "1") {

                                $classBtn = "";
                                if ($v['assessment_status'] != "1") {
                                    $classBtn = "btn btn-primary";
                                } else {
                                    $classBtn = "btn btn-warning";
                                } ?>
                    <button type="button" class="<?= $classBtn ?>" id="btn_operation" name="btn_operation"
                        onClick="goto_create_assessment('<?= $_POST['template_id'] ?>','<?= $v['app_id'] ?>','<?= $name ?>','<?= $v['asm_tool_type'] ?>','<?= $v['exam_schedule_id'] ?>','<?= $_POST['occ_level_name'] ?>','<?= $v['occ_level_id'] ?>')">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </button>
                    <?php }
                            ?>
                </td>
            </tr>
        </tbody>
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