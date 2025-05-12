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
                    <th class="text-center" style="width: 20%;font-weight:bold;">เครื่องมือประเมิน</th>
                    <th class="text-center" style="width: 40%;font-weight:bold;">ชื่อองค์กรรับรอง/คุณวุฒิวิชาชีพ</th>
                    <th class="text-center" style="width: 15%;font-weight:bold;">วันที่จัดสอบ</th>
                    <th class="text-center" style="width: 10%;font-weight:bold;">สถานะ</th>
                    <th class="text-center" style="width: 10%;font-weight:bold;">ทำแบบประเมิน</th>
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
                            <?= (($dataList["pageNo"] - 1) * $dataList["perPage"]) + $i; ?>
                            <input type="hidden" value="<?= $v['exam_schedule_id'] ?>" />
                        </td>
                        <td class="text-center">
                            <?= $v['tpqi_exam_no'] ?>
                        </td>
                        <td class="text-wrap tbl-td-content">
                            <?= $this->SharedModel->get_tool_type_name($v['asm_tool_type'])['name']; ?>
                        </td>
                        <td class="text-wrap tbl-td-content">
                            <?= $v['org_name'] ?>
                            <br />
                            <span style="font-weight:bold"> <?= $v['occ_level_name'] ?></span>
                        </td>
                        <td class="text-center">
                            <?= $this->BaseModel->dateToThai($v['start_date'], false)
                            ?> ถึง<br />
                            <?= $this->BaseModel->dateToThai($v['end_date'], false)
                            ?>
                        </td>
                        <td class="text-center">
                            <?= $v['chk_upload'] > 0 ? '<span style="color:green">อัพโหลดไฟล์แล้ว</span>' : '<span style="color:#FFAA01">ยังไม่ได้อัพโหลดไฟล์</span>' ?>
                        </td>
                        <!-- <td class="text-center">
							<span style="color:<?= $ass_status_color ?>"><strong><?= $ass_status ?></strong></span>
						</td> -->
                        <td class="text-center">
                            <?php if ($v['chk_upload'] == "0") { ?>
                                <button type="button" class="btn btn-primary" id="btn_operation" name="btn_operation" onClick="goto_assessment('<?= $v['exam_template_id'] ?>','<?= $v['tpqi_exam_no'] ?>','<?= $v['app_id'] ?>')">
                                    <i class="fa fa-edit" aria-hidden="true">อัพโหลด</i>
                                </button>
                            <?php } else { ?>
                                <?php if ($v['assessment_status'] != 1) { ?>
                                    <button type="button" class="btn btn-warning" id="btn_operation" name="btn_operation" onClick="edit_file_upload('<?= $v['exam_template_id'] ?>','<?= $v['tpqi_exam_no'] ?>','<?= $v['app_id'] ?>')">
                                        <i class="fa fa-edit" aria-hidden="true"> แก้ไข</i>
                                    </button>
                                    <br />
                                    <span style="color:#F9A600"> รอตรวจสอบ</span><br>

                                <?php } else { ?>
                                    <span style="color:green"> <i class="fa fa-check-circle"></i> ประเมินผลแล้ว</span>
                                <?php } ?>
                            <?php     } ?>


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

<script type="text/javascript" src="<?= base_url(); ?>assets/custom_js/assessment/person_assessment/list_assessment.js?<?= date("YmdHis") ?>">
</script>