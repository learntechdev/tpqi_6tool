    <label for="">คุณวุฒิวิชาชีพ</label>
    <select class="form-control occ_level select2 w-p100" data-dropup-auto="false" id="occ_level_id" name="occ_level_id"
        required="" data-live-search="true">
        <option value="">--ทั้งหมด--</option>
        <?php
$tmp_occ_level = $this->MasterDataModel->get_occ_level();
foreach ($tmp_occ_level as $v) {?>
        <option value="<?php echo $v->id, ":" . $v->id; ?>">
            <?php echo $v->occ_level; ?>
        </option>';
        <?php }?>
    </select>