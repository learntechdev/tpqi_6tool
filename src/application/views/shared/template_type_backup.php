<div class="row">
    <label class="col-md-2 col-form-label">
        UOC/EOC
    </label>

    <div class="col-md-6" style="padding-bottom:5px">
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
        <select class="form-control exam_type" data-dropup-auto="false" id="exam_type" name="exam_type" required=""
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

<div class="row">
    <label class="col-md-2 col-form-label">
        รูปแบบข้อสอบ
    </label>
    <div class="col-md-6" style="padding-bottom:5px">
        <select class="form-control template_type" data-dropup-auto="false" id="template_type" name="template_type"
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