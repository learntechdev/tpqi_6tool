<?php

$initial = 1;
$i = 1;
for ($i = 1; $i <= 1; $i++) {
?>
<div class="col-md-12">
    <div id="form_q_a<?= $uoc_code ?><?= $eoc_code ?>">
        <div id="f<?= $uoc_code ?><?= $eoc_code ?><?= $i ?>">
            <div class="card template">
                <div class="row" style="padding-right:10px;padding-left:10px;padding-top:10px">
                    <div class="col-md-7">
                        <label for="">สถานะคำถาม เพิ่มใหม่</label>&nbsp; &nbsp; &nbsp;
                        <input type="radio" value="1" checked
                            id="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][question_status1]"
                            name="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][question_status]">
                        &nbsp; ใช้งาน &nbsp; &nbsp; &nbsp;
                        <input type="radio" value="0"
                            id="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][question_status2]"
                            name="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][question_status]">
                        &nbsp; ไม่ใช้งาน
                    </div>
                    <div class="col-md-5 text-right">
                        <div class="btn-group  btn-group-sm edit-area" role="group">
                            <button type="button" class="btn btn-success add"
                                onClick="add_q_form('<?= $uoc_code ?>','<?= $eoc_code ?>','<?= $i ?>')">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            </button>
                            <!--<button type="button" class="btn btn-danger del" id="btn_del_q_form" name="btn_del_q_form"
                                onClick="rm_dynamic_uiform('<?= $uoc_code ?>','<?= $eoc_code ?>','<?= $i ?>')">
                                <i class="fa fa-minus-circle" aria-hidden="true"></i>
                            </button>-->
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-body row">
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
                            name="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][question]"></textarea>
                    </div>
                    <div class=" col-md-6">
                        <label for=""><strong>แนวทางคำตอบ</strong></label>
                        <textarea class="ckeditor cka" id="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][answer]"
                            name="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][answer]"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php  } ?>