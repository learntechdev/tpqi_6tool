<?php

$list_uoc = $this->MasterDataModel->fetch_uoc($_POST["occ_level_id"]);
$x = count($list_uoc);
?>
<div class="overlay" id="overlay"></div>
<div class="popup" id="popup">
    <h2>Select Options</h2>
    <form id="checkboxForm">
        <?php foreach ($list_uoc as $v) {
            //	if($uoc_list_code != $v->uoc_code) { 
        ?>
            <label><input type="checkbox" name="options[]" value="<?php echo $v->uoc_id ?>">&nbsp;&nbsp; &nbsp; <?php echo $v->uoc_code ?>&nbsp;&nbsp; <?php echo $v->uoc_name ?></label><br>
        <?php
            //		}
        } ?>
        <button type="button" id="submitPopup">Submit</button>
        <button type="button" id="closePopup">Close</button>
    </form>
</div>

<div class="row">

    <div class="col-md-12">
        <label class="col-form-label"><strong>หน่วยสมรรถนะ</strong></label>
        <?php

        if (is_array($uoc)) {
            $n = 0;
            $j = 0;
            $last_key = count($uoc);
            $tmp_std_id = "";
            $tmp_n = "";
            $tmp_template_id = $template;
            foreach ($uoc as $v) {
                $n++;
                $j++;


                //เช็คว่ามีข้อมูล uoc นี้ข้อสอบหรือยัง

                //  echo "asm_tool : " . $asm_tool;

                $isValid = $this->SharedModel->ck_template_uoc($tmp_template_id, $v->uoc_id, "", $asm_tool);
        ?>

                <div class="card-header-custom">
                    <div data-toggle="collapse" data-target="#col_eoc<?= $n ?><?= $j ?>"
                        onclick="toggle_row_eoc('<?= $v->uoc_id ?>','','<?= $n ?>', '<?= $j ?>')"
                        id="btn_eoc<?= $n ?><?= $j ?>">
                        <?php
                        if ($isValid == 1) {
                            $display_icon = " <i class='fa fa-check-circle' aria-hidden='true' style='color:green'></i>";
                        } else {
                            $display_icon = "";
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-7">
                                <span>
                                    <?php echo $display_icon; ?>
                                </span>
                                <span id="toggle_row_eoc<?= $n ?><?= $j ?>">+</span>
                                <span class="uoc" id="uoc_title<?= $n ?><?= $j ?>" name="uoc_title<?= $n ?><?= $j ?>">
                                    <?= $v->uoc_code ?> : <?= $v->uoc_name ?>
                                </span>
                            </div>
                            <div class="col-md-2">
                                <label class="checkbox-inline" style="font-size: small; font-weight: normal;">
                                    <input type="checkbox" id="optional_uoc<?= $n ?><?= $j ?>" name="optional_uoc<?= $n ?><?= $j ?>" value="0" style="position: relative;" disabled> UOC ทางเลือก
                                </label>
                            </div>
                            <div class="col-md-3" style="font-size: small; font-weight: normal;">
                                <label class="checkbox-inline" style="font-size: small; font-weight: normal;">
                                    <input type="checkbox" id="optional_uoc<?= $n ?><?= $j ?>" name="optional_uoc<?= $n ?><?= $j ?>" value="0" style="position: relative;"> กำหนดให้ UOC ต้องผ่าน
                                </label>

                                <input type="number" id="spin_input<?= $n ?><?= $j ?>" name="spin_input<?= $n ?><?= $j ?>" value="0" min="0" style="width: 30px; text-align: center;">
                                ข้อ
                            </div>
                        </div>

                    </div>
                </div>

                <div class="accordian-body collapse" id="col_eoc<?= $n ?><?= $j ?>" style="padding:5px">
                    <div id="div_q_ans">
                        <?php $this->load->view(
                            "templates/q_ans",
                            array(
                                "initial" => '1',
                                "uoc_code" => $v->uoc_id,
                                "uoc_list_code" => $v->uoc_code,
                                "eoc_code" => 0,
                                "template_id" => $tmp_template_id,
                                "asm_tool" => $asm_tool

                            )
                        ); ?>
                    </div>
                    <!--			<div class="" style="padding:5px;" id="div_save_pc">
                                            <button type="button" class="btn btn-primary" id="btn_save">
                                                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                                <strong>บันทึก</strong>
                                            </button>
                                        </div>

                                        <div class="" style="padding:5px" id="div_preview">
                                            <button type="button" class="btn btn-info" id="btn_preview">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                <strong>แสดงตัวอย่าง</strong>
                                            </button>
                                        </div>   -->

                </div>
        <?php }
        }
        ?>
        <div>
            <input type="hidden" class="form-control" id="last_idx_uoc" name="last_idx_uoc" value="" />
        </div>
    </div>
</div>