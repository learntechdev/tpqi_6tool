<?php $list_uoc = $this->MasterDataModel->fetch_uoc($_POST["occ_level_id"]);
	$x = count($list_uoc);
?>
<div class="overlay" id="overlay"></div>
    <div class="popup" id="popup">
        <h2>Select Options</h2>
        <form id="checkboxForm">
		<?php	foreach ($list_uoc as $v) { 
		//	if($uoc_list_code != $v->uoc_code) { 
			?>
            <label><input type="checkbox" name="options[]" value="<?php echo $v->uoc_id ?>">&nbsp;&nbsp; &nbsp; <?php echo $v->uoc_code ?>&nbsp;&nbsp; <?php echo $v->uoc_name ?></label><br>
        <?php
//		}
		}?>
            <button type="button" id="submitPopup">Submit</button>
            <button type="button" id="closePopup">Close</button>
        </form>
    </div>

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
        //เช็คว่ามีข้อมูล uoc นี้ข้อสอบหรือยัง
        $isValid = $this->SharedModel->chk_template_uoc($tmp_template_id, $v->uoc_id);
        ?>

    <div class="card-header-custom">
        <div data-toggle="collapse" data-target="#col<?=$n?>" onclick="toggle_row(<?=$n?>)" id="btn_eoc<?=$n?>">
            <?php
                if ($isValid == 1) {
                    $display_icon = " <i class='fa fa-check-circle' aria-hidden='true' style='color:green'></i>";
                } else {$display_icon = "";}
            ?>

            <span><?php echo $display_icon; ?></span>
            <span id="toggle_row<?=$n?>">+</span>
            <span class="uoc" id="uoc_title<?=$n?>" name="uoc_title<?=$n?>">
                <?=$v->uoc_code?> : <?=$v->uoc_name?>
            </span>
        </div>
    </div>

    <div class="accordian-body collapse" id="col<?=$n?>" style="padding:5px">
        <div id="div_checklist">
            <?php
        if ($tmp_n != $n) {
            $this->load->view("templates/chklist_uoc_maintopic",
                array(
                    "initial" => '1',
                    "uoc_code" => $v->uoc_id,
					"uoc_list_code" => $v->uoc_code,
					"x" => $x,
                    "template_id" => $tmp_template_id,
                ));
            $tmp_n = $n;
        }
        ?>
        </div>
    </div>
    <?php }
}
?>
    <div>
        <input type="hidden" class="form-control" id="last_idx_uoc" name="last_idx_uoc" value="<?=$last_key?>" />
    </div>
</div>