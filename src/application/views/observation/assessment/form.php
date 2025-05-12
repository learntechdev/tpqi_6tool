<style>
.row-form {
    padding-top: 5px
}
</style>
<?php $this->load->view("breadcrumb/breadcrumb", $breadcrumb); ?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="min-height:480px">
                <div class="card-body">
                    <form id="form" name="form">
                        <?php
						$action = "";
						if (isset($_GET['action'])) {
							$action = $_GET['action'];
						} else {
							$action = "create";
						}
						?>
                        <input type="hidden" class="form-control" id="action" name="action" value="<?= $action; ?>" />
                        <input type="hidden" id="app_id" name="app_id" value="<?= $_POST["app_id"] ?>">
                        <input type="hidden" id="template_id" name="template_id" value="<?= $_POST["template_id"] ?>">
                        <input type="hidden" id="exam_schedule_id" name="exam_schedule_id"
                            value="<?= $_POST["exam_schedule_id"] ?>">
                        <input type="hidden" id="occ_level_name" name="occ_level_name"
                            value="<?= $_POST["occ_level_name"] ?>">
                        <div class="row">
                            <?php
							if (is_array($template)) {
								foreach ($template as $v) {
									$occ_level_id = $v->occ_level_id;

							?>
                            <input type="hidden" id="occ_level_id" name="occ_level_id" value="<?= $v->occ_level_id ?>">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for=""><b>คำอธิบายสำหรับเจ้าหน้าที่สอบ</b> </label><br>
                                    <?= $v->desc_for_examier; ?>
                                </div>

                                <div class="form-group">
                                    <label for=""><b>เกณฑ์การประเมิน</b> </label><br>
                                    <?php if ($v->criteria_used_byexamier != '0') { ?>
                                    <?= $v->title; ?>
                                    <?= $v->description; ?>
                                    <?= $v->min_score; ?>

                                    <?php } else {
												echo "ไม่กำหนดเกณฑ์ผ่าน";
											} ?>
                                </div>
                                <input type="hidden" class="form-control" id="criteria_max_score"
                                    name="criteria_max_score" value="<?= $v->max_score ?>" />
                                <div class="form-group">
                                    <label for=""><b>เกณฑ์การผ่าน (เปอร์เซ็นต์)</b> </label><br>
                                    <?= $v->exam_percent_score; ?>
                                    <input type="hidden" class="form-control" id="percent_passexam"
                                        name="percent_passexam" value="<?= $v->exam_percent_score ?>" />
                                </div>

                                <?php
								}
							}
								?>
                            </div>

                            <div class="col-md-5">
                                <div class="card border-left-violet-600">
                                    <div class="card-body">
                                        <div style="text-align:left">
                                            <label for="">รหัสผู้สมัคร :
                                                <strong><?= $_POST["app_id"] ?></strong>
                                            </label>
                                        </div>
                                        <div style="text-align:left">
                                            <label for="">ชื่อ-นามสกุล :
                                                <strong><?= $_POST["name"] ?></strong>
                                            </label>
                                        </div>
                                        <div style="text-align:left">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr />

                        <?php
						if ($v->exam_type == '2' && $v->template_type == '1' && $v->criteria_used_byexamier == '0') { //ตาม uoc & หัวข้อหลัก ไม่มีเกณ์การประเมิน
							require_once dirname(__FILE__) . "/form_uoc.php";
						} else if ($v->exam_type == '2' && $v->template_type == '1' && $v->criteria_used_byexamier == '1') { //ตาม uoc & หัวข้อหลัก มีเกณ์การประเมินแบบที่ 1
							require_once dirname(__FILE__) . "/form_uoc_criteria.php";
						}
						?>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript"
    src="<?= base_url(); ?>assets/custom_js/observation/assessment_form.js?<?= date("YmdHis") ?>">
</script>