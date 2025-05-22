<?php $this->load->view("breadcrumb/breadcrumb", $breadcrumb); ?>
<input type="hidden" name="asm_tool" id="asm_tool" value='<?= $asm_tool_type ?>'>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="min-height:480px">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <span class="label_head">สร้างข้อสอบ การจำลองสถานการณ์</span>
                            <hr />
                        </div>

                        <div class="col-md-12">
                            <form id="form" name="form">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="">

                                            <?php
                                            $action = "";
                                            if (isset($_POST['action'])) {
                                                $action = $_POST['action'];
                                            } else {
                                                $action = "create";
                                            }
                                            ?>

                                            <input type="hidden" class="form-control" id="action" name="action"
                                                value="<?= $action; ?>" />
                                            <input type="hidden" class="form-control" id="copy_tp_id" name="copy_tp_id"
                                                value="" />
                                            <?php

                                            $tmp_tp_id = "";
                                            if (isset($_POST['template_id'])) {
                                                $_SESSION['template_id'] = $_POST['template_id'];
                                                $tmp_tp_id = $_POST['template_id'];
                                                $asm_tool_type = $_POST['asm_tool_type'];
                                            } else {
                                                $_SESSION['template_id'] = '';
                                                $tmp_tp_id = '';
                                            }

                                            if (isset($_POST['contract_no'])) {
                                                $strContractNo = $_POST['contract_no'];
                                            }
                                            // if (isset($_POST['level_id'])) {
                                            //     $strLevelId = $_POST['level_id'];
                                            // } else {
                                            //     $strLevelId = "";
                                            // }
                                            $strLevelId = $current_occ_level_id;
                                            ?>
                                            <input type="hidden" class="form-control" id="template_id"
                                                name="template_id" value="<?= $tmp_tp_id ?>" />
                                            <input type="hidden" class="form-control" id="contract_no"
                                                name="contract_no" value="<?= $strContractNo; ?>" />
                                            <input type="hidden" class="form-control" id="asm_tool_type" name="asm_tool_type" value="<?= $asm_tool_type ?>" />
                                            <input type="hidden" class="form-control" id="level_id" name="level_id" value="<?= $current_occ_level_id; ?>" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-md-2 col-form-label">
                                            คุณวุฒิวิชาชีพ
                                        </label>

                                        <div class="col-md-5" style="padding-bottom:5px">
                                            <input type="hidden" id="txt_occ_level" name="txt_occ_level" value="<?= $current_occ_level_id; ?>">
                                            <input type="hidden" id="txt_tier1_code" name="txt_tier1_code" value="<?= $current_occ_level->tier1_code; ?>">
                                            <select class="form-control tier1_code" data-dropup-auto="false"
                                                id="tier1_code" name="tier1_code" required=""
                                                data-live-search="true">
                                                <option value="0">--กรุณาเลือกวิชาชีพ--</option>
                                                <?php foreach ($tier1_dropdown as $v) { ?>
                                                    <option value="<?php echo $v->tier1_code; ?>"
                                                        <?php echo ($v->tier1_code == $current_occ_level->tier1_code) ? 'selected' : ''; ?>>
                                                        <?php echo $v->tier1_title; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <label class="col-md-1 col-form-label">
                                            สาขา
                                        </label>

                                        <div class="col-md-4" style="padding-bottom:5px">
                                            <input type="hidden" id="txt_tier2_code" name="txt_tier2_code" value="<?= $current_occ_level->tier2_code; ?>">
                                            <select class="form-control tier2_code" data-dropup-auto="false"
                                                id="tier2_code" name="tier2_code" required=""
                                                data-live-search="true">
                                                <option value="0">--กรุณาเลือกสาขา--</option>
                                                <?php foreach ($tier2_dropdown as $v) { ?>
                                                    <option value="<?php echo $v->tier2_code; ?>"
                                                        <?php echo ($v->tier2_code == $current_occ_level->tier2_code) ? 'selected' : ''; ?>>
                                                        <?php echo $v->tier2_title; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <label class="col-md-2 col-form-label">
                                            อาชีพ
                                        </label>

                                        <div class="col-md-4" style="padding-bottom:5px">
                                            <input type="hidden" id="txt_tier3_code" name="txt_tier3_id" value="<?= $current_occ_level->tier3_id; ?>">
                                            <select class="form-control tier3_code" data-dropup-auto="false"
                                                id="tier3_id" name="tier3_id" required=""
                                                data-live-search="true">
                                                <option value="0">--กรุณาเลือกอาชีพ--</option>
                                                <?php foreach ($tier3_dropdown as $v) { ?>
                                                    <option value="<?php echo $v->tier3_id; ?>"
                                                        <?php echo ($v->tier3_id == $current_occ_level->tier3_id) ? 'selected' : ''; ?>>
                                                        <?php echo $v->tier3_title; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <label class="col-md-1 col-form-label">
                                            ระดับ / ชั้น
                                        </label>

                                        <div class="col-md-3" style="padding-bottom:5px">
                                            <input type="hidden" id="txt_level_code" name="txt_level_code">
                                            <select class="form-control level_code" data-dropup-auto="false"
                                                id="level_code" name="level_code" required=""
                                                data-live-search="true">
                                                <option value="0">--กรุณาเลือกระดับ / ชั้น--</option>
                                                <?php foreach ($level_dropdown as $v) { ?>
                                                    <option value="<?php echo $v->level_code; ?>"
                                                        <?php echo ($v->level_code == $current_occ_level->level_code) ? 'selected' : ''; ?>>
                                                        <?php echo $v->level_name; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>



                                    <?php require_once dirname(__FILE__) . "../../shared/template_type.php"; ?>

                                    <!-- <div class="row">
                                        <label class="col-md-2 col-form-label">
                                            เกณฑ์การให้คะแนน
                                        </label>

                                        <div class="col-md-10">
                                            <1?php //require_once dirname(__FILE__) . "../../criteria_asm/form_examier_advise_type.php"; ?>
                                        </div>
                                    </div>
                                    <br /> -->
                                    <br />
                                    <div class="row">

                                        <label class="col-md-3 col-form-label">
                                            ค่าคะแนนเริ่มต้นสำหรับทุกข้อ
                                        </label>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" id="default_score" name="default_score" placeholder="" />
                                        </div>
                                        <div class="col-md-7 col-form-label">
                                            คะแนน
                                        </div>

                                    </div>
                                    <br />
                                    <div class="row">

                                        <label class="col-md-3 col-form-label">
                                            เกณฑ์ผ่านประเมิน
                                        </label>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" id="default_score" name="default_score" placeholder="" />
                                        </div>
                                        <div class="col-md-7 col-form-label">
                                            %
                                        </div>

                                    </div>
                                    <br />

                                </div>



                                <div class="col-md-12">
                                    <div class="card">
                                        <ul
                                            class="nav nav-tabs nav-tabs-solid nav-justified bg-indigo-400 border-x-0 border-bottom-0 border-top-indigo-300 mb-0">

                                            <li class="nav-item">
                                                <a href="#tab1" class="nav-link font-size-sm text-uppercase active"
                                                    data-toggle="tab">
                                                    <span class="txt-title">คำอธิบายสำหรับผู้ประเมิน</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#tab2" class="nav-link font-size-sm text-uppercase"
                                                    data-toggle="tab">
                                                    <span class="txt-title">คำอธิบายสำหรับผู้เข้ารับการประเมิน</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#tab3" class="nav-link font-size-sm text-uppercase"
                                                    data-toggle="tab">
                                                    <span class="txt-title">คำอธิบายสำหรับจำลองสถานการณ์</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <!-- Tabs content -->

                                        <div class="tab-content card-body">
                                            <div class="tab-pane active fade show" id="tab1">
                                                <textarea id="desc_for_examier" name="desc_for_examier"></textarea>
                                            </div>
                                            <div class="tab-pane fade" id="tab2">
                                                <textarea id="desc_for_applicant" name="desc_for_applicant"></textarea>
                                            </div>
                                            <div class="tab-pane fade" id="tab3">
                                                <textarea id="case_study" name="case_study"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <?php require_once dirname(__FILE__) . "../../shared/upload_docsexam.php"; ?>
                                </div>
                                <br />
                                <hr />
                                <!-- แสดงข้อมูลตาม uoc -->
                                <div class="col-md-12" id="uoc" style="display:none"></div>
                                <div class="col-md-12" id="eoc" style="display:none"></div>
                                <div class="col-md-12">

                                    <div class="row" style="text-align:center;display:inline; " id="operation">
                                        <div class="col-md-4"></div>
                                        <div class="" style="padding:5px;" id="div_save_pc">
                                            <button type="button" class="btn btn-primary" id="btn_save">
                                                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                                <strong>บันทึก</strong>
                                            </button>
                                        </div>

                                        <!--            <div class="" style="padding:5px" id="div_preview">
                                            <button type="button" class="btn btn-info" id="btn_preview">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                <strong>ดูข้อสอบ</strong>
                                            </button>
                                        </div>

                                        <div class="" style="padding:5px" id="div_sendapprove">
                                            <button type="button" class="btn btn-success" id="btn_sendapprove">
                                                <i class="fa fa-check-circle" aria-hidden="true"></i>
                                                <strong>ส่งตรวจสอบ</strong>
                                            </button>   -->

                                        &nbsp;

                                        <a href="../../exam_library/Examlibrary/index?tool_type=4&contract_no=<?= $strContractNo ?> "
                                            class=" btn btn-secondary">
                                            <i class="fa fa-arrow-circle-left" style="color:#fff"></i>
                                            <strong>กลับ</strong>
                                        </a>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                                <br /><br />
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<script type="text/javascript" src="<?= base_url(); ?>assets/custom_js/simulation/form.js?<?= date("YmdHis") ?>">

</script>