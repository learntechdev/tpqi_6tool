<style>
.valid {
    border-style: solid;
    border-color: red;
}
</style>

<div class="row">
    <br />
    <div class="col-md-12">
        <b> รายการแฟ้มสะสมผลงาน </b>
    </div>
    <div class="col-md-12">
        <form id="form" name="form">
            <input type="hidden" name="form_type" id="form_type" value="<?= $action ?>">
            <div class="col-md-12">
                <table width="100%" class="table table-bordered">
                    <tr style="background-color:#cccccc;">
                        <td style="width:65%">รายการเอกสาร</b>
                        </td style="width:35%">
                        <td>อัพโหลดเอกสาร</td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <span style="color:red;font-size:14px">
                                <b> ไฟล์ที่อัพโหลดขนาดไม่เกิน 50 Mb. ไฟล์นามสกุล pdf, jpg, png, ppt, pptx,
                                    xlsx, xls, doc, docx, mp4 </b>
                            </span>
                            <input type="hidden" id="exam_schedule_id" name="exam_schedule_id"
                                value="<?= $exam_schedule_id ?>">

                        </td>
                    </tr>
                    <?php
                    if (is_array($blueprint_detail)) {
                        $tmp_uoc_code = "";
                        $i = 1;
                        $j = 0;
                        foreach ($blueprint_detail as $row) {
                            $i++;
                            $j++;
                    ?>
                    <?php
                            if ($tmp_uoc_code != trim($row->uoc_code)) {

                            ?>
                    <tr>
                        <td colspan="3" style="background-color:#F1F1F1">
                            <?php $rs = $this->SharedModel->get_uocname($row->uoc_code); ?>
                            <strong><?php echo "หน่วยสมรรถนะ : " . $row->uoc_code . " " . $rs["uoc_name"]; ?></strong>
                        </td>
                    </tr>
                    <?php
                                $tmp_uoc_code = trim($row->uoc_code);
                                $i = 1;
                            } ?>
                    <tbody>
                        <tr>
                            <td colspan="1">
                                <?= $i  . '. ' . $row->main_topic ?>
                            </td>
                            <td colspan="2">
                                <?php
                                        $strFolder = "portfolio_file";
                                        $pathFile = "";
                                        if (isset($row->file)) {
                                            $pathFile =  base_url() . $strFolder . '/' . $row->app_id . '/' .  $row->file;
                                        }

                                        ?>
                                <input type="hidden" id="blueprint_id" name="blueprint_id"
                                    value="<?= $row->blueprint_id ?>">
                                <input type="hidden" id="app_id" name="app_id" value="<?= $app_id ?>">
                                <input type="hidden" name="list[<?= $j ?>][tp_checklist_id]" value="<?= $row->id ?>">
                                <input type="hidden" name="list[<?= $j ?>][uoc_code]" value="<?= $row->uoc_code ?>">
                                <input type="hidden" name="list[<?= $j ?>][order_line]" value="<?= $i ?>">
                                <input type="hidden" name="list[<?= $j ?>][maintopic_id]" value="">
                                <input type="hidden" name="list[<?= $j ?>][subtopic_id]" value="">
                                <input type="file" class="file" id="list[<?= $i ?>][<?= $row->id ?>][file]" value=""
                                    name="list[<?= $i ?>][<?= $row->id ?>][file]">
                                <span style="color:red" name="list[<?= $i ?>][file]"> </span>

                                <input type="hidden" name="list[<?= $i ?>][file_old]" id="list[<?= $i ?>][file_old]"
                                    value="<?= isset($row->file) ? $row->file : '' ?>">


                                <?php if (isset($row->file)) { ?>
                                <div style="color:cornflowerblue">
                                    ไฟล์ปัจจุบัน : <a style="color:cornflowerblue"
                                        href="<?= base_url() . 'portfolio_file/' ?><?= isset($row->app_id) ? $row->app_id : '' ?>/<?= isset($row->file) ? $row->file : '' ?>"
                                        target="_blank">
                                        <?= isset($row->file) ? $row->file : '' ?>
                                    </a>
                                </div>
                                <?php } ?>

                            </td>
                        </tr>
                    </tbody>
                    <?php

                        }
                    } ?>
                </table>

            </div>

            <div id="uploadsts">
            </div>
            <input type="hidden" id="num_input" value="1">

            <div class="col-md-12" style="padding-top:20px;padding-bottom:20px">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i>
                            <strong>บันทึก</strong> </button>
                        <button type="button" class="btn btn-secondary" onClick="goto_person_assessment()">
                            <i class="fa fa-arrow-circle-left"></i>
                            <strong>กลับ</strong>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <?php //require_once dirname(__FILE__) . "../../../modal/modal_uploadfile.php"; 
        ?>
    </div>
</div>

<script type="text/javascript" src="<?= base_url(); ?>assets/custom_js/portfolio/person_form.js?<?= date("YmdHis") ?>">
</script>