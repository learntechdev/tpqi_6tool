<?php // $this->load->view("breadcrumb/breadcrumb", $breadcrumb); 
?>
<div class="content-header">
    <h3>
        งานออกข้อสอบ
    </h3>

    <ol class="breadcrumb">
        <?php
        if ($_SESSION["user_type"] == '8') {
            $url = "../../asmtools/ASMTools/index";
        } else {
            $url = "../../exam/ExamAssignment/fetchContract";
        } ?>


        <li class="breadcrumb-item ">
            <a href="<?= $url ?>">หน้าแรก</a>
        </li>

        <li class="breadcrumb-item active">
            <a href="../../exam/ExamAssignment/fetchContract" style="color:red">งานออกข้อสอบ</a>
        </li>
    </ol>
</div>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="min-height:480px">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5"></div>
                        <div class="col-md-7">
                            <div class="form-row">
                                <div class="form-group col-md-7">
                                    <input style="line-height:28px !important;" type="text" class="form-control"
                                        id="keyword" placeholder="ค้นหาเลขที่สัญญา/ชื่อโครงการ" >
                                </div>
                                <div class="form-group col-md-5">
                                    <div class="btn-group  btn-group-md" role="group">
                                        <button type="button" class="btn btn-primary" id="btn_search" name="btn_search" onclick="search('<?php echo$dataList["pageNo"] ?>')">
                                            <i class="fa fa-search" aria-hidden="true"></i> ค้นหา</button>
                                        <button type="button" class="btn btn-info" id="btn_clear" name="btn_clear" onclick="document.getElementById('keyword').value = ''">
                                            <i class="fa fa-repeat" aria-hidden="true"></i> ล้างค่า</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr />


                    <div class="row" id="show_data">
                        <?php
                        if (!empty($dataList)) {
                            $this->load->view("exam_assignment/users/showdata", array(
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

<script type="text/javascript"
    src="<?= base_url(); ?>assets/custom_js/exam_assignment/fetchcontract.js?<?= date("YmdHis") ?>">
</script>