<?php //$this->load->view("breadcrumb/breadcrumb", $breadcrumb);?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="min-height:480px">
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-md-12" style="margin-bottom:10px">
                            <?php include("config_api.php");?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript"
            src="<?= base_url(); ?>assets/custom_js/approve/approve_criteria.js?<?= date("YmdHis") ?>">
        </script>