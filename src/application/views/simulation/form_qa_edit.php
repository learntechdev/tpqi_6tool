<div class="col-md-12">
    <?php
$tmp_tp_id = "";
$rs_detail = "";
if (isset($_GET['template_id'])) {
    $tmp_tp_id = $_GET['template_id'];
    $rs_detail = $this->SimulationToolsModel->get_template_detail($tmp_tp_id);
} else {
    $tmp_tp_id = '';
}
?>

    <div id="form_q_a">
        <?php
if (is_array($rs_detail)) {
    $count_row = count($rs_detail);
    $i = 1;
    ?>
        <input type="text" id="last_idx" name="last_idx" value="<?=$count_row?>">
        <?php
foreach ($rs_detail as $v_detail) {
        ?>

        <div id="f<?=$i?>">
            <div class="card">
                <div class="text-right" style="padding-right:10px;padding-top:10px">
                    <div class="btn-group  btn-group-sm" role="group">
                        <button type="button" class="btn btn-success" onClick="add_q_form(<?=$i?>)">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-danger" id="btn_del_q_form" name="btn_del_q_form"
                            onClick="removeDynamicUIFormQA(<?=$i?>)">
                            <i class="fa fa-minus-circle" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <hr>
                <div class="card-body row">
                    <div class="col-md-6">
                        <label for=""><strong>คำถาม ข้อที่ <?=$i?>.<span id="q_num"></span></strong></label>
                        <textarea id="list[<?=$i?>][question]"
                            name="list[<?=$i?>][question]"><?=$v_detail->question?></textarea>
                        <script type="text/javascript">
                        CKEDITOR.replace('list[<?=$i?>][question]', {
                            fullPage: true,
                            allowedContent: true,
                            extraPlugins: 'wysiwygarea',
                            filebrowserBrowseUrl: '/browser/browse.php',
                            filebrowserUploadUrl: '/uploader/upload.php'
                        });
                        </script>
                    </div>
                    <div class=" col-md-6">
                        <label for=""><strong>เฉลย</strong></label>
                        <textarea id="list[<?=$i?>][answer]"
                            name="list[<?=$i?>][answer]"><?=$v_detail->answer?></textarea>
                        <script type="text/javascript">
                        CKEDITOR.replace('list[<?=$i?>][answer]', {
                            fullPage: true,
                            allowedContent: true,
                            extraPlugins: 'wysiwygarea',
                            filebrowserBrowseUrl: '/browser/browse.php',
                            filebrowserUploadUrl: '/uploader/upload.php'
                        });
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <?php
$i++;
    }
}
?>
    </div>

</div>