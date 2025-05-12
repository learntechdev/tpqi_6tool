<?php require_once dirname(__FILE__) . "../../layout/header.php"; ?>

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

                <span>
                    <?php echo $display_icon; ?>
                </span>

                <span id="toggle_row_eoc<?= $n ?><?= $j ?>">+</span>
                <span class="uoc" id="uoc_title<?= $n ?><?= $j ?>" name="uoc_title<?= $n ?><?= $j ?>">
                    <?= $v->uoc_code ?> : <?= $v->uoc_name ?>
                </span>
            </div>
        </div>

        <div class="accordian-body collapse" id="col_eoc<?= $n ?><?= $j ?>" style="padding:5px">
            <div id="div_q_ans">
                <?php $this->load->view(
                            "templates/q_ans_grp",
                            array(
                                "initial" => '1',
                                "uoc_code" => $v->uoc_id,
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
<?php require_once dirname(__FILE__) . "../../layout/footer.php"; ?>