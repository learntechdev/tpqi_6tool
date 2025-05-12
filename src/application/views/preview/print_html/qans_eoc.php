<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ข้อสอบ<?= $tool_typename ?></title>
    <style>
    body {
        font-family: sans-serif;
        font-size: 16pt;
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

    table th,
    td {
        line-height: 100%;
        padding: 6px;
    }

    table {
        border-collapse: separate;
        border-spacing: 2px;
    }
    </style>
</head>

<body>
    <!--
   xfa:APIVersion="Acroform:2.7.0.0" xfa:spec="2.1" xmlns="http://www.w3.org/1999/xhtml"
    xmlns:xfa="http://www.xfa.org/schema/xfa-data/1.0/"    
   <p dir="ltr"
        style="letter-spacing: -0.04cm; margin-top:0pt;margin-bottom:8pt;line-height:12.95pt;font-family:Calibri;font-size:11pt">
    <p dir="ltr"
        style="letter-spacing: -0.04cm; margin-top:0pt;margin-bottom:8pt;line-height:12.95pt;font-family:Calibri;font-size:11pt">-->
    <div class="container">

        <table width="100%">
            <tr>
                <td width="10%">
                    <img src="assets/img/logo/tpqi_logo1.jpg" alt="" width="60px">
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
                <td style="font-size:18pt;font-weight:bold;text-align:center">
                    <strong>ชุดข้อสอบ<?= $tool_typename ?> </strong><br />
                    <?php if( $this->SharedModel->get_occlevelname($v['occ_level_id']) != null )  echo $this->SharedModel->get_occlevelname($v['occ_level_id'])['levelName'] ?>
                </td>
            </tr>
        </table>

        <table width="100%" style="padding-top:10px;">
            <tr>
                <td style="font-weight:normal;text-align:left;">
                    <strong>คำอธิบายสำหรับเจ้าหน้าที่สอบ</strong><br />
                    &nbsp;&nbsp;&nbsp;&nbsp;<?= $v->desc_for_examier; ?>
                </td>
            </tr>
            <tr>
                <td style="font-weight:normal;text-align:left;">
                    <strong>คำอธิบายสำหรับผู้เข้ารับการประเมิน</strong><br />
                    &nbsp;&nbsp;&nbsp;&nbsp;<?= $v->des_for_applicant ?>
                </td>
            </tr>
            <tr>
                <td style="text-align:left">
                    <strong>เกณฑ์การประเมิน (ผู้ออกข้อสอบแนะนำ) </strong><br />
                    <?php
                            if ($v->criteria_used_byexamier == 0) {
                                echo "ไม่กำหนดเกณฑ์";
                            } else {
                                $criteria_detail = $this->SharedModel->get_criteria_advise_type($v->criteria_type_byexamier);
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;ผู้ออกข้อสอบได้แนะนำการกำหนดเกณฑ์การประเมิน ดังนี้ " . "<br/> &nbsp;&nbsp;&nbsp;&nbsp;" . $criteria_detail["description"];
                            }
                            ?>
                </td>
            </tr>
            <tr>
                <td style="font-weight:normal;text-align:left;">
                    <?php if ($v->case_study != "") { ?>
                    <strong>กรณีศึกษา</strong><br />
                    &nbsp;&nbsp;<?= $v->case_study ?>
                    <?php } ?>

                </td>
            </tr>
        </table>
        <?php }
        } ?>

        <pagebreak orientation="landscape"></pagebreak>
        <table border="1" style="border-collapse: collapse;overflow:wrap;font-size:16pt" autosize="1">
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
                $i = 0;
                $j = 0;
                foreach ($rs_detail as $v_detail) {
                    $i++;
                    $j++;
            ?>

            <?php
                    if ($tmp_uoc_code != $v_detail->uoc_code) { ?>
            <tr>
                <td colspan="3" style="background-color:#F1F1F1">
                    <?php
                                $rs = $this->SharedModel->get_uocname($v_detail->uoc_code)
                                ?><strong><?php echo "หน่วยสมรรถนะ : " . $rs["uoc_code"] . " " . $rs["uoc_name"]; ?></strong>
                </td>
            </tr>
            <?php
                        $tmp_uoc_code = $v_detail->uoc_code;
                    } ?>

            <tbody>
                <?php
                        if ($tmp_eoc_code != $v_detail->eoc_code) { ?>
                <tr>
                    <td colspan="3" style="font-style: italic">
                        <?php
                                    $rs = $this->SharedModel->get_eocname($v_detail->eoc_code)
                                    ?><strong><?php echo "หน่วยสมรรถนะย่อย : " . $rs["eoc_code"] . " " . $rs["eoc_name"]; ?></strong>
                    </td>
                </tr>
                <?php
                            $tmp_eoc_code = $v_detail->eoc_code;
                            $j = 1;
                        } ?>

                <tr>
                    <td style="vertical-align: text-top;">
                        <?php echo $j . "." . $v_detail->question ?>
                    </td>
                    <td style="vertical-align: text-top;">
                        <?= $v_detail->guide_answer; ?>
                    </td>
                    <td style="text-align:center;">
                        <?= $v_detail->question_status == 1 ? "ใช้งาน" : "ไม่ใช้งาน" ?>
                    </td>
                </tr>
            </tbody>
            <?php
                }
            }
            ?>
        </table>
    </div>
</body>

</html>