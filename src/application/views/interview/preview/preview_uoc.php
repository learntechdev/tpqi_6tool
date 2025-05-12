<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>เครื่องมือประเมิน แบบสัมภาษณ์</title>
    <!--
        <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/bootstrap.css" />
        -->

    <style>
    body {
        font-family: sans-serif;
        font-size: 18px;
    }

    .txt-title {
        font-size: 18px;
        font-weight: bold;
        text-align: right;
    }

    .txt-body {
        font-size: 16px;
        text-align: left;
    }

    hr {
        margin: 4px;
    }

    p {
        font-family: Arial, Noto Sans JP Medium;
    }

    .narrow {
        padding: 15px;
        border: 1px solid red;
        width: 400px;
        margin: 0 0;
        font-size: 20px;
        line-height: 1.5;
        letter-spacing: 2px;
    }

    .label {
        font-size: 30px;
    }

    .normal {
        word-break: normal;
    }

    .breakAll {
        word-break: break-all;
    }

    .keepAll {
        word-break: keep-all;
    }

    .breakWord {
        word-break: break-word;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .cell-breakWord {
        word-wrap: break-word;
    }
    </style>
</head>

<body>
    <div class="container">
        <!--
        <p class="label">1. <i>word-break: normal</i> </p>
        <p class="normal narrow">
            Hippopotomonstrosesquippedaliophobia Pneumonoultramicroscopicsilicovolcanoconiosis
            Supercalifragilisticexpialidociousdociousdociousdociousdocious ?????????????????????????????
        </p>
        <br>

        <p class="label">2. <i>word-break: break-all</i></p>
        <p class="breakAll narrow">
            Hippopotomonstrosesquippedaliophobia Pneumonoultramicroscopicsilicovolcanoconiosis
            Supercalifragilisticexpialidociousdociousdociousdociousdocious ?????????????????????????????
        </p>
        <br>

        <p class="label">3. <i>word-break: keep-all</i></p>
        <p class="keepAll narrow">
            Hippopotomonstrosesquippedaliophobia Pneumonoultramicroscopicsilicovolcanoconiosis
            Supercalifragilisticexpialidociousdociousdociousdociousdocious ?????????????????????????????
        </p>
        <br>

        <p class="label">4. <i>word-break: break-word</i></p>
        <p class="breakWord narrow">
            Hippopotomonstrosesquippedaliophobia Pneumonoultramicroscopicsilicovolcanoconiosis
            Supercalifragilisticexpialidociousdociousdociousdociousdocious ?????????????????????????????
        </p>
        <br>
        -->
        <table width="100%" style="font-size:16px">
            <tr>
                <td width="10%">
                    <img src="<?=base_url();?>assets/img/logo/tpqi_logo1.png" alt="" width="60px">
                </td>
                <td width="90%" style="vertical-align:middle;font-size:12px"> สถาบันคุณวุฒิวิชาชีพ (องค์การมหาชน) <br>
                    Thailand Professional Qualification Institute <br>(Public Organization)</td>

            </tr>
        </table>
        <hr>
        <br />

        <?php
if (is_array($result)) {
    foreach ($result as $v) {
        ?>
        <table width="100%" style="padding-top:10px">
            <tr>
                <td style="font-size:16px;font-weight:bold;text-align:center">
                    <?php
if ($v->tool_type == 3) {
            echo "ข้อสอบสัมภาษณ์";
        } else {
            echo "";
        }
        ?>
                </td>
            </tr>
            <tr>
                <td style="font-size:16px;font-weight:normal;text-align:center;"> <strong>
                        <?php
//$str_occ_level_id = explode(':', $v->occ_level_id);
        echo  $this->SharedModel->get_uocname($v->occ_level_id) //$this->MasterDataModel->get_occ_name_preview($str_occ_level_id[0])?>
                    </strong>
                </td>
            </tr>
        </table>
        <table width="100%" style="padding-top:10px">
            <tr>
                <td style="font-size:16px;text-align:left">
                    <strong>คำอธิบายสำหรับเจ้าหน้าที่สอบ</strong><br />
                    &nbsp;&nbsp;&nbsp;&nbsp;<?=$v->desc_for_examier?>
                </td>
            </tr>
            <tr>
                <td style="font-size:16px;font-weight:normal;text-align:left;">
                    <strong>คำอธิบายสำหรับผู้เข้ารับการประเมิน</strong><br />
                    &nbsp;&nbsp;&nbsp;&nbsp;<?=$v->des_for_applicant?>
                </td>
            </tr>
            <tr>
                <td style="font-size:16px;text-align:left">
                    <strong>เกณฑ์การประเมิน :</strong>
                    <?php
if ($v->criteria_used_byexamier == 0) {
            echo "ไม่กำหนดเกณฑ์";
        } else {
            $criteria_detail = $this->SharedModel->get_criteria_advise_type($v->criteria_type_byexamier);
            echo "ผู้ออกข้อสอบได้แนะนำการกำหนดเกณฑ์การประเมิน ดังนี้ " . "<br/> &nbsp;&nbsp;&nbsp;&nbsp;" . $criteria_detail["description"];
        }
        ?>
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td style="font-size:16px;font-weight:normal;text-align:left;">
                    <?php if ($v->case_study != "") {?>
                    <strong>กรณีศึกษา</strong><br />
                    &nbsp;&nbsp;<?=$v->case_study?>
                    <?php }?>

                </td>
            </tr>
        </table>
        <?php }
}?>
        <table border="1" width="100%" style="border-collapse: collapse;">
            <thead>
                <tr style="background:#CFCFCF">
                    <th width="40%" style="text-align:center;font-weight:bold">คำถาม
                    </th>
                    <th width="40%" style="text-align:center;font-weight:bold">แนวคำตอบ
                    </th>
                    <th width="10%" style="text-align:center;font-weight:bold">สถานะคำถาม
                    </th>
                </tr>
            </thead>

            <?php
if (is_array($rs_detail)) {
    $tmp_uoc_code = "";
    $tmp_eoc_code = "";
    $j = 1;
    $k = 1;
    foreach ($rs_detail as $v_detail) {
        $j++;
        $k++;
        ?>
            <?php
if ($tmp_uoc_code != $v_detail->uoc_code) {

            ?>
            <tr>
                <td colspan="3" style="background-color:#F1F1F1">
                    <?php
          $rs=$this->SharedModel->get_uocname($v_detail->uoc_code)
            ?><strong><?php echo "หน่วยสมรรถนะ : " . $rs["uoc_code"] . " " . $rs["uoc_name"]; ?></strong>
                </td>
            </tr>
            <?php 
            if(!empty($v_detail->eoc_code)){
            if ($tmp_eoc_code != $v_detail->eoc_code) {
                ?>
            <tr>
                <td colspan="3" style="background-color:#F1F1F1">
                    <?php
          $rs=$this->SharedModel->get_eocname($v_detail->eoc_code)
            ?><strong><?php echo "หน่วยสมรรถนะย่อย : " . $rs["eoc_code"] . " " . $rs["eoc_name"]; ?></strong>
                </td>
            </tr>
            <?php
$tmp_eoc_code = $v_detail->eoc_code;
            $k = 1;
        }?>
            <?php }
            ?>
            <?php
$tmp_uoc_code = $v_detail->uoc_code;
            $j = 1;
        }?>
            <tbody>
                <tr>
                    <td>
                        <?php echo $j . "." . $v_detail->question ?>
                    </td>
                    <td>
                        <?=$v_detail->guide_answer;?>
                    </td>
                    <td style="text-align:center;">
                        <?=$v_detail->question_status == 1 ? "ใช้งาน" : "ไม่ใช้งาน"?>
                    </td>
                </tr>
            </tbody>
            <?php

    }

}?>
        </table>

    </div>
</body>

</html>