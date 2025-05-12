<?php
$initial = 1;
$i = 1;

if ($template_id != "" && $uoc_code != "") {
    $tp_detail = $this->SharedModel->get_tp_detail_foredit($template_id, $uoc_code, $eoc_code, $asm_tool);
    if (is_array($tp_detail)) {
        $initial = count($tp_detail);
        if ($initial == 0) {
            $initial = 1;
        }
        //echo "array initial:" . $initial;
    }
} else {
    $initial = 1;
    $i = 1;
}
//echo "eoc_code:" . $eoc_code;
//echo "tmp_template_id:".$initial;
//print_r($tp_detail);
?>
<input type="hidden" id="tmplast_idx_<?= $uoc_code ?><?= $eoc_code ?>"
    name="tmplast_idx_<?= $uoc_code ?><?= $eoc_code ?>" value="<?= $initial ?>">
<input type="hidden" id="last_idx_<?= $uoc_code ?><?= $eoc_code ?>" name="last_idx_<?= $uoc_code ?><?= $eoc_code ?>"
    value="<?= $initial ?>">

<input type="hidden" id="last_idx_sub_<?= $uoc_code ?><?= $eoc_code ?>"
    name="last_idx_sub<?= $uoc_code ?><?= $eoc_code ?>" value="<?= $initial ?>">

<div class="col-md-12">
    <div id="form_q_a<?= $uoc_code ?><?= $eoc_code ?>">
        <?php
        if (!empty($tp_detail)) {
            $i = 0;
            foreach ($tp_detail as $v) {
                $i++;
        ?>
        <div id="f<?= $uoc_code ?><?= $eoc_code ?><?= $i ?>">
            <div class="card">
                <div class="row" style="padding-right:10px;padding-left:10px;padding-top:10px">
                    <div class="col-md-7">
                        <label for="">สถานะคำถาม</label>&nbsp; &nbsp; &nbsp;
                        <input type="radio" value="1" <?php if ($v->question_status == 1) {
                                                                    echo "checked";
                                                                }
                                                                ?> checked
                            id="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][question_status1]"
                            name="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][question_status]">
                        &nbsp; ใช้งาน &nbsp; &nbsp; &nbsp;
                        <input type="radio" value="0" <?php if ($v->question_status == 0) {
                                                                    echo "checked";
                                                                }
                                                                ?>
                            id="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][question_status2]"
                            name="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][question_status]">
                        &nbsp; ไม่ใช้งาน
                    </div>
                    <div class="col-md-5 text-right">
                        <div class="btn-group  btn-group-sm edit-area" role="group">
                            <button type="button" class="btn btn-success"
                                onClick="add_q_form('<?= $uoc_code ?>','<?= $eoc_code ?>','<?= $i ?>')">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            </button>
                            <?php
                                    if ($i > 1) { ?>
                            <button type="button" class="btn btn-danger" id="btn_del_q_form" name="btn_del_q_form"
                                onClick="rm_dynamic_uiform('<?= $uoc_code ?>','<?= $eoc_code ?>','<?= $i ?>')">
                                <i class="fa fa-minus-circle" aria-hidden="true"></i>
                            </button>
                            <?php   } ?>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-body row template">
                    <input type="hidden" class="form-control"
                        name="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][order_line]" value="<?= $i ?>" />
                    <input type="hidden" class="form-control"
                        name="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][uoc_code]" value="<?= $uoc_code ?>" />
                    <input type="hidden" class="form-control"
                        name="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][eoc_code]" value="<?= $eoc_code ?>" />
                    <div class="col-md-6">
                        <label for=""><strong>คำถาม ข้อที่ <span class="num_q<?= $uoc_code ?><?= $eoc_code ?>"
                                    id="q_num_<?= $uoc_code ?><?= $eoc_code ?><?= $i ?>">
                                    <?= $i ?></span></strong></label>
                        <textarea class="ckeditor ckq"
                            id="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][question]"
                            name="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][question]"><?= $v->question ?></textarea>
                    </div>
                    <div class=" col-md-6">
                        <label for=""><strong>แนวคำตอบ</strong></label>
                        <textarea class="ckeditor cka" id="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][answer]"
                            name="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][answer]"><?= $v->guide_answer ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <?php
                // $i++;
            }
        } else {
            $this->load->view(
                "templates/q_ans_add",
                array(
                    "initial" => '1',
                    "uoc_code" => $uoc_code,
                    "eoc_code" => $eoc_code
                )
            );
            ?>
        <?php  }
        ?>
    </div>
</div>


<script type="text/javascript" src="<?= base_url(); ?>assets/custom_js/templates/q_ans.js?<?= date("YmdHis") ?>">
</script>