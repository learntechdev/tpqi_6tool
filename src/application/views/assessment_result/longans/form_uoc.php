<div class="col-md-12">
    <strong>การประเมินผล</strong>
</div>

<div class="col-md-12">
    <table id="tb" border="1" width="100%" style="border-collapse: collapse;">
        <thead>
            <tr style="background:#CFCFCF">
                <th width="45%" style="text-align:center;font-weight:bold">คำถาม
                </th>
                <th width="44%" style="text-align:center;font-weight:bold">แนวคำตอบ
                </th>
                <th width="11%" style="text-align:center;font-weight:bold">คะแนน
                </th>
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

        //print_r($dataForEdit);

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
            <td colspan="3" style="background-color:#F1F1F1">
                <strong>
                    <?php echo $uoc_code["uoc_id"] . " " . $uoc_code["uoc_name"]; ?>
                </strong>
            </td>
        </tr>

        <?php
                    $tmp_uoc_code = $v_detail->uoc_code;
                    $j = 1;
                } ?>

        <tbody>
            <?php
                    if (($v_detail->eoc_code != 0)) {
                        if ($tmp_eoc_code != $v_detail->eoc_code) {
                    ?>
            <tr>
                <td colspan="4" style="font-style: italic">
                    <?= $v_detail->eoc_code ?>
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
                    <?php echo $j . "." . " " . ($v_detail->question); ?>
                </td>
                <td style="font-family:THSarabunNew;font-size:16px">
                    <?php echo $v_detail->guide_answer; ?>
                </td>

                <td style="text-align:center">
                    <div class="col-md-12">
                        <input type="hidden" class="form-control"
                            name="list[<?= $v_detail->uoc_code ?>][<?= $v_detail->eoc_code ?>][<?= $k ?>][order_line]"
                            value="<?= $k ?>" />
                        <input type="hidden" class="form-control"
                            name="list[<?= $v_detail->uoc_code ?>][<?= $v_detail->eoc_code ?>][<?= $k ?>][uoc_code]"
                            value="<?= $v_detail->uoc_code ?>" />
                        <input type="hidden" class="form-control"
                            name="list[<?= $v_detail->uoc_code ?>][<?= $v_detail->eoc_code ?>][<?= $k ?>][eoc_code]"
                            value="<?= $v_detail->eoc_code ?>" />

                        <input type="number" class="form-control score" placeholder="กรอกคะแนน"
                            id="list[<?= $v_detail->uoc_code ?>][<?= $v_detail->eoc_code ?>][<?= $k ?>][score]"
                            name="list[<?= $v_detail->uoc_code ?>][<?= $v_detail->eoc_code ?>][<?= $k ?>][score]" />
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
    <div class="">
        <strong>แนบเอกสาร</strong>
        <input type="hidden" id="num_input" value="1">
        <div class="row" id="row0" style="padding-bottom:5px">
            <div class="col-md-3">
                <input type="text" class="form-control name-file" id="" name="" value="" placeholder="ชื่อไฟล์">
            </div>

            <div class="col-md-9">
                <input type="file" class="form-control-file file-data" id="file0">
            </div>
        </div>

        <div class="row row-form">
            <div class="col-md-12">
                <button type='button' class="btn btn-success add_more"><i class="fa fa-plus"></i></button>
            </div>
        </div>
    </div>
    <br />
    <?php require_once dirname(__FILE__) . "../../../shared/assessment_result.php";
    ?>
</div>

<br />