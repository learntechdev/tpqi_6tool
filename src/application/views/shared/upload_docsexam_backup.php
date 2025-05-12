<?php
$tmp_tp_id = "";
if (isset($_POST['template_id'])) {
    $_SESSION['template_id'] = $_POST['template_id'];
    $tmp_tp_id = $_POST['template_id'];

    $files = $this->SharedModel->getDocsFiles($tmp_tp_id);
} else {
    $_SESSION['template_id'] = '';
    $tmp_tp_id = '';
    $files = null;
}
?>

<div class="row">
    <label class="col-md-2 col-form-label">
        เอกสารเพิ่มเติม
    </label>
    <div class="col-md-6" style="padding-bottom:5px">
        <input type="file" class="file" id="files" value="" name="files[]" multiple>
		
        <?php if (!empty($files)) { ?>
        <div style="color:cornflowerblue">
            ไฟล์ปัจจุบัน :
            <?php

                foreach ($files as $f) {
                    $path = "docs_forexam/" . $f->template_id . "/";
                ?>
            <a style="color:cornflowerblue" href="<?= base_url() . $path .  $f->docs_filename ?>"
                target="_blank"><?= $f->docs_filename ?> </a><br />
            <?php }

                ?>
        </div>
        <?php  } ?>
    </div>
</div>