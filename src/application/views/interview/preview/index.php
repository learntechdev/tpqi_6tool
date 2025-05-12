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
if ($v->tool_type == 3) {
            echo "ข้อสอบสัมภาษณ์";
        } else {
            echo "";
        }
        ?>
                </td>
            </tr>
            <tr>
                <td style="font-size:16px;font-weight:normal;text-align:center;"> <strong> <?php
//$str_occ_level_id = explode($v->occ_level_id);
        //echo $str_occ_level_id[0];
        
        echo  $this->SharedModel->get_uocname($v->occ_level_id) ?>
                    </strong>
                </td>
            </tr>
        </table>
        <br>
        <table width="100%" style="padding-top:10px">
            <tr>
                <td style="font-size:16px;text-align:left">
                    <strong>คำอธิบายสำหรับเจ้าหน้าที่สอบ</strong><br />
                    &nbsp;&nbsp;&nbsp;&nbsp;<?=strip_tags($v->desc_for_examier)?>
                </td>
            </tr>
            <tr>
                <td style="font-size:16px;font-weight:normal;text-align:left;">
                    <strong>คำอธิบายสำหรับผู้เข้ารับการประเมิน</strong><br />
                    &nbsp;&nbsp;&nbsp;&nbsp;<?=strip_tags($v->des_for_applicant)?>
                </td>
            </tr>
            <tr>
                <td style="font-size:16px;text-align:left">
                    <strong>เกณฑ์ที่ผู้ออกข้อสอบแนะนำ :</strong>
                    <?php
if ($v->criteria_used == 0) {
            echo "ไม่กำหนดเกณฑ์ผ่าน" . " " . $v->full_score . " คะแนน (จากคะแนนเต็ม)";
        } else if ($v->criteria_pass_exam == 1) {
            echo "%ผ่าน" . " " . $v->percent_score . " เปอร์เซ็นต์";
        } else {
            echo "คะแนนผ่าน " . " " . $v->pass_score . " คะแนน จากคะแนนเต็ม " . $v->full_score_ofpass . " คะแนน";
        }
        ?>
                </td>
            </tr>
            <tr>
                <td style="font-size:16px;text-align:left">
                    <strong>เวลาที่ใช้สอบ :</strong>
                    <?=$v->exam_time?> นาที
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td style="font-size:16px;font-weight:normal;text-align:left;">
                    <strong>จงใช้ข้อมูลจากโจทย์ในการตอบคำถามสัมภาษณ์</strong>
                </td>
            </tr>
            <tr>
                <td style="font-size:16px;font-weight:normal;text-align:left;">
                    <strong>&nbsp;&nbsp; กรณีศึกษา</strong><br />
                    &nbsp;&nbsp;<?=strip_tags($v->case_study)?>
                </td>
            </tr>
        </table>
        <?php }
}?>

        <br />
        <table border="1" width="100%" style="border-collapse: collapse;">
            <thead>
                <tr style="background:#CFCFCF">
                    <th style="text-align:center;font-weight:bold">เกณฑ์การประเมิน
                    </th>
                    <th style="text-align:center;font-weight:bold">คำถาม
                    </th>
                    <th style="text-align:center;font-weight:bold">แนวทางคำตอบ
                    </th>
                </tr>
            </thead>

            <?php
if (is_array($rs_detail)) {
    $tmp_eoccode = "";
    foreach ($rs_detail as $v_detail) {?>
            <?php
if ($tmp_eoccode != $v_detail->eoc_code) {?>
            <tr>
                <td colspan="3" style="background-color:#F1F1F1">
                    <?php
$rs = $this->InterviewPreviewModel->get_pstd_eocname($v_detail->eoc_code);
        ?><strong><?php echo $rs["stdCode"] . " " . $rs["stdName"]; ?></strong>
                </td>
            </tr>
            <?php
$tmp_eoccode = $v_detail->eoc_code;
    }?>
            <tbody>
                <tr>
                    <td>
                        <?=$v_detail->pc_detail;?>
                    </td>
                    <td>
                        <?=$v_detail->question;?>
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