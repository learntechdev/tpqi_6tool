<?php //$this->load->view("breadcrumb/breadcrumb", $breadcrumb); 
?>
<br />
<section class="content">
    <div class="col-md-12">
        <div class="card" style="min-height:480px">
            <div class="card-body">
                <div class="row">
                    <?php
                    if (is_array($template)) {
                        // print_r($template);
                        foreach ($template as $v) {
                    ?>
                    <div class="col-md-12">
                        <h3><?= $v->occ_level_name ?>
                            <input type="hidden" value="<?= $v->occ_level_id ?>">
                        </h3>
                        <hr />
                    </div>

                    <div class="col-md-12">
                        <label for=""><b>คำอธิบายสำหรับผู้เข้าสอบ </b> </label><br>
                        <?= $v->des_for_applicant; ?>
                        <?php
                        }
                    }
                        ?>
                    </div>

                    <div class="col-md-12">
                        <br />
                        <?php
                                if ($v->template_type == '1') {
                                    require_once dirname(__FILE__) . "/form_type_uoc.php";
                                } else if ($v->template_type == '2') {
                                    require_once dirname(__FILE__) . "/form_type_maintopic.php";
                                }
                                ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>