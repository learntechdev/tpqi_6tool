<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>เครื่องมือประเมิน แบบสาธิตการปฏิบัติงาน</title>
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
    </style>
</head>

<body>
    <div class="container">

        <table width="100%">
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
if ($v->tool_type == 2) {
            echo "สาธิตการปฏิบัติงาน";
        } else {
            echo "";
        }
        ?>
                </td>
            </tr>
            <tr>
                <td style="font-size:16px;font-weight:normal;text-align:center;"> <strong> <?php
$str_occ_level_id = explode(':', $v->occ_level_id);
        echo $this->MasterDataModel->get_occ_name_preview($str_occ_level_id[0])?>
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
                    <strong>&nbsp;&nbsp; กรณีศึกษา</strong><br />
                    &nbsp;&nbsp;<?=$v->case_study?>
                    <?php }?>

                </td>
            </tr>
        </table>
        <?php }
}?>
        <table border="1" width="100%" style="border-collapse: collapse;">
            <thead>
                <tr style="background:#909090">
                    <th style="text-align:center;font-weight:bold">คำถาม
                    </th>
                    <th style="text-align:center;font-weight:bold">แนวทางคำตอบ
                    </th>
                </tr>
            </thead>

            <?php
if (is_array($rs_detail)) {
    $tmp_uoc_code = "";
    $tmp_eoc_eode = "";
    foreach ($rs_detail as $v_detail) {?>


            <?php

        $rs_e = $this->DemonstrationPreviewModel->get_pstd_eocname($v_detail->eoc_code);

        if ($tmp_uoc_code != $v_detail->uoc_code) {?>
            <tr>
                <td colspan="2" style="background-color:#CFCFCF">
                    <?php
$rs = $this->DemonstrationPreviewModel->get_pstd_uocname($v_detail->uoc_code);
            ?><strong><?php echo "หน่วยสมรรถนะ : " . $rs["stdCode"] . " " . $rs["stdName"]; ?></strong>
                </td>
            </tr>


            <?php
$tmp_uoc_code = $v_detail->uoc_code;
        }?>
            <tbody>
                <?php if ($tmp_eoc_eode != $rs_e['stdCode']) {?>?>
                <tr>
                    <td colspan="2" style="background-color:#F1F1F1">
                        <strong> หน่วยสมรรถนะย่อย : <?=$rs_e['stdCode']?> <?=$rs_e['stdName']?></strong>

                    </td>
                </tr>
                <?php $tmp_eoc_eode = $rs_e['stdCode'];}?>
                <tr>
                    <td>
                        <?php echo $v_detail->order_line . "." . $v_detail->question ?>
                    </td>
                    <td>
                        <?=$v_detail->guide_answer;?>
                    </td>
                </tr>
            </tbody>
            <?php }
}?>
        </table>

    </div>
</body>

</html>