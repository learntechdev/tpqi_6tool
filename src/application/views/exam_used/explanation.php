<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ข้อสอบ<?= $tool_typename ?></title>
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
                    <img src="assets/img/logo/tpqi_logo1.png" alt="" width="60px">
                </td>
                <td width="90%" style="vertical-align:middle;font-size:12px"> สถาบันคุณวุฒิวิชาชีพ (องค์การมหาชน) <br>
                    Thailand Professional Qualification Institute <br>(Public Organization)</td>

            </tr>
        </table>
        <hr>
        <br />

        <div style="font-size:18pt;font-weight:bold;text-align:center">
            <?php echo "ข้อสอบ" . $tool_typename; ?><br /><?php echo $occ_levelname; ?>
        </div>
        <br />

        <div style="font-size:17pt;text-align:left"> <strong>ชื่อผู้เข้ารับการประเมินสมรรถนะ</strong>
            .................................................................................................................................
        </div>
        <div style="font-size:17pt;text-align:left">
            <strong>ชื่อผู้ประเมินสมรรถนะ</strong>....................................................................................................................................................
        </div>
        <div style="font-size:17pt;text-align:left">
            <strong>สถานที่สอบ</strong>.....................................................................................................................................................................
        </div>
        <div style="font-size:17pt;text-align:left">
            <strong>วันที่สอบ</strong>.........................................................................................................................................................................
        </div>

        <div style="font-size:17pt;text-align:left"><strong>หน่วยสมรรถนะ</strong></div>
        <div style="font-size:17pt;padding-left:10px"> <?php if (is_array($rs_detail)) {
                                                            $tmp_uoc_code = "";
                                                            foreach ($rs_detail as $v_detail) {

                                                        ?>
            <?php
                                                                if ($tmp_uoc_code != $v_detail->uoc_code) {

                    ?>
            <?php $rs = $this->SharedModel->get_uocname($v_detail->uoc_code); ?>
            <?php echo  $rs["uoc_code"] . " " . $rs["uoc_name"]; ?> <br />
            <?php
                                                                    $tmp_uoc_code = $v_detail->uoc_code;
                                                                } ?>
            <?php
                                                            }
                                                        } ?></div>
        <?php
        if (is_array($result)) {
            foreach ($result as $v) {
        ?>
        <div style="font-size:17pt;"><strong>คำแนะนำ</strong></div>
        <div style="font-size:17pt;padding-left:10px"><?= $v->desc_for_examier ?></div>
        <?php }
        } ?>
    </div>

</body>

</html>