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

        // print_r($dataForEdit);

        $template_detail1 = "";
        if ($dataForEdit["resultDetail"] != null) {
            $template_detail1 = $dataForEdit["resultDetail"];
        } else {
            $template_detail1 = $template_detail;
        }

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
                    } ?>

            <tr>
                <input type="hidden" class="form-control"
                    name="list[<?= $v_detail->uoc_code ?>][<?= $v_detail->eoc_code ?>][<?= $k ?>][template_detail_id]"
                    value="<?= $v_detail->template_detail_id ?>" />
                <td style="font-family:THSarabunNew;font-size:16px">
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
                    <input style=" width: 100%; height: 1.5em; margin-top:10px" type="radio"
                        id="list[<?= $v_detail->uoc_code ?>][<?= $v_detail->eoc_code ?>][<?= $k ?>][score]"
                        name="list[<?= $v_detail->uoc_code ?>][<?= $v_detail->eoc_code ?>][<?= $k ?>][score]" checked
                        value="1"
                        <?php if ($strScore == "1") {
                                                                                                                                                                                                                                                                                                        echo 'checked="checked"';
                                                                                                                                                                                                                                                                                                    } ?>>
                </td>
                <td align="center">
                    <input style=" width: 100%; height: 1.5em; margin-top:10px" type="radio"
                        id="list[<?= $v_detail->uoc_code ?>][<?= $v_detail->eoc_code ?>][<?= $k ?>][score]"
                        name="list[<?= $v_detail->uoc_code ?>][<?= $v_detail->eoc_code ?>][<?= $k ?>][score]"
                        <?php if ($strScore == "0") {
                                                                                                                                                                                                                                                                                    echo 'checked="checked"';
                                                                                                                                                                                                                                                                                } ?>
                        value="0">
                </td>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <?php $this->load->view(
                                "richtext/richtext",
                                array(
                                    "id" => "list[$v_detail->uoc_code][$v_detail->eoc_code][$k][answer]",
                                    "data" => $strAnswer
                                )
                            ); ?>
                </td>
            </tr>

            <tr>
                <td colspan="4" class="text-right">
                    <div class="btn-group btn-group-sm  " role="group"
                        id="div_sound<?= $v_detail->template_detail_id ?>">
                        <?php if ($dataForEdit["resultDetail"] != null) { ?>
                        <audio controls id="sound_play<?= $v_detail->template_detail_id ?>" class="audio">
                            <?php
                                        $pathEvident = "../../" . $v_detail->filename; ?>
                            <source src="<?= $pathEvident ?>" type="audio/wav">
                        </audio>
                        <?php } ?>
                    </div>
                    <div class="btn-group  btn-group-sm" role="group">
                        <button style="padding:7px" type="button" class="btn btn-warning" id="btn_record"
                            name="btn_record"
                            onClick="show_dialog_recorder('<?= $v_detail->template_detail_id ?>','<?= $v_detail->uoc_code ?>','<?= $v_detail->eoc_code ?>','<?= $_POST['app_id'] ?>')">
                            <i class="fa fa-microphone" aria-hidden="true"></i> บันทึกเสียง</button>
                    </div>
                    <div class="btn-group  btn-group-sm" role="group">
                        <button style="padding:7px" type="button" class="btn btn-success" id="btn_record"
                            name="btn_record"
                            onClick="show_dialog_upload('<?= $v_detail->template_detail_id ?>','<?= $v_detail->uoc_code ?>','<?= $v_detail->eoc_code ?>','<?= $_POST['app_id'] ?>')">
                            <i class="fa fa-upload" aria-hidden="true"></i> อัพโหลดเสียง</button>
                    </div>
                </td>
            </tr>
        </tbody>

        <?php

            }
        }

        ?>

    </table>
    <br />
    <?php require_once dirname(__FILE__) . "../../../shared/assessment_result_notcriteria.php"; ?>
</div>

<br />