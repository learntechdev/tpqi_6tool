<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ข้อสอบ<?= $tool_typename ?></title>
    <link rel="stylesheet" type="text/css"
        href="<?= base_url(); ?>assets/fonts_saraban/thsarabunnew.css?<?= date("YmdHis") ?>" />
    <style>
    body {
        margin: 10;
        font-family: "THSarabunNew", -apple-system, BlinkMacSystemFont, "Segoe UI",
            Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif,
            "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";

        text-align: left;
        font-size: 20px;
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

    pre {
        white-space: pre-line;
        width: 300px;
    }
    </style>
</head>

<body>
    <div class="container">
        <table width="100%">
            <tr>
                <td width="10%">
                    <img src="../../../assets/img/logo/tpqi_logo1.jpg" alt="" width="60px">
                </td>
                <td width="90%" style="vertical-align:middle;font-size:12px"> สถาบันคุณวุฒิวิชาชีพ (องค์การมหาชน) <br>
                    Thailand Professional Qualification Institute <br>(Public Organization)</td>
            </tr>
        </table>
        <hr>
        <br />
        <div style="font-size:20px;font-weight:bold;text-align:center">
            <?php echo "ข้อสอบ" . $tool_typename; ?><br /><?php echo $occ_levelname; ?></div>
        <br />

        <?php
        if (is_array($result)) {
            foreach ($result as $v) {
        ?>
        <table width="100%" style="padding-top:10px">
            <tr>
                <td style="font-size:16px;text-align:left">
                    <strong>คำอธิบายสำหรับเจ้าหน้าที่สอบ</strong><br />
                    &nbsp;&nbsp;&nbsp;&nbsp;<?= $v->desc_for_examier ?>
                </td>
            </tr>
            <tr>
                <td style="font-size:16px;font-weight:normal;text-align:left;">
                    <strong>คำอธิบายสำหรับผู้เข้ารับการประเมิน</strong><br />
                    &nbsp;&nbsp;&nbsp;&nbsp;<?= $v->des_for_applicant ?>
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
                    <?php if ($v->case_study != "") { ?>
                    <strong>&nbsp;&nbsp; กรณีศึกษา</strong><br />
                    &nbsp;&nbsp;<?= $v->case_study ?>
                    <?php } ?>
                </td>
            </tr>
        </table>
        <?php }
        } ?>

        <div style="text-align:left"><strong>หน่วยสมรรถนะ</strong></div>
        <?php if (is_array($rs_detail)) {
            $tmp_uoc_code = "";
            foreach ($rs_detail as $v_detail) {
                if ($tmp_uoc_code != $v_detail->uoc_code) {
                    $rs = $this->SharedModel->get_uocname($v_detail->uoc_code); ?>
        <div style="padding-left:10px">
            <?php echo  $rs["uoc_code"] . " " . $rs["uoc_name"]; ?>
        </div>
        <?php $tmp_uoc_code = $v_detail->uoc_code;
                } ?>
        <?php
            }
        } ?>
        <div style="page-break-before: always;"></div>

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
                $j = 1;
                foreach ($rs_detail as $v_detail) {
                    $j++;
            ?>
            <?php
                    if ($tmp_uoc_code != $v_detail->uoc_code) {

                    ?>
            <tr>
                <td colspan="3" style="background-color:#F1F1F1">
                    <?php $rs = $this->SharedModel->get_uocname($v_detail->uoc_code); ?><strong><?php echo "หน่วยสมรรถนะ : " . $rs["uoc_code"] . " " . $rs["uoc_name"]; ?></strong>
                </td>
            </tr>
            <?php
                        $tmp_uoc_code = $v_detail->uoc_code;
                        $j = 1;
                    } ?>
            <tbody>
                <tr>
                    <td>
                        <?php echo $j . "." . $v_detail->question ?>
                    </td>
                    <td>
                        <?= $v_detail->guide_answer; ?>
                    </td>
                    <td style="text-align:center;">
                        <?= $v_detail->question_status == 1 ? "ใช้งาน" : "ไม่ใช้งาน" ?>
                    </td>
                </tr>
            </tbody>
            <?php

                }
            } ?>
        </table>
    </div>
</body>

</html>