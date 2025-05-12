<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>เครื่องมือประเมิน <?= $tool_typename ?></title>
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

<body>
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
                    <strong>ข้อสอบ <?= $tool_typename ?></strong>
                </td>
            </tr>
            <tr>
                <td style="font-size:18px;font-weight:normal;text-align:center;"> <strong>
                        <?php
                                                                                                    $str_occ_level_id = explode(':', $v->occ_level_id);
                                                                                                    //echo $str_occ_level_id[0];
                                                                                                    echo $this->MasterDataModel->get_occ_name_preview($str_occ_level_id[0]) ?>
                    </strong>
                </td>
            </tr>
        </table>

        <table width="100%" style="padding-top:10px">
            <tr>
                <td style="font-size:16px;font-weight:normal;text-align:left;">
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
                    <strong>เกณฑ์ที่ผู้ออกข้อสอบแนะนำ :</strong>
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

        <strong>การประเมิน</strong>
        <table border="1" width="100%" style="border-collapse: collapse;">
            <thead>
                <tr style="background:#CFCFCF">
                    <th style="width:80%;text-align:center;font-weight:bold">รายการประเมิน
                    </th>
                    <?php if ($criteria_detail["type"] == "1") { ?>
                    <th style="width:10%;text-align:center;font-weight:bold">
                        <label for="">คะแนน</label>
                    </th>
                    <?php } else { ?>
                    <th style="width:5%;text-align:center;font-weight:bold">มี
                    </th>
                    <th style="width:5%;text-align:center;font-weight:bold">ไม่มี
                    </th>
                    <?php } ?>
                    <th style="width:15%;text-align:center;font-weight:bold">
                        <label for="">สถานะคำถาม</label>
                    </th>
                </tr>
            </thead>
            <?php
            if (is_array($rs_detail)) {
                $tmp_uoc_code = "";
                $i = 1;
                foreach ($rs_detail as $v_detail) {
                    $i++;
            ?>

            <?php
                    if ($tmp_uoc_code != $v_detail->uoc_code) {
                        $colspan = "";
                        if ($criteria_detail["type"] == "1") {
                            $colspan = "3";
                        } else {
                            $colspan = "4";
                        }
                    ?>
            <tr>
                <td colspan="<?= $colspan ?>" style="background-color:#F1F1F1">
                    <strong>
                        <?php
                                    $uoc_name = $this->SharedModel->get_uocname($v_detail->uoc_code);
                                    echo $uoc_name["uoc_code"] . " : " . $uoc_name["uoc_name"]; ?>
                    </strong>
                </td>
            </tr>
            <?php
                        $tmp_uoc_code = $v_detail->uoc_code;
                        $i = 1;
                    } ?>

            <tbody>
                <tr>
                    <td>
                        <?php echo $i . ". " . $v_detail->main_topic; ?>
                    </td>
                    <?php if ($criteria_detail["type"] == "1") { ?>
                    <td></td>
                    <?php } else { ?>
                    <td></td>
                    <td></td>
                    <?php } ?>
                    <td style="text-align:center;"><?= $v_detail->question_status == 1 ? "ใช้งาน" : "ไม่ใช้งาน" ?></td>
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