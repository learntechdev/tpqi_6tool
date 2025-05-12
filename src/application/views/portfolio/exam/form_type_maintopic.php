<style>
.valid {
    border-style: solid;
    border-color: red;
}
</style>
<form id="form" name="form">
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <table width="100%" class="table table-bordered">
                    <thead>
                        <tr style="background-color:#cccccc;">
                            <th scope="col" class="text-center" style="width:30%"><b>รายการเอกสาร</b> </th>
                            <th scope="col" class="text-center" style="width:30%"><b>อัพโหลดเอกสาร</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4">
                                <span style="color:red;font-size:14px">
                                    <b> ไฟล์ที่อัพโหลดขนาดไม่เกิน 20 Mb. ไฟล์นามสกุล pdf, jpg, png, ppt, pptx,
                                        xlsx, xls, doc, docx, mp4 </b>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                    <?php $i = 0;
                    $maintopic_ = '';
                    foreach ($blueprint_detail as $row) {
                    ?>
                    <tbody>
                        <?php if ($maintopic_ != $row->maintopic) { ?>
                        <tr>
                            <td colspan="4" style="background-color:#cccccc;">
                                <b><?= $row->maintopic ?> </b>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php $maintopic_ = $row->maintopic; ?>
                        <tr>
                            <td colspan="1">
                                <?= $i + 1 . ') ' . $row->subtopic ?>
                            </td>
                            <td colspan="2">
                                <input type="hidden" name="list[<?= $i ?>][tp_checklist_id]" value="">
                                <input type="hidden" name="list[<?= $i ?>][exam_schedule_id]"
                                    value="<?= $exam_schedule_id ?>">
                                <input type="hidden" class="valid" name="list[<?= $i ?>][blueprint_id]"
                                    value="<?= $row->blueprint_id ?>">
                                <input type="hidden" name="list[<?= $i ?>][maintopic_id]"
                                    value="<?= $row->maintopic_id ?>">
                                <input type="hidden" name="list[<?= $i ?>][subtopic_id]"
                                    value="<?= $row->subtopic_id ?>">
                                <input type="hidden" name="list[<?= $i ?>][order_line]" value="<?= $row->order_line ?>">
                                <input type="hidden" name="list[<?= $i ?>][app_id]" value="<?= $app_id ?>">
                                <input type="file" class="file" id="list[<?= $i ?>][file]" value=''>
                                <input type="hidden" name="list[<?= $i ?>][uoc_code]" value="">
                                <input type="hidden" name="list[<?= $i ?>][file_old]"
                                    value="<?= isset($row->file) ? $row->file : '' ?>">
                                <span style="color:red" name="list[<?= $i ?>][file]"> </span>
                                <?php if (isset($row->file)) { ?><br>
                                ไฟล์ปัจจุบัน : <a
                                    href="<?= base_url() . 'portfolio_file/' ?><?= isset($row->app_id) ? $row->app_id : '' ?>/<?= isset($row->file) ? $row->file : '' ?>"
                                    target="_blank">
                                    <?= isset($row->file) ? $row->file : '' ?>
                                </a>
                                <?php } ?>
                            </td>
                        </tr>
                    </tbody>
                    <?php $i++;
                    } ?>
                </table>
            </div>
            <input type="hidden" id="num_input" value="1">
</form>
<div class="col-md-12" style="padding-top:20px;padding-bottom:20px">
    <div class="row">
        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                <strong>บันทึก</strong> </button>
            <button type="button" class="btn btn-secondary" onClick="goto_person_assessment()">
                <i class="fa fa-arrow-circle-left" style="color:#fff"></i>
                <strong>กลับ</strong>
            </button>
        </div>
    </div>
</div>

</div>
</div>



<script type="text/javascript" src="<?= base_url(); ?>assets/custom_js/portfolio/person_form.js?<?= date("YmdHis") ?>">
</script>