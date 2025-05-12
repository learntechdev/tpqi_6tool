<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>เครื่องมือประเมิน แฟ้มสะสมผลงาน</title>
    <!--
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/bootstrap.css" />
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

    table th,
    td {
        padding: 6px;
    }

    table {
        border-collapse: separate;
        border-spacing: 2px;
    }
    </style>
</head>



<body xfa:APIVersion="Acroform:2.7.0.0" xfa:spec="2.1" xmlns="http://www.w3.org/1999/xhtml"
    xmlns:xfa="http://www.xfa.org/schema/xfa-data/1.0/">
    <p dir="ltr"
        style="letter-spacing: -0.04cm; margin-top:0pt;margin-bottom:8pt;line-height:12.95pt;font-family:Calibri;font-size:11pt">
    <p dir="ltr"
        style="letter-spacing: -0.04cm; margin-top:0pt;margin-bottom:8pt;line-height:12.95pt;font-family:Calibri;font-size:11pt">
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
                <td style="font-size:18px;font-weight:bold;text-align:center">
                    <strong>ชุดข้อสอบแฟ้มสะสมผลงาน</strong>
                </td>
            </tr>
            <tr>
                <td style="font-size:18px;font-weight:normal;text-align:center;"> <strong>
                        <?php
                                                                                                    $str_occ_level_id = explode(':', $v->occ_level_id);
                                                                                                    echo $this->MasterDataModel->get_occ_name_preview($str_occ_level_id[0]) ?>
                    </strong>
                </td>
            </tr>
        </table>

        <table width="100%" style="padding-top:10px">
            <tr>
                <td style="font-size:16px;font-weight:normal;text-align:left;">
                    <strong>คำอธิบายสำหรับเจ้าหน้าที่สอบ</strong><br />
                    &nbsp;&nbsp;&nbsp;&nbsp;<?= $v->desc_for_examier; ?>
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
                    <strong>เกณฑ์การประเมิน </strong>
                    <?php
                            if ($v->criteria_used_byexamier == 0) {
                                echo "ไม่กำหนดเกณฑ์";
                            } else {
                                $criteria_detail = $this->SharedModel->get_criteria_advise_type($v->criteria_type_byexamier);
                                echo "<br/>&nbsp;&nbsp;&nbsp;&nbsp;ผู้ออกข้อสอบได้กำหนดเกณฑ์การประเมิน ดังนี้ " . "<br/> &nbsp;&nbsp;&nbsp;&nbsp;" . $criteria_detail["description"];
                            }
                            ?>
                </td>
            </tr>
        </table>

        <?php }
        } ?>

        <strong>รายการประเมิน</strong>
        <table border="1" width="100%" style="border-collapse: collapse;">
            <thead>
                <tr style="background:#CFCFCF">
                    <th style="width:80%;text-align:center;font-weight:bold">เอกสาร
                    </th>
                    <?php if ($criteria_detail["type"] == "1") { ?>
                    <th style="width:10%;text-align:center;font-weight:bold">
                        <label for="">คะแนน</label>
                    </th>

                    <?php } else { ?>
                    <th style="width:10%;text-align:center;font-weight:bold">มี
                    </th>
                    <th style="width:10%;text-align:center;font-weight:bold">ไม่มี
                    </th>
                    <?php } ?>
                </tr>
            </thead>
            <?php
            if (is_array($rs_detail)) {
                $tmp_maintopic = "";
                foreach ($rs_detail as $v_detail) {
                    $colspan = "";
                    if ($criteria_detail["type"] == "1") {
                        $colspan = "2";
                    } else {
                        $colspan = "3";
                    }
            ?>

            <?php
                    if ($tmp_maintopic != $v_detail->maintopic) { ?>
            <tr>
                <td colspan="<?= $colspan ?>" style="background-color:#F1F1F1">
                    <strong>
                        <?php
                                    $uoc_name = $this->SharedModel->get_uocname($v_detail->maintopic);
                                    echo $v_detail->m_order_line . ". " . $v_detail->maintopic; ?>
                    </strong>
                </td>
            </tr>
            <?php
                        $tmp_maintopic = $v_detail->maintopic;
                    } ?>

            <tbody>

                <tr>
                    <td>
                        <?php echo $v_detail->m_order_line . "." . $v_detail->sub_order_line . " " . $v_detail->subtopic; ?>
                    </td>
                    <?php if ($criteria_detail["type"] == "1") { ?>
                    <td></td>
                    <?php } else { ?>
                    <td></td>
                    <td></td>
                    <?php } ?>
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