<div class="col-md-12">
    <strong>การประเมินผล</strong>
</div>
<div class="col-md-12">
    <table id="tb" border="1" width="100%" style="border-collapse: collapse;padding:10px">
        <thead>
            <tr style="background:#CFCFCF">
                <th rowspan="2" width="40%" style="text-align:center;font-weight:bold">คำถาม</th>
                <th rowspan="2" width="40%" style="text-align:center;font-weight:bold">แนวทางคำตอบ</th>
                <th colspan="2" style="width:10%;text-align:center;font-weight:bold">การประเมิน</th>
            </tr>
            <tr style="background:#CFCFCF">
                <th style="width:5%;text-align:center;font-weight:bold">ผ่าน</th>
                <th style="width:5%;text-align:center;font-weight:bold">ไม่ผ่าน</th>
            </tr>
        </thead>

        <input type="hidden" name="uoc_code_count" id="uoc_code_count" value="<?= count($template_detail) ?>">

        <?php
        // เช็คว่ามีข้อมูลที่เคยประเมินหรือยัง?
        $dataForEdit = $this->AssessmentResultModel->getAssResultDetail(
            $_POST["exam_schedule_id"],
            $_POST['tool_type'],
            $_POST["app_id"],
            $_POST["template_id"]
        );

        $template_detail1 = "";
        $evident = "";
        if ($dataForEdit["resultDetail"] != null) {
            $template_detail1 = $dataForEdit["resultDetail"];
            $evident = $dataForEdit["evident"];
        } else {
            $template_detail1 = $template_detail;
            $evident = "";
        }

        // print_r($dataForEdit["evident"]);

        if (is_array($template_detail1)) {
            $tmp_uoc_code = "";
            $tmp_eoc_code = "";
            $j = 1;
            $k = 1;
            foreach ($template_detail1 as $v_detail) {
                $uoc_code = $this->SharedModel->get_uocname($v_detail->uoc_code);
                $j++;
                $k++;
        ?>

        <?php if ($tmp_uoc_code != $v_detail->uoc_code) { ?>

        <tr>
            <td colspan="4" style="background-color:#F1F1F1">
                <strong>
                    <?php echo "หน่วยสมรรถนะ : " ?> <?= $uoc_code["uoc_id"] ?> <?= $uoc_code["uoc_name"]; ?>
                </strong>
            </td>
        </tr>

        <?php
                    $tmp_uoc_code = $v_detail->uoc_code;
                    $j = 1;
                } ?>

        <tbody>
            <?php
                    if ($v_detail->eoc_code != 0) {
                        if ($tmp_eoc_code != $v_detail->eoc_code) { ?>
            <tr>
                <td colspan="4" style="font-style: italic">
                    <?php
                                    $rs = $this->SharedModel->get_eocname($v_detail->eoc_code)
                                    ?><strong><?php echo "หน่วยสมรรถนะย่อย : " . $rs["eoc_code"] . " " . $rs["eoc_name"]; ?></strong>
                </td>
            </tr>
            <?php
                            $tmp_eoc_code = $v_detail->eoc_code;
                            $k = 1;
                        }
                    } ?>

            <tr>

                <td style="font-family:THSarabunNew;font-size:16px">
                    <input type="hidden" class="form-control"
                        name="list[<?= $v_detail->uoc_code ?>][<?= $v_detail->eoc_code ?>][<?= $k ?>][template_detail_id]"
                        value="<?= $v_detail->template_detail_id ?>" />

                    <?php echo $j . "." . " " . ($v_detail->question); ?>
                </td>
                <td style="font-family:THSarabunNew;font-size:16px">
                    <?php //echo strip_tags($v_detail->guide_answer);
                            echo $v_detail->guide_answer;
                            ?>
                </td>
                <input type="hidden" class="form-control"
                    name="list[<?= $v_detail->uoc_code ?>][<?= $v_detail->eoc_code ?>][<?= $k ?>][order_line]"
                    value="<?= $k ?>" />
                <input type="hidden" class="form-control"
                    name="list[<?= $v_detail->uoc_code ?>][<?= $v_detail->eoc_code ?>][<?= $k ?>][uoc_code]"
                    value="<?= $v_detail->uoc_code ?>" />
                <input type="hidden" class="form-control"
                    name="list[<?= $v_detail->uoc_code ?>][<?= $v_detail->eoc_code ?>][<?= $k ?>][eoc_code]"
                    value="<?= $v_detail->eoc_code ?>" />

                <td align="center">
                    <?php
                            $strAnswer = "";
                            $strScore = "";
                            if ($dataForEdit["resultDetail"] != null) {
                                $strScore = $v_detail->score;
                                $strAnswer =  $v_detail->answer;
                            } else {
                                $strScore = "";
                                $strAnswer = "";
                            }
                            ?>
                    <input class="chk_score" style=" width: 100%; height: 1.5em; margin-top:10px" type="radio"
                        id="list[<?= $v_detail->uoc_code ?>][<?= $v_detail->eoc_code ?>][<?= $k ?>][score]"
                        name="list[<?= $v_detail->uoc_code ?>][<?= $v_detail->eoc_code ?>][<?= $k ?>][score]" value="1"
                        checked
                        <?php if ($strScore == "1") {
                                                                                                                                                                                                                                                                                                                        echo 'checked="checked"';
                                                                                                                                                                                                                                                                                                                    } ?>>
                </td>
                <td align="center">
                    <input class="chk_score" style=" width: 100%; height: 1.5em; margin-top:10px" type="radio"
                        id="list[<?= $v_detail->uoc_code ?>][<?= $v_detail->eoc_code ?>][<?= $k ?>][score]"
                        name="list[<?= $v_detail->uoc_code ?>][<?= $v_detail->eoc_code ?>][<?= $k ?>][score]" value="0"
                        <?php if ($strScore == "0") {
                                                                                                                                                                                                                                                                                                                echo 'checked="checked"';
                                                                                                                                                                                                                                                                                                            } ?>>
                </td>
                </td>
            </tr>
        </tbody>

        <?php

            }
        }

        ?>

    </table>
    <br />
    <div class="">
        <strong>แนบเอกสาร</strong>
        <input type="hidden" id="num_input" value="<?= count($evident) ?>">
        <?php if ($evident != "") {
            $i = 0;
            foreach ($evident as $vEvident) {
        ?>
        <div class="row" id="row<?= $i ?>" style="padding-bottom:5px">
            <div class="col-md-3">
                <input type="text" class="form-control name-file" id="" name="" value="<?= $vEvident->name_file ?>">
                <input type="text" name="list[<?= $i ?>][pathfile_old]" value="<?= $vEvident->path_file ?>">

            </div>
            <div class="col-md-9">

                <?php
                        $strFolder = "";
                        if (isset($_POST['tool_type']) == '5') {
                            $strFolder = "demonstration_assessment_flie";
                        } else if (isset($_POST['tool_type']) == '4') {
                            $strFolder = "assessment_detail_simulation_file";
                        }

                        $pathFile =  base_url() . $strFolder . '/' . $v_detail->app_id . '/' . $vEvident->path_file;
                        ?>
                <input type="file" class="form-control-file file-data" id="file<?= $i ?>" value="<?= $pathFile ?>">
                <?= $pathFile ?>
                ไฟล์ปัจจุบัน : <a
                    href="<?= base_url() . $strFolder . '/' ?><?= $v_detail->app_id ?>/<?= $vEvident->path_file ?>"
                    target="_blank">
                    <?= $vEvident->path_file != '' ? $vEvident->path_file : '' ?>
                </a>
            </div>

        </div>
        <?php
                $i++;
            }
            ?>
        <?php } else { ?>
        <?php require_once dirname(__FILE__) . "/form_file_add.php"; ?>
        <?php  } ?>

        <div class="row row-form">
            <div class="col-md-12">
                <button type='button' class="btn btn-success add_more"><i class="fa fa-plus"></i></button>
            </div>
        </div>
    </div>
    <br />
    <?php require_once dirname(__FILE__) . "../../../shared/assessment_result_notcriteria.php"; ?>
</div>

<br />