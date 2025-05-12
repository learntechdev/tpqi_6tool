<?php $this->load->view("breadcrumb/breadcrumb", $breadcrumb); ?>

<?php //var_dump($_SESSION["occ_level_id"]); ?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="min-height:480px">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <span class="label_head">แสดงข้อมูล งานออกข้อสอบ</span>
                        </div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-dark" id="btn_add_examassign" name="btn_add_examassign"><i
                                    class="fa fa-plus-circle" aria-hidden="true"></i>
                                สร้างงานออกข้อสอบ</button>
                        </div>
                    </div>
                    <hr />

                    <div class="row" id="show_data">
                        <?php
                        if (!empty($dataList)) {
                            $this->load->view("exam_assignment/showdata", array(
                                "dataList" => $dataList,
                            ));
                        } else { ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="font-weight:bold;color:red;text-align:center">
                            <br> == ไม่พบข้อมูล ==
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<script type="text/javascript" src="<?= base_url(); ?>assets/custom_js/exam_assignment/index.js?<?= date("YmdHis") ?>">
</script>