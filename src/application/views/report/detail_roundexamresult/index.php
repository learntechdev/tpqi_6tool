<?php //$this->load->view("breadcrumb/breadcrumb", $breadcrumb);
$asm_tool = $this->MasterDataModel->tool_type_array();
$log_action = $this->MasterDataModel->get_log_action();
?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="min-height:480px">
                <div class="card-body">
                    <?php
                    $str_tpqi_exam_no = "";
                    $str_tool_type = "";
                    if (isset($_POST["tpqi_exam_no"])) {
                        $str_tpqi_exam_no = $_POST["tpqi_exam_no"];
                        $str_tool_type = $_POST["tool_type"];
                    } else {
                        $str_tpqi_exam_no = "";
                        $str_tool_type = "";
                    }
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <h4><strong>รายละเอียดผลการประเมิน</strong> </h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <strong>รอบสอบ : <?= $str_tpqi_exam_no ?> </strong><br />
                            <strong>คุณวุฒิวิชาชีพ</strong>
                        </div>
                    </div>
                    <hr />
                    <div class="row">

                        <input type="hidden" class="form-control" id="tpqi_exam_no" value="<?= $str_tpqi_exam_no ?>" />
                        <input type="hidden" class="form-control" id="tool_type" value="<?= $str_tool_type ?>" />
                        <div class="col-md-12" style="margin-bottom:10px">

                            <div class="col-md-12">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="">คำค้น</label>
                                        <input type="text" class="form-control" id="keyword" placeholder="">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="tp_created_date_start">วันที่เริ่ม</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                            </div>
                                            <input style="padding:6px" type="text" class="form-control float-right"
                                                name="tp_created_date_start" id="tp_created_date_start"
                                                autocomplete="off" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="tp_created_date_end">วันที่สิ้นสุด</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                            </div>
                                            <input style="padding:6px" type="text" class="form-control float-right"
                                                name="tp_created_date_end" id="tp_created_date_end" autocomplete="off"
                                                readonly>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-2" style="padding-top:20px">
                                        <div class="btn-group  btn-group-md" role="group">
                                            <button type="button" class="btn btn-primary" id="btn_search"
                                                name="btn_search" onclick="search(1)">
                                                <i class="fa fa-search" aria-hidden="true"></i> ค้นหา</button>
                                            <button type="button" class="btn btn-info" id="btn_clear" name="btn_clear">
                                                <i class="fa fa-repeat" aria-hidden="true"></i> ล้างค่า</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12" id="show_data">
                            <?php
                            if (!empty($dataList)) {
                                $this->load->view("report/detail_roundexamresult/showdata", array(
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

<script type="text/javascript"
    src="<?= base_url(); ?>assets/custom_js/report/detail_roundexam_result.js?<?= date("YmdHis") ?>">
</script>