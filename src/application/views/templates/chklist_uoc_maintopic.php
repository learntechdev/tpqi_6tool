<?php
$initial = "";
$i = 1;
if ($template_id != "" && $uoc_code != "") {
    $q = $this->SharedModel->get_tpdetail_foredit($template_id, $uoc_code);
    $initial = count((array)$q);
} else {
    $initial = 1;
    $i = 1;
}

//echo "tmp_template_id:".$template_id;
//echo "uoc_code:".$uoc_code;
?>


<input type="hidden" id="last_idx<?= $uoc_code ?>" name="last_idx<?= $uoc_code ?>" value="<?= $initial ?>">
<?php
$uoc = $uoc_code;
if (!empty($q)) {
    foreach ($q as $v) {
?>
<div class="col-md-12">
    <div class="col-md-12" id="form_q_a_div_<?= $uoc ?>">
        <div id="form_q_a<?= $uoc ?>_<?= $i ?>">
            <div id="f<?= $uoc ?><?= $i ?>">
                <div class="row ">
                    <div class="col-md-1">
                        <span class="num_q<?= $uoc ?>" id="q_num_<?= $uoc ?><?= $i ?>"> ข้อที่ <?= $i ?></span>
                    </div>
                    <div class="col-md-9">
                        <label for="">สถานะคำถาม</label>&nbsp; &nbsp; &nbsp;
                        <input type="radio" value="1" <?php if ($v->question_status == 1) {
                                                                    echo "checked";
                                                                }
                                                                ?> checked
                            id="uocchklist[<?= $uoc ?>][<?= $i ?>][question_status1]"
                            name="uocchklist[<?= $uoc ?>][<?= $i ?>][question_status]">
                        &nbsp; ใช้งาน &nbsp; &nbsp; &nbsp;
                        <input type="radio" value="0" <?php if ($v->question_status == 0) {
                                                                    echo "checked";
                                                                }
                                                                ?>
                            id="uocchklist[<?= $uoc ?>][<?= $i ?>][question_status2]"
                            name="uocchklist[<?= $uoc ?>][<?= $i ?>][question_status]">
                        &nbsp; ไม่ใช้งาน &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
                    </div>
					<div class="col-md-2">
					<input type="hidden" id="count"
							name="count" value="<?= $x ?>">
						<?php if($x !=1){?>
                            <button type="button" class="btn btn-success2 add"
                                onClick="" id="showPopup">
                                <i class="fa fa-plus-circle" aria-hidden="true"><label style="padding-left:2px;">UOC</label></i>
                            </button>
						<?php } ?>
						</div>
                </div>

                <div class="row">
                    <div class="row col-md-12" style="padding:5px">
                        <div class="col-md-11">
                            <input type="hidden" class="form-control"
                                name="uocchklist[<?= $uoc ?>][<?= $i ?>][order_line]" value="<?= $i ?>" />
                            <input type="hidden" class="form-control"
                                name="uocchklist[<?= $uoc ?>][<?= $i ?>][uoc_code]" value="<?= $uoc ?>" />
                            <input type="text" class="form-control" name="uocchklist[<?= $uoc ?>][<?= $i ?>][topic]"
                                value="<?= $v->main_topic ?>" />
                        </div>
                        <div class=" col-md-1">
                            <div class="btn-group  btn-group-sm" role="group">
                                <button type="button" class="btn btn-success" id="btn_add_q_form" name="btn_add_q_form"
                                    onClick="add_q_form('<?= $uoc_code ?>')">
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                </button>
                                <?php
                                        if ($i > 1) { ?>
                                <button type="button" class="btn btn-danger" id="btn_del_q_form" name="btn_del_q_form"
                                    onClick="rm_dynamic_uiform('<?= $uoc_code ?>','<?= $i ?>')">
                                    <i class="fa fa-minus-circle" aria-hidden="true"></i>
                                </button>
                                <?php   } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <br />
        </div>
    </div>
</div>
<?php
        $i++;
    }
} else {
    for ($i = 1; $i <= $initial; $i++) {
    ?>

<div class="col-md-12">
    <div class="col-md-12" id="form_q_a_div_<?= $uoc ?>">
        <div id="form_q_a<?= $uoc ?>_<?= $i ?>">
            <div id="f<?= $uoc ?><?= $i ?>">
                <div class="row ">
                    <div class="col-md-1">
                        <span class="num_q<?= $uoc ?>" id="q_num_<?= $uoc ?><?= $i ?>"> ข้อที่ <?= $i ?> </span>
                    </div>
                    <div class="col-md-9">
                        <label for="">สถานะคำถาม</label>&nbsp; &nbsp; &nbsp;
                        <input type="radio" value="1" checked id="uocchklist[<?= $uoc ?>][<?= $i ?>][question_status1]"
                            name="uocchklist[<?= $uoc ?>][<?= $i ?>][question_status]">
                        &nbsp; ใช้งาน &nbsp; &nbsp; &nbsp;
                        <input type="radio" value="0" id="uocchklist[<?= $uoc ?>][<?= $i ?>][question_status2]"
                            name="uocchklist[<?= $uoc ?>][<?= $i ?>][question_status]">
                        &nbsp; ไม่ใช้งาน &nbsp; &nbsp; &nbsp;
                    </div>
					<div class="col-md-2">
					<input type="hidden" id="count"
							name="count" value="<?= $x ?>">
						<?php if($x !=1){?>
                            <button type="button" class="btn btn-success2 add"
                                onClick="" id="showPopup">
                                <i class="fa fa-plus-circle" aria-hidden="true"><label style="padding-left:2px;">UOC</label></i>
                            </button>
						<?php } ?>
						</div>
                </div>

                <div class="row">
                    <div class="row col-md-12" style="padding:5px">
                        <div class="col-md-11">
                            <input type="hidden" class="form-control"
                                name="uocchklist[<?= $uoc ?>][<?= $i ?>][order_line]" value="<?= $i ?>" />
                            <input type="hidden" class="form-control"
                                name="uocchklist[<?= $uoc ?>][<?= $i ?>][uoc_code]" value="<?= $uoc ?>" />
                            <input type="text" class="form-control" name="uocchklist[<?= $uoc ?>][<?= $i ?>][topic]"
                                value="" />
                        </div>
                        <div class=" col-md-1">
                            <div class="btn-group  btn-group-sm" role="group">
                                <button type="button" class="btn btn-success" id="btn_add_q_form" name="btn_add_q_form"
                                    onClick="add_q_form('<?= $uoc_code ?>')">
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                </button>
                                <!--<button type="button" class="btn btn-danger" id="btn_del_q_form" name="btn_del_q_form"
                                    onClick="rm_dynamic_uiform('<?= $uoc_code ?>','<?= $i ?>')">
                                    <i class="fa fa-minus-circle" aria-hidden="true"></i>
                                </button>-->
                            </div>
                        </div>
                    </div>
                </div>
                <br />
            </div>
        </div>
    </div>

</div>

<?php }
} ?>



<script type="text/javascript"
    src="<?= base_url(); ?>assets/custom_js/templates/chklist_uoc_maintopic.js?<?= date("YmdHis") ?>">
</script>