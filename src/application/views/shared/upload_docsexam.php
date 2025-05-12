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
<!--		<input type="file" class="file" id="files" value="" name="files[]" multiple>  -->
        <?php if (isset($_SESSION["fileName"]) && $_SESSION["fileName"] != "") { 
				$uploaded_files = $_SESSION["fileName"];
				$count_of_files = count($uploaded_files);
				foreach ($uploaded_files as $index => $file) {
					echo "<input type='button' class='file' onClick='' id='" . ($index + 1) . "' value='" . htmlspecialchars($file) . "' name='" . ($index + 1) . "' ><br>";
				} ?>
			<input type="hidden" id="count_of_files" name="count_of_files" value="<?=$count_of_files ?>">
<?php $_SESSION["fileName"] = [];
		}?>
		
		<input type="button" class="file" onClick="fileManager()" id="files" value="Manage Files" name="files[]" multiple>
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