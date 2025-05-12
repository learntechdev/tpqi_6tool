<style>
.uoc_tile_active {
    font-weight: bold;
}

.uoc_title_notactive {
    font-weight: normal;
}
</style>

<div class="col-md-12">
    <label class="col-form-label"><strong>หน่วยสมรรถนะ</strong></label>
    <?php 
if (is_array($uoc)) {
    $j=0;
    $last_key = count($uoc);
foreach ($uoc as $v) {
    $j++;
    
    if(isset($_SESSION['template_id']) && !empty($_SESSION['template_id'])) {
        $tmp_template_id = $_SESSION['template_id'];
     }else {
         $_SESSION['template_id'] ="";
     }

    //เช็คว่ามีข้อมูล uoc นี้หรือยัง
    $isValid = $this->InterviewModel->ck_template_uoc($_SESSION['template_id'],$v->stdID);
    
    ?>
    <div class="card-header-custom">
        <div class="collapsed" data-toggle="collapse" data-target="#uoc_col<?=$j?>" aria-expanded="true"
            onclick="toggle_uoc_row(<?=$j?>,<?=$v->stdID?>)" id="btn_uoc<?=$j?>">
            <?php 
            if($isValid== 1){
                $display_icon = " <i class='fa fa-check-circle' aria-hidden='true' style='color:green'></i>";
              
            }else {
                $display_icon ="";
            }
            ?>
            <span>
                <?=$display_icon?>
            </span>

            <span id="toggle_uoc_row<?=$j?>">+</span>
            <span class="uoc" id="uoc_title<?=$j?>" name="uoc_title<?=$j?>">
                <?=$v->stdID?>( <?=$v->stdCode?> ) : <?=$v->stdName?>
            </span>

        </div>
    </div>
    <?php }
}
?>
    <div>
        <input type="hidden" class="form-control" id="last_idx_uoc" name="last_idx_uoc" value="<?= $last_key?>" />
    </div>

</div>