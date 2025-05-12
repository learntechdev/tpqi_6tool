<?php //$this->load->view("breadcrumb/breadcrumb", $breadcrumb);
?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="min-height:480px">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <span class="label_head">นำเข้าข้อมูลรอบสอบ</span>
                        </div>
                    </div>
                    <hr />
                    <?php 
					//include("exam_round.php");
					include("item_qualification.php");
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>