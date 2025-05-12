<?php $this->load->view("breadcrumb/breadcrumb", $breadcrumb); ?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="min-height:480px">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <span class="label_head">รายงานสรุปจำนวนชุดข้อสอบ</span>
                        </div>
                        <div class="col-md-6 text-right">
                        </div>
                    </div>
                    <hr />
                    <!-- ค้นหาข้อมูล -->
                    <!-- <div class="row">
                        <div class="form-group col-md-3">
                            <label for="">ชื่อผู้ใช้งาน/ชื่อ-นามสกุล</label>
                            <input type="text" class="form-control" id="txt_search" name="txt_search">
                        </div>
                        <div class="col-md-2" style="padding-top:20px">
                            <div class="btn-group btn-group-md" role="group">
                                <button type="button" class="btn btn-primary" id="btn_search" name="btn_search" onclick="search(1)">
                                    <i class="fa fa-search" aria-hidden="true"></i> ค้นหา</button>
                                <button type="button" class="btn btn-info" id="btn_clear" name="btn_clear">
                                    <i class="fa fa-repeat" aria-hidden="true"></i> ล้างค่า</button>
                            </div>
                        </div>
                    </div> -->

                    <div class=" row" id="show_data">
                        <?php
                        if (!empty($dataList)) {
                            $this->load->view("report/summaryexam/showdata", array(
                                "dataList" => $dataList,
                            ));
                        } else { ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="font-weight:bold;color:red;text-align:center">
                            <br> == ไม่พบข้อมูล ==
                        </div>
                    </div>
                    <?php   } ?>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<script type="text/javascript" src="<?= base_url(); ?>assets/custom_js/report/rptsummaryexam.js?<?= date("YmdHis") ?>">
</script>