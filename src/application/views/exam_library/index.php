<?php $this->load->view("breadcrumb/breadcrumb", $breadcrumb); ?>
<input type="hidden" id="tool_type" value="<?= $tool_type ?>">
<input type="hidden" id="url_create" value="<?= $url ?>">

<input type="hidden" id="contract_no" value="<?= isset($_GET['contract_no']) ? $_GET['contract_no'] : ""; ?>">
<section class="content">
    <div class="row">

        <div class="col-md-12">

            <div class="card" style="min-height:480px">

                <div class="card-body pb-0">

                    <div class="row">

                        <div class="col-md-12" style="margin-bottom:10px">

                            <div class="row ">

                                <div class="col-md-6 ">

                                    <div class="text-left">

                                        <?php

                                        $asm_tool = $this->MasterDataModel->tool_type_array();

                                        foreach ($asm_tool as $v) {

                                            if ($v['tool_type'] == $tool_type) { ?>

                                        <b><?= $v['name'] ?></b>

                                        <?php }
                                        } ?>



                                    </div>

                                </div>

                                <div class="col-md-6 ">

                                    <div class="text-right">


                                        <button class="btn btn-dark" id="btn_add_exam" name="btn_add_exam"><i
                                                class="fa fa-plus-circle" aria-hidden="true"></i>

                                            สร้างชุดข้อสอบ</button>

                                    </div>

                                </div>

                                <div class="col-md-12">

                                    <hr>



                                </div>

                            </div>

                        </div>



                        <div class="col-md-12">

                            <div class="col-md-12">

                                <div class="form-row">

                                    <div class="form-group col-md-6">

                                        <label for="keyword">คุณวุฒิวิชาชีพ</label>

                                        <select class="form-control occ_level" data-dropup-auto="false"
                                            id="occ_level_id" name="occ_level_id" required="" data-live-search="true">

                                            <option value="">--ทั้งหมด--</option>

                                            <?php

                                            $tmp_occ_level = $this->MasterDataModel->get_occ_level();


                                            foreach ($tmp_occ_level as $v) { ?>

                                            <option value="<?php echo $v->id; ?>">
                                                <?php echo $v->occ_level; ?>
                                            </option>

                                            <?php } ?>

                                        </select>

                                    </div>

                                    <div class="form-group col-md-2">

                                        <label for="tp_created_date_start">วันที่เริ่มจัดทำ</label>

                                        <div class="input-group">

                                            <div class="input-group-prepend">

                                                <span class="input-group-text">

                                                    <i class="fa fa-calendar"></i>

                                                </span>

                                            </div>

                                            <input style="padding:10px" type="text" class="form-control float-right"
                                                name="tp_created_date_start" id="tp_created_date_start"
                                                autocomplete="off" readonly>

                                        </div>

                                    </div>

                                    <div class="form-group col-md-2">

                                        <label for="tp_created_date_end">วันที่สิ้นสุดจัดทำ</label>

                                        <div class="input-group">

                                            <div class="input-group-prepend">

                                                <span class="input-group-text">

                                                    <i class="fa fa-calendar"></i>

                                                </span>

                                            </div>

                                            <input style="padding:10px" type="text" class="form-control float-right"
                                                name="tp_created_date_end" id="tp_created_date_end" autocomplete="off"
                                                readonly>

                                        </div>

                                    </div>

                                    <div class="form-group col-md-2" style="margin-top:25px">

                                        <div class="btn-group btn-group-md" role="group">

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

                                $this->load->view("exam_library/show_occ_level", array(

                                    "dataList" => $dataList,

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
</section>

<script type="text/javascript" src="<?= base_url(); ?>assets/custom_js/exam_library/index.js?<?= date("YmdHis") ?>">
</script>