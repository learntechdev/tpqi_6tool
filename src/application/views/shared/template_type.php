<div class="d-flexs">
<div class="sub-container" style="width: 50%; padding-bottom: 5px;">
    <label class="form-label newtypelabel">
        UOC/EOC
    </label>

        <?php
        if (isset($_POST["asm_tool_type"])) {
            $tool_type = $_POST["asm_tool_type"];
        } else {
            $tool_type = "";
        }

        $exam_type = $this->MasterDataModel->exam_type($tool_type);
        if (is_array($exam_type)) {
        ?>

        <input type="hidden" id="txt_asm_tool" name="txt_asm_tool" value="<?= $_POST["asm_tool_type"] ?>">
        <select class="form-control exam_type" data-dropup-auto="true" id="exam_type" name="exam_type" required=""
            data-live-search="true">
            <option value="0">
                --กรุณาเลือก--
            </option>

            <?php foreach ($exam_type as $v_exam) { ?>
            <option value="<?php echo $v_exam->exam_type ?>">
                <?php echo $v_exam->name; ?>
            </option>
            <?php }
            }
            ?>
        </select>
        <input type="hidden" id="txt_exam_type" name="txt_exam_type">
    </div>
</div>

<div class="d-flexs">
<div class="sub-container" style="width: 50%; padding-bottom: 5px;">
    <label class="form-label newtypelabel">
        รูปแบบข้อสอบ
    </label>
        <select class="form-control template_type" data-dropup-auto="true" id="template_type" name="template_type"
            required="" data-live-search="true">
            <option value="0">
                --กรุณาเลือก--
            </option>
        </select>
        <input type="hidden" id="txt_template_type" name="txt_template_type">
    </div>
</div>

<script type="text/javascript" src="<?= base_url(); ?>assets/custom_js/shared/template_type.js?<?= date("YmdHis") ?>">
</script>