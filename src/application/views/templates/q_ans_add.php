<?php

$initial = 1;
$i = 1;
$list_uoc = $this->MasterDataModel->fetch_uoc($_POST["occ_level_id"]);
$x = count($list_uoc);
?>



<?php

for ($i = 1; $i <= 1; $i++) {
?>
    <div class="col-md-12">
        <div id="form_q_a<?= $uoc_code ?><?= $eoc_code ?>">
            <div id="f<?= $uoc_code ?><?= $eoc_code ?><?= $i ?>">
                <div class="card template">
                    <div class="row" style="padding-right:10px;padding-left:10px;padding-top:10px">
                        <div class="col-md-8">
                            <label for="">สถานะคำถาม เพิ่มใหม่</label>&nbsp; &nbsp; &nbsp;
                            <input type="radio" value="1" checked
                                id="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][question_status1]"
                                name="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][question_status]">
                            &nbsp; ใช้งาน &nbsp; &nbsp; &nbsp;
                            <input type="radio" value="0"
                                id="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][question_status2]"
                                name="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][question_status]">
                            &nbsp; ไม่ใช้งาน &nbsp; &nbsp; &nbsp;
                            <select data-dropup-auto="false" onChange="score_type()"
                                id="scoretype" name="scoretype" required=""
                                data-live-search="true">
                                <option value="0">--กรุณาเลือก--</option>
                                <option value="1">ผ่าน/ไม่ผ่าน</option>
                                <option value="2" selected>คะแนนผ่าน</option>
                            </select>

                            <input class="col-md-2 marks_for_q_new" style="display:inline" type="text" id="marks_for_q" name="marks_for_q" value="<?= $default_score ?>" placeholder="คะแนน" />


                        </div>
                        <div class="col-md-4 text-right">
                            <div class="btn-group  btn-group-sm edit-area" role="group">
                                <input type="hidden" id="count"
                                    name="count" value="<?= $x ?>">
                                <?php if ($x != 1) { ?>
                                    <input type="hidden" id="uoc_selected" name="uoc_selected" value="<?= $x ?>">
                                    <button type="button" class="btn btn-success2 add"
                                        onClick="" id="showPopup" data-uoc_code="<?= $uoc_code ?>">
                                        <i class="fa fa-plus-circle" aria-hidden="true"><label style="padding-left:2px;">UOC</label></i>
                                    </button>&nbsp; &nbsp; &nbsp;
                                <?php } ?>
                                <button type="button" class="btn btn-success add"
                                    onClick="add_q_form('<?= $uoc_code ?>','<?= $eoc_code ?>','<?= $i ?>')">
                                    <i class="fa fa-plus-circle" aria-hidden="true"><label style="padding-left:2px;">คำถาม</label></i>
                                </button>&nbsp; &nbsp; &nbsp;
                                <button type="button" class="btn btn-success3 add"
                                    onClick="add_q_grp_form('<?= $uoc_code ?>','<?= $eoc_code ?>','<?= $i ?>')">
                                    <!--    onClick="check_select_tp_grp('<? //= $uoc_code 
                                                                            ?>','<? //= $eoc_code 
                                                                                    ?>','<? //= $i 
                                                                                            ?>')"> -->
                                    <i class="fa fa-plus-circle" aria-hidden="true"><label style="padding-left:2px;">กลุ่มคำถาม</label></i>
                                </button>
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
                        <div class="col-md-12" style="padding:5px;">
                            <label for=""><strong>คำถาม ข้อที่ <span class="num_q<?= $uoc_code ?><?= $eoc_code ?>"
                                        id="q_num_<?= $uoc_code ?><?= $eoc_code ?><?= $i ?>">
                                        <?= $i ?></span></strong></label>
                            &nbsp; &nbsp; &nbsp;
                            <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#criteriaModal<?= $uoc_code ?><?= $eoc_code ?><?= $i ?>">
                                <i class="fa fa-list-alt"></i> เกณฑ์การให้คะแนน
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="criteriaModal<?= $uoc_code ?><?= $eoc_code ?><?= $i ?>" tabindex="-1" role="dialog" aria-labelledby="criteriaModalLabel<?= $uoc_code ?><?= $eoc_code ?><?= $i ?>" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document"> <!-- Added modal-dialog-centered -->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="criteriaModalLabel<?= $uoc_code ?><?= $eoc_code ?><?= $i ?>">เกณฑ์การให้คะแนน</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <textarea class="form-control" rows="5" name="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][criteria]" placeholder="พิมพ์เกณฑ์การให้คะแนนที่นี่..."><?= isset($v->criteria) ? $v->criteria : '' ?></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <br />
                            <textarea class="ckeditor ckq"
                                id="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][question]"
                                name="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][question]"></textarea>
                        </div>
                        <div class=" col-md-12">
                            <label for=""><strong>แนวทางคำตอบ</strong></label>
                            <textarea class="ckeditor cka" id="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][answer]"
                                name="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][answer]"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?= base_url(); ?>assets/custom_js/templates/q_ans_add.js?<?= date("YmdHis") ?>">
    </script>

<?php  } ?>