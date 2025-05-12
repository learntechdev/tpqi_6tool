<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ข้อสอบ<?= $tool_typename ?></title>
    <meta http-equiv="Content-Language" content="th" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css"
        href="<?= base_url(); ?>assets/fonts_saraban/thsarabunnew.css?<?= date("YmdHis") ?>" />
    <style>
    body {
        font-family: "THSarabunNew", -apple-system, BlinkMacSystemFont, "Segoe UI",
            Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif,
            "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";

        font-size: 20px;
    }

    /*  li {
        overflow: hidden;
        white-space: no-wrap;
        text-overflow: ellipsis;
    }

    table {
        page-break-after: always;
    }*/
    </style>
</head>

<body>
    <pagebreak orientation="landscape"></pagebreak>
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
    <div style="font-size:18pt;font-weight:bold;text-align:center">
        <?php echo "ข้อสอบ" . $tool_typename; ?><br /><?php echo $occ_levelname; ?></div>
    <br />


    <!-- style="table-layout: fixed;border-collapse: collapse;font-size:36pt"-->
    <table style="overflow:wrap;" border="1" width="100%">
        <thead>
            <tr style="background:#CFCFCF">
                <th rowspan="2" width="40%" style="text-align:center;font-weight:bold">
                    เกณฑ์การปฏิบัติงาน </th>
                <th rowspan="2" width="45%" style="text-align:center;font-weight:bold">
                    รายการประเมินทักษะ</th>
                <th colspan="2" width="15%;" style="text-align:center;font-weight:bold">คำตอบ</th>
            </tr>
            <tr style="background:#CFCFCF">
                <?php
                if (is_array($result)) {
                    foreach ($result as $v) {

                ?>
                <?php
                        if ($v->criteria_used_byexamier == "1") { ?>
                <th width="10%" style="text-align:center;font-weight:bold">
                    <label for="">คะแนน</label>
                </th>
                <?php } else { ?>
                <th width="5%" style="text-align:center;font-weight:bold">ใช่
                </th>
                <th width="10%" style="text-align:center;font-weight:bold">ไม่ใช่
                </th>
                <?php } ?>
                <?php }
                } ?>
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
            <td colspan="4" style="font-size:18pt;background-color:#F1F1F1;">
                <?php
                            $rs = $this->SharedModel->get_uocname($v_detail->uoc_code)
                            ?><strong><?php echo "หน่วยสมรรถนะ : " . $rs["uoc_code"] . " " . $rs["uoc_name"]; ?></strong>
            </td>
        </tr>
        <?php
                    $tmp_uoc_code = $v_detail->uoc_code;
                } ?>

        <?php

                if ($tmp_eoc_code != $v_detail->eoc_code) { ?>
        <tr>
            <td colspan="4" style="font-size:18pt;font-style: italic;">
                <?php
                            $rs = $this->SharedModel->get_eocname($v_detail->eoc_code)
                            ?><strong><?php echo "หน่วยสมรรถนะย่อยที่ : " . $rs["eoc_code"] . " " . $rs["eoc_name"]; ?></strong>
            </td>
        </tr>
        <?php
                    $tmp_eoc_code = $v_detail->eoc_code;
                    $j = 1;
                } ?>
        <tbody>
            <tr>
                <td style="font-size:20pt;overflow:wrap">
                    <?php
                            $str_q = str_replace("&nbsp;", '', $v_detail->question);
                            // $str_txt = wordwrap($str_q, 15, "<br/>");
                            echo $j . "." . $str_q;
                            ?>
                </td>
                <td style="font-size:20pt;overflow:wrap;">


                    <?php $str_ans = str_replace("&nbsp;", '', $v_detail->guide_answer);

                            // $str_ans = wordwrap($v_detail->guide_answer, 40, "<br/>");
                            // echo ($v_detail->guide_answer); // $ans = str_replace("&nbsp;", '', $v_detail->guide_answer);
                            // $str = "<ol><li>Monkey</li></li><li>Lamb</li><li>Elephant</li></ol>";
                            // $str = $str_ans;
                            /* preg_match_all("/<li>(.*?)<\/li>/i", $str_ans, $matches);
                                    if (count($matches[1]) > 0) {
                                        foreach ($matches[1] as $k => $v) {
                                            echo "&#8226" . ". $v<br/>";
                                        }
                                    } else {
                                        echo $str_ans;
                                    }*/
                            echo ($v_detail->guide_answer) //$str_ans;



                            ?>

                </td>

                <?php if ($v->criteria_used_byexamier == "1") { ?>
                <td></td>
                <?php } else { ?>
                <td align="center"></td>
                <td align="center"></td>
                <?php } ?>
            </tr>
        </tbody>
        <?php
            }
        }
        ?>
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

</body>

</html>