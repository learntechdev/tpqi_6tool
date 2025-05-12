<?php $this->load->view("breadcrumb/breadcrumb", $breadcrumb); ?>

<input type="hidden" name="asm_tool" id="asm_tool" value='<?= $asm_tool_type ?>'>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="min-height:480px">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <span class="label_head">สร้างข้อสอบ สัมภาษณ์</span>

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
                                                //$asm_tool_type = '';
                                                $asm_tool_type = $asm_tool_type;
                                            }

                                            if (isset($_POST['contract_no'])) {
                                                $strContractNo = $_POST['contract_no'];
                                            } else {
                                                $strContractNo = "";
                                            }

                                            if (isset($_POST['level_id'])) {
                                                $strLevelId = $_POST['level_id'];
                                            } else {
                                                $strLevelId = "";
                                            }
                                            ?>

                                            <input type="hidden" class="form-control" id="template_id" name="template_id" value="<?= $tmp_tp_id ?>" />
                                            <input type="hidden" class="form-control" id="asm_tool_type" name="asm_tool_type" value="<?= $asm_tool_type ?>" />
                                            <input type="hidden" class="form-control" id="contract_no" name="contract_no" value="<?= $strContractNo; ?>" />
                                        </div>
                                    </div>

                                    <div class="row">

                                        <label class="col-md-2 col-form-label"> คุณวุฒิวิชาชีพ</label>

                                        <div class="col-md-4" style="padding-bottom:5px">
                                            <input type="hidden" id="txt_occ_level" name="txt_occ_level">
                                            <select class="form-control occ_level" data-dropup-auto="false"
                                                id="occ_level_id" name="occ_level_id" required=""
                                                data-live-search="true">
                                                <!--        <option value="0">--กรุณาเลือก--</option>   -->
                                                <?php foreach ($occ_level as $v) {
                                                    if ($v->id == $strLevelId) {  ?>
                                                        <option value="<?php echo $strLevelId; ?>">
                                                            <?php echo $v->occ_level; ?>
                                                        </option>
                                                <?php    }
                                                } ?>
                                                <?php foreach ($occ_level as $v) { ?>
                                                    <option value="<?php echo $v->id; ?>">
                                                        <?php echo $v->occ_level; ?>
                                                    </option>;
                                                <?php }
                                                ?>
                                            </select>

                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 col-form-label"> คุณวุฒิวิชาชีพ</label>

                                            <div class="col-md-4" style="padding-bottom:5px">
                                                <input type="hidden" id="txt_occ_level" name="txt_occ_level">
                                                <select class="form-control occ_level" data-dropup-auto="false"
                                                    id="occ_level_id" name="occ_level_id" required=""
                                                    data-live-search="true">
                                                    <!--        <option value="0">--กรุณาเลือก--</option>   -->
                                                    <?php foreach ($occ_level as $v) {
                                                        if ($v->id == $strLevelId) {  ?>
                                                            <option value="<?php echo $strLevelId; ?>">
                                                                <?php echo $v->occ_level; ?>
                                                            </option>
                                                    <?php    }
                                                    } ?>
                                                    <?php foreach ($occ_level as $v) { ?>
                                                        <option value="<?php echo $v->id; ?>">
                                                            <?php echo $v->occ_level; ?>
                                                        </option>;
                                                    <?php }
                                                    ?>
                                                </select>

                                            </div>


                                        </div>

                                    </div>

                                    <div class="row">

                                        <label class="col-md-2 col-form-label"> คุณวุฒิวิชาชีพ</label>

                                        <div class="col-md-4" style="padding-bottom:5px">
                                            <input type="hidden" id="txt_occ_level" name="txt_occ_level">
                                            <select class="form-control occ_level" data-dropup-auto="false"
                                                id="occ_level_id" name="occ_level_id" required=""
                                                data-live-search="true">
                                                <!--        <option value="0">--กรุณาเลือก--</option>   -->
                                                <?php foreach ($occ_level as $v) {
                                                    if ($v->id == $strLevelId) {  ?>
                                                        <option value="<?php echo $strLevelId; ?>">
                                                            <?php echo $v->occ_level; ?>
                                                        </option>
                                                <?php    }
                                                } ?>
                                                <?php foreach ($occ_level as $v) { ?>
                                                    <option value="<?php echo $v->id; ?>">
                                                        <?php echo $v->occ_level; ?>
                                                    </option>;
                                                <?php }
                                                ?>
                                            </select>

                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 col-form-label"> คุณวุฒิวิชาชีพ</label>

                                            <div class="col-md-4" style="padding-bottom:5px">
                                                <input type="hidden" id="txt_occ_level" name="txt_occ_level">
                                                <select class="form-control occ_level" data-dropup-auto="false"
                                                    id="occ_level_id" name="occ_level_id" required=""
                                                    data-live-search="true">
                                                    <!--        <option value="0">--กรุณาเลือก--</option>   -->
                                                    <?php foreach ($occ_level as $v) {
                                                        if ($v->id == $strLevelId) {  ?>
                                                            <option value="<?php echo $strLevelId; ?>">
                                                                <?php echo $v->occ_level; ?>
                                                            </option>
                                                    <?php    }
                                                    } ?>
                                                    <?php foreach ($occ_level as $v) { ?>
                                                        <option value="<?php echo $v->id; ?>">
                                                            <?php echo $v->occ_level; ?>
                                                        </option>;
                                                    <?php }
                                                    ?>
                                                </select>

                                            </div>


                                        </div>

                                    </div>

                                    <?php require_once dirname(__FILE__) . "../../shared/template_type.php"; ?>

                                    <div class="row">
                                        <!--        <label class="col-md-2 col-form-label"> เกณฑ์การให้คะแนน</label>   -->
                                        <div class="col-md-10">
                                            <?php require_once dirname(__FILE__) . "../../criteria_asm/form_examier_advise_type.php"; ?>
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
                                                    <span class="txt-title">คำอธิบายสำหรับเจ้าหน้าที่สอบ</span>
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
                                                    <span class="txt-title">กรณีศึกษา</span>
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

                                <!-- แสดงข้อมูลตาม uoc -->

                                <br />
                                <hr />
                                <div class="col-md-12" id="uoc" style="display:none"> </div>
                                <div class="col-md-12" id="eoc" style="display:none"> </div>

                                <div class="col-md-12" sytle="display:none">
                                    <?php require_once dirname(__FILE__) . "../../alert/modal_alert.php"; ?>
                                </div>
                                <br /><br /><br />
                                <div class="col-md-12">
                                    <br /><br /> <br /><br />
                                    <div class="row" style="text-align:center;display:none; " id="div_manage">
                                        <div class="col-md-4"></div>
                                        <div class="" style="padding:5px;" id="div_save_pc">
                                            <button type="button" class="btn btn-primary" id="btn_save">
                                                <i class="fa fa-floppy-o" aria-hidden="fa"></i>
                                                <strong>บันทึก</strong>
                                            </button>
                                        </div>

                                        <div class="" style="padding:5px" id="div_preview">
                                            <button type="button" class="btn btn-info" id="btn_preview">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                <strong>แสดงตัวอย่าง</strong>
                                            </button>
                                        </div>

                                        <div class="" style="padding:5px" id="div_sendapprove">
                                            <button type="button" class="btn btn-success" id="btn_sendapprove">
                                                <i class="fa fa-check-circle" aria-hidden="true"></i>
                                                <strong>ส่งตรวจสอบ</strong>
                                            </button>

                                            &nbsp;

                                            <a href="../../exam_library/Examlibrary/index?tool_type=3&contract_no=<?= $strContractNo ?> "
                                                class="btn btn-secondary">
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

    <div class="printme" id="div_print" style="display: none;"></div>
</section>

<!-- /.content -->

<script type="text/javascript" src="<?= base_url(); ?>assets/custom_js/interview/form.js?<?= date("YmdHis") ?>">
</script>