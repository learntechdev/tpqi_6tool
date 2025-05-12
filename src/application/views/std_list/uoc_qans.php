<div class="col-md-12">
    <label class="col-form-label"><strong>หน่วยสมรรถนะ</strong></label>
    <?php
		if (is_array($uoc)) {
			$n = 0;
			$last_key = count($uoc);
			$tmp_std_id = "";
			$tmp_n = "";
			$tmp_template_id = $template;
			foreach ($uoc as $v) {
				$n++;
				$isValid = $this->SharedModel->chk_tp_uoc_qans($tmp_template_id, $v->uoc_id);
			?>
    <div class="card-header-custom">
        <div data-toggle="collapse" data-target="#col<?=$n?>" onclick="toggle_row('<?=$v->uoc_id?>','<?=$n?>')"
            id="btn_eoc<?=$n?>">
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
            <span id="toggle_row<?=$n?>">+</span>
            <span class="uoc" id="uoc_title<?=$n?>" name="uoc_title<?=$n?>">
                <?=$v->uoc_code?> : <?=$v->uoc_name?>
            </span>
        </div>
    </div>

    <div class="accordian-body collapse" id="col<?=$n?>" style="padding:5px">
        <div id="div_q_ans" class="row">
            <?php $this->load->view("templates/q_ans",
						array(
						"initial" => '1',
						"uoc_code" => $v->uoc_id,
						"template_id" => $tmp_template_id,
						"asm_tool" => $asm_tool,
					));?>
        </div>
    </div>

    <?php }
		} ?>
    <input type="hidden" class="form-control" id="last_idx_uoc" name="last_idx_uoc" value="" />
</div>