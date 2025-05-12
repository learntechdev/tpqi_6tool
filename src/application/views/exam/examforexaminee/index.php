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

                                    <div class="form-group col-md-4">

                                        <label for="">คำค้น</label>

                                        <input style="height:40px" type="text" class="form-control" id="keyword"
                                            placeholder="">

                                    </div>

                                    <div class="form-group col-md-2">

                                        <label for="">เครื่องมือประเมิน</label>

                                        <select style="height:40px" class="form-control " data-dropup-auto="false"
                                            id="tool_type" name="tool_type" required="" data-live-search="true">

                                            <?php

                                            $asm_tool = $this->MasterDataModel->tool_type_array();

                                            foreach ($asm_tool as $v) { ?>

                                            <option value="<?php echo $v['id'] ?>">

                                                <?php echo $v['name']; ?>

                                            </option>

                                            <?php } ?>

                                        </select>

                                    </div>

                                    <div class="form-group col-md-2">

                                        <label for="">สถานะข้อสอบ</label>

                                        <select style="height:40px" class="form-control " data-dropup-auto="false"
                                            id="exam_used" name="exam_used" required="" data-live-search="true">

                                            <option value="">--ทั้งหมด--</option>

                                            <option value="0">ยังไม่ได้นำไปใช้งาน</option>

                                            <option value="1">ถูกนำไปใช้งานแล้ว</option>

                                        </select>

                                    </div>

                                    <div class="form-group col-md-2" style="margin-top:23px">

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

                                $this->load->view("exam/examforexaminee/showdata", array(

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


<script type="text/javascript" src="<?= base_url(); ?>assets/custom_js/exams/examforexaminee.js?<?= date("YmdHis") ?>">

</script>