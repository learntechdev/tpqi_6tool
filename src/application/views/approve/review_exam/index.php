<?php $this->load->view("breadcrumb/breadcrumb", $breadcrumb); ?>

<section class="content">

    <div class="row">

        <div class="col-md-12">

            <div class="card" style="min-height:480px">

                <div class="card-body pb-0">

                    <div class="row">
					
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