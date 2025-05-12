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

    table,
    th,
    td {
        border-collapse: collapse;
    }

    th,
    td {
        padding: 5px;
    }
    </style>
</head>

<body>
    <div class="container">
        <table width="100%">
            <tr>
                <td width="10%">
                    <img src="<?= base_url(); ?>assets/img/logo/tpqi_logo1.png" alt="" width="60px">
                </td>
                <td width="90%" style="vertical-align:middle;font-size:12px"> สถาบันคุณวุฒิวิชาชีพ (องค์การมหาชน) <br>
                    Thailand Professional Qualification Institute <br>(Public Organization)</td>
            </tr>
        </table>
        <hr />
        <br />
        <div style="font-size:20px;font-weight:bold;text-align:center">
            <?php echo "ข้อสอบ" . $tool_typename; ?><br /><?php echo $occ_levelname; ?><br />(สำหรับผู้ประเมิน)
        </div>
        <br />

        <!-- ข้อมูลส่วนตัวผู้เข้ารับการประเมิน -->
        <div style="text-align:left"> <strong>ชื่อผู้เข้ารับการประเมินสมรรถนะ</strong>
            .................................................................................................................................
        </div>
        <div style="text-align:left">
            <strong>ชื่อผู้ประเมินสมรรถนะ</strong>....................................................................................................................................................
        </div>
        <div style="text-align:left">
            <strong>สถานที่สอบ</strong>.....................................................................................................................................................................
        </div>
        <div style="text-align:left">
            <strong>วันที่สอบ</strong>.........................................................................................................................................................................
        </div>

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


        <?php
        if (is_array($result)) {
            foreach ($result as $v) {
        ?>
        <div><strong>คำแนะนำ </strong></div>
        <div style="padding-left:10px"><?= $v->desc_for_examier ?></div>
        <?php }
        } ?>
        <div style="page-break-before: always;"></div>

        <table border="1" width="100%" style="border-collapse: collapse;">
            <thead>
                <tr style="background:#CFCFCF">
                    <th rowspan="2" width="90%" style="text-align:center;font-weight:bold">คำถาม</th>
                    <th colspan="2" style="width:10%;text-align:center;font-weight:bold">คำตอบ</th>
                </tr>
                <tr style="background:#CFCFCF">
                    <?php if ($v->criteria_used_byexamier == "1") { ?>
                    <th style="width:10%;text-align:center;font-weight:bold">
                        <label for="">คะแนน</label>
                    </th>
                    <?php } else { ?>
                    <th style="width:5%;text-align:center;font-weight:bold">ผ่าน
                    </th>
                    <th style="width:5%;text-align:center;font-weight:bold">ไม่ผ่าน
                    </th>
                    <?php } ?>
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
                <td colspan="3">
                    <?php $rs = $this->SharedModel->get_uocname($v_detail->uoc_code); ?>
                    <strong><?php echo  $rs["uoc_code"] . " " . $rs["uoc_name"]; ?></strong>
                </td>
            </tr>
            <?php
                        $tmp_uoc_code = $v_detail->uoc_code;
                        $j = 1;
                    } ?>
            <tbody>
                <tr>
                    <td>
                        <?php echo $j . "." . $v_detail->question ?><br />
                        <strong>แนวทางคำตอบ</strong><br />
                        <?php echo $j . "." . $v_detail->guide_answer ?>
                    </td>
                    <?php if ($v->criteria_used_byexamier == "1") { ?>
                    <td></td>
                    <?php } else { ?>
                    <td align="center"><input type="checkbox"></td>
                    <td align="center"><input type="checkbox"></td>
                    <?php } ?>
                </tr>
            </tbody>
            <?php
                }
            } ?>
        </table>

        <br /><br />
        <table width="100%" border="0">
            <tr>
                <td width="50%"></td>
                <td align="center"><strong>เจ้าหน้าที่สอบ</strong></td>
            </tr>
            <tr>
                <td></td>
                <td align="center">ลงชื่อ.............................................</td>
            </tr>
            <tr>
                <td></td>
                <td align="center">(....................................................)</td>
            </tr>
            <tr>
                <td></td>
                <td align="center">วันที่......./....................../...............</td>
            </tr>
        </table>
    </div>
</body>

</html>