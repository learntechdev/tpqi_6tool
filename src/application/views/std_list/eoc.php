<div class="col-md-12">
    <label class="col-form-label"><strong>หน่วยสมรรถนะ</strong></label>
    <?php
    if (is_array($uoc)) {
        $n = 0;
        $last_key = count($uoc);
        $tmp_std_id = "";
        $tmp_n = "";
        $tmp_template_id = $template;
        foreach ($uoc as $u) {
            $n++;

    ?>

    <div class="card-header-custom-title-uoc">
        <i class="fa fa-th-list"></i>
        <b> <?= $u->uoc_code ?> : <?= $u->uoc_name ?></b>
    </div>
    <?php
            $eoc = $this->MasterDataModel->get_tpqi_eoc($u->occ_level_id, $u->uoc_id);
            if (is_array($eoc)) {
                $j = 0;
                foreach ($eoc as $v) {
                    $j++;
            ?>

    <div class="card-header-custom">
        <div data-toggle="collapse" data-target="#col_eoc<?= $n ?><?= $j ?>"
            onclick="toggle_row_eoc('<?= $u->uoc_code; ?>','<?= $v->eoc_id; ?>','<?= $n ?>','<?= $j ?>')"
            id="btn_eoc<?= $n ?><?= $j ?>">
            <?php
                            $isValid = $this->SharedModel->ck_template_uoc($tmp_template_id, $u->uoc_id, $v->eoc_id, $asm_tool);
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
            <span class="eoc" id="eoc_title<?= $n ?><?= $j ?>" name="eoc_title<?= $n ?><?= $j ?>">
                <?= $v->eoc_code ?> : <?= $v->eoc_name ?>
            </span>
        </div>
    </div>

    <div class="accordian-body collapse" id="col_eoc<?= $n ?><?= $j ?>" style="padding:5px">
        <div id="div_q_ans">
            <?php
                            $this->load->view(
                                "templates/q_ans",
                                array(
                                    "initial" => '1',
                                    "uoc_code" => $v->uoc_id,
                                    "eoc_code" => $v->eoc_id,
                                    "template_id" => $tmp_template_id,
                            "asm_tool" => $asm_tool,
                            "default_score" => $default_score,
                                )
                            );
                            ?>
        </div>
    </div>
    <?php   } ?>
    <?php } ?>
    <br />
    <?php }
    } ?>
</div>