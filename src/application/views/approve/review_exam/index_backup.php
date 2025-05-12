<?php $this->load->view("breadcrumb/breadcrumb", $breadcrumb); ?>

<section class="content">

    <div class="row">

        <div class="col-md-12">

            <div class="card" style="min-height:480px">

                <div class="card-body pb-0">

                    <div class="row">

                        <div class="col-md-12" style="margin-bottom:10px">

                            <div class="col-md-12 ">

                                <div class="form-row">

                                    <div class="form-group col-md-5">

                                        <?php

                                        require_once dirname(__FILE__) . "../../../shared/occ_level.php";

                                        ?>

                                    </div>

                                    <div class="form-group col-md-2">

                                        <label for="">เครื่องมือประเมิน</label>

                                        <select style="height:40px" class="form-control  " data-dropup-auto="false"
                                            id="tool_type" name="tool_type" required="" data-live-search="true">

                                            <?php

                                            $asm_tool = $this->MasterDataModel->tool_type_array();

                                            foreach ($asm_tool as $v) {
                                                if ($v['id'] != '1') {
                                            ?>

                                            <option value="<?php echo $v['id'] ?>">

                                                <?php echo $v['name']; ?>

                                            </option>

                                            <?php
                                                }
                                            } ?>

                                        </select>

                                    </div>

                                    <div class="form-group col-md-2">

                                        <label for="" class="txt-label">สถานะ</label>

                                        <select style="height:40px" class="form-control ddl-height"
                                            data-dropup-auto="false" id="status" name="status" required=""
                                            data-live-search="true">

                                            <option value="0">--ทั้งหมด--</option>

                                            <option value="1">อนุมัติ</option>

                                            <option value="2">ไม่อนุมัติ</option>

                                        </select>

                                    </div>

                                    <div class="form-group col-md-2" style="padding-top:20px">

                                        <div class="btn-group  btn-group-md" role="group">

                                            <button type="button" class="btn btn-primary" id="btn_search"
                                                name="btn_search">

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

                                $this->load->view("approve/review_exam/showdata", array(

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
    </div>
</section>



<script type="text/javascript" src="<?= base_url(); ?>assets/custom_js/approve/review_exam.js?<?= date("YmdHis") ?>">

</script>