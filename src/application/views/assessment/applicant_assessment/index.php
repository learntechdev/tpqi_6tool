<?php // $this->load->view("breadcrumb/breadcrumb",$breadcrumb); 
?>

<div class="content-header">
    <h3>แสดงรายชื่อผู้เข้ารับการประเมิน</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="../../assessment/Assessment/index">สรุปผลการประเมิน</a>
        </li>
        <li class=" breadcrumb-item">
            <a onClick="goto_applicant_assessment()" style="cursor: pointer;color:red">แสดงรายชื่อผู้เข้ารับการประเมิน
            </a>
        </li>
    </ol>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="min-height:480px">
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>
                                <strong>ข้อสอบ<?= $this->SharedModel->get_tool_type_name($_POST['tool_type'])['name']; ?>
                                </strong>
                            </h3>
                            <h4><strong><?= $_POST['occ_level_name'] ?></strong> </h4>
                            <hr />
                        </div>
                        <input type="hidden" id="template_id" name="template_id" value="<?= $_POST['template_id'] ?>">
                        <input type="hidden" id="occ_level_name" name="occ_level_name"
                            value="<?= $_POST['occ_level_name'] ?>">
                        <input type="hidden" id="occ_level_id" name="occ_level_id"
                            value="<?= $_POST['occ_level_id'] ?>">
                        <input type="hidden" id="exam_schedule_id" name="exam_schedule_id"
                            value="<?= $_POST['exam_schedule_id'] ?>">
                        <input type="hidden" id="tool_type" name="tool_type" value="<?= $_POST['tool_type'] ?>">
                    </div>

                    <br />

                    <div class="row">
                        <div class="col-md-12" style="margin-bottom:10px">
                            <div class="col-md-12 ">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <input type="text" class="form-control" id="keyword"
                                            placeholder="ค้นหาจาก ชื่อ/นามสกุล/เลขบัตรประชาชน">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <select class="form-control " data-dropup-auto="false" id="assessment_status"
                                            name="assessment_status" required="" data-live-search="true">
                                            <option value="">--สถานะทั้งหมด--</option>
                                            <option value="0">ยังไม่ได้ประเมินผล</option>
                                            <option value="1">ประเมินผลเรียบร้อยแล้ว</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="btn-group  btn-group-md" role="group">
                                            <button style="padding:7px" type="button" class="btn btn-primary"
                                                id="btn_search" name="btn_search">
                                                <i class="fa fa-search" aria-hidden="true"></i> ค้นหา</button>
                                            <button type="button" class="btn btn-info" id="btn_clear" name="btn_clear">
                                                <i class="fa fa-repeat" aria-hidden="true"></i> ล้างค่า</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-md-12" id="show_data">

                            <?php

                            if (!empty($dataList)) {

                                $this->load->view("assessment/applicant_assessment/showdata", array(

                                    "dataList" => $dataList

                                ));
                            } else { ?>

                            <div style="font-weight:bold;color:red;text-align:center">

                                <br> == ไม่พบข้อมูล ==

                            </div>

                            <?php } ?>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</section>


<script type="text/javascript"
    src="<?= base_url(); ?>assets/custom_js/assessment/applicant_assessment.js?<?= date("YmdHis") ?>">

</script>