<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>เครื่องมือประเมิน สาธิตการปฏิบัติงาน</title>
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
                    ข้อสอบสาธิตการปฏิบัติงาน
                </td>
            </tr>
            <tr>
                <td style="font-size:16px;font-weight:normal;text-align:center;"> <strong> <?php
$str_occ_level_id = explode(':', $v->occ_level_id);
        //echo $str_occ_level_id[0];
        echo $this->MasterDataModel->get_occ_name_preview($str_occ_level_id[0])?>
                    </strong>
                </td>
            </tr>
        </table>
        <br>
        <table width="100%" style="padding-top:10px">
            <tr>
                <td style="font-size:16px;text-align:left">
                    <strong>คำชี้แจงสำหรับผู้ประเมิน</strong><br />
                    &nbsp;&nbsp;&nbsp;&nbsp;<?=strip_tags($v->desc_for_examier)?>
                </td>
            </tr>
            <tr>
                <td style="font-size:16px;font-weight:normal;text-align:left;">
                    <strong>คำชี้แจงสำหรับผู้รับการประเมิน</strong><br />
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
                    <strong>จงใช้ข้อมูลจากโจทย์ในการตอบคำถามดังต่อไปนี้</strong>
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

        <?php
if (is_array($rs_detail)) {
    $tmp_eoccode = "";
    $no = 0;
    foreach ($rs_detail as $v_detail) {
        $no++;
        ?>
        <div>
            <strong> ข้อที่ <?=$no . strip_tags($v_detail->question);?> </strong> <br>
        </div>
        <div> &nbsp;&nbsp; &nbsp;&nbsp;<?=strip_tags($v_detail->answer);?>
        </div>
        <?php }
}?>

    </div>
</body>

</html>