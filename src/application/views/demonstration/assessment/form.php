<?php //$this->load->view("breadcrumb/breadcrumb", $breadcrumb);
?>

<div class="content-header">
    <h3>
        บันทึกผลการประเมิน (รายบุคคล) สาธิตการปฏิบัติงาน
    </h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="../../assessment/Assessment/index">ประเมินผล</a>
        </li>
        <li class=" breadcrumb-item">
            <a onClick="goto_applicant_assessment()" style="cursor: pointer;">แสดงรายชื่อผู้เข้ารับการประเมิน
            </a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#" style="color:red">บันทึกผลการประเมิน (รายบุคคล)
            </a>
        </li>
    </ol>
</div>

<input type="hidden" value="<?= base_url() ?>" name="base_url" id="base_url">

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="min-height:480px">
                <div class="card-body">
                    <form id="form" name="form">
                        <?php
                        $action = "";
                        if (isset($_POST['action'])) {
                            $action = $_POST['action'];
                        } else {
                            $action = "create";
                        }
                        ?>

                        <input type="hidden" class="form-control" id="action" name="action" value="<?= $action; ?>" />
                        <input type="hidden" id="app_id" name="app_id" value="<?= $_POST["app_id"] ?>">
                        <input type="hidden" id="template_id" name="template_id" value="<?= $_POST["template_id"] ?>">
                        <input type="hidden" id="exam_schedule_id" name="exam_schedule_id"
                            value="<?= $_POST["exam_schedule_id"] ?>">
                        <input type="hidden" id="occ_level_name" name="occ_level_name"
                            value="<?= $_POST["occ_level_name"] ?>">

                        <div>
                            <h3>
                                <strong>ข้อสอบ<?= $this->SharedModel->get_tool_type_name($_POST['tool_type'])['name']; ?>
                                </strong>
                            </h3>
                            <h4><?= $_POST['occ_level_name'] ?></h4>
                        </div>
                        <hr />

                        <div class="col-md-12">
                            <div class="row">
                                <?php
                                if (is_array($template)) {
                                    foreach ($template as $v) {
                                        // print_r($template);
                                ?>

                                <div class="col-md-7">
                                    <input type="hidden" class="form-control" id="percent_passexam"
                                        name="percent_passexam" value="<?= $v->exam_percent_score ?>" />
                                    <input type="hidden" id="occ_level_id" name="occ_level_id"
                                        value="<?= $v->occ_level_id ?>">
                                    <div class="">
                                        <label for="">คำอธิบายสำหรับเจ้าหน้าที่สอบ</label>
                                        <br />
                                        <?= $v->desc_for_examier; ?>
                                    </div>
                                    <br />
                                    <div class="">
                                        <?php if (trim($v->exam_time) != 0) { ?>
                                        <label for="">เวลาที่ใช้สำหรับการสอบ :</label>
                                        <?= $v->exam_time; ?> นาที
                                        <?php } ?>
                                    </div>

                                    <div class="">
                                        <?php if ($v->case_study != "") { ?>
                                        <label for="">กรณีศึกษา</label>
                                        <?= $v->case_study; ?>
                                        <?php } ?>
                                    </div>

                                    <div class="">
                                        <label for="">เกณฑ์การประเมิน </label>
                                        <?php
                                                if ($v->criteria_used_byexamier == 0) {
                                                    echo "ไม่กำหนดเกณฑ์";
                                                } else {
                                                    echo "<br/>ผู้ออกข้อสอบได้แนะนำการกำหนดเกณฑ์การประเมิน ดังนี้ " . "<br/> " . $v->description;
                                                }
                                                ?>
                                        <input type="hidden" id="criteria_used_byexamier" name="criteria_used_byexamier"
                                            value="<?= $v->criteria_used_byexamier ?>">
                                        <input type="hidden" class="form-control" id="criteria_max_score"
                                            name="criteria_max_score" value="<?= $v->max_score ?>" />
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="percent_passexam"
                                                name="percent_passexam" value="<?= $v->exam_percent_score ?>" />
                                        </div>
                                    </div>

                                    <div class="">
                                        <label for="">เกณฑ์การผ่านประเมิน :</label>
                                        <span class="badge badge-pill badge-primary">
                                            <?php echo round($v->exam_percent_score) ?> </span> เปอร์เซ็นต์
                                    </div>


                                    <?php
                                    }
                                }
                                    ?>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-left-violet-600">
                                        <div class="card-body">
                                            <div style="text-align:left">
                                                <label for="">รหัสผู้สมัคร :
                                                    <strong><?= $_POST["app_id"] ?></strong>
                                                </label>
                                            </div>

                                            <div style="text-align:left">
                                                <label for="">ชื่อ-นามสกุล :
                                                    <strong><?= $_POST["name"] ?></strong>
                                                </label>
                                            </div>
                                            <div style="text-align:left">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <!-- แสดงฟอร์มการประเมิน -->
                        <div class="row">
                            <?php
                            if ($v->criteria_used_byexamier == 0) {
                                $this->load->view("v2/assessment_result/longans/form_uoc_passornot");
                            } else {
                                $this->load->view("v2/assessment_result/longans/form_uoc");
                            }
                            ?>

                        </div>
                        <br />
                        <hr />
                        <?php if ($action == "create") { ?>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="button" class="btn btn-primary" id="btn_save">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                    <strong>บันทึก</strong> </button>
                                <button type="button" class="btn btn-secondary" onClick="goto_applicant_assessment()">
                                    <i class="fa fa-arrow-circle-left" style="color:#fff"></i>
                                    <strong>กลับ</strong>
                                </button>
                            </div>
                        </div>
                        <?php } else { ?>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="button" class="btn btn-secondary" onClick="goto_applicant_assessment()">
                                    <i class="fa fa-arrow-circle-left" style="color:#fff"></i>
                                    <strong>กลับ</strong>
                                </button>
                            </div>
                        </div>
                        <?php } ?>
                        <br />
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript"
    src="<?= base_url(); ?>assets/custom_js/demonstration/assessment_form.js?<?= date("YmdHis") ?>">
</script>