<?php
foreach ($dataList as $key => $f) {
    $path = "docs_forexam/" . $f->template_id . "/";
?>
<a style="color:cornflowerblue" href="<?= base_url() . $path .  $f->docs_filename ?>"
    target="_blank"><?= $f->docs_filename ?> </a><br />
<?php } ?>