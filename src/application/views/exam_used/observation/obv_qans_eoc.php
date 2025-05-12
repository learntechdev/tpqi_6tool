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
        background-color: #fff;
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

    @page {
        size: A4;
        margin-top: 50px;
        margin-bottom: 50px;
    }

    @media print {
        footer {
            page-break-after: always;
        }

        table {
            page-break-before: auto;
            page-break-after: auto;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        tr {
            page-break-before: auto;
            page-break-inside: avoid;
            page-break-after: auto;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        td {
            page-break-before: auto;
            page-break-inside: avoid;
            page-break-after: auto;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        thead {
            display: table-header-group
        }

        tfoot {
            display: table-footer-group
        }
    }

    .avoidBreak {
        border: 2px solid;
        page-break-inside: avoid;
    }

    /*@media screen {
        .page-break {
            height: 10px;
            background: url(page-break.gif) 0 center repeat-x;
            border-top: 1px dotted #999;
            margin-bottom: 13px;
        }
    }

    @media print {
        .page-break {
            height: 0;
            page-break-before: always;
            margin: 0;
            border-top: none;
        }
    }*/

    li {
        -webkit-column-break-inside: avoid;
        page-break-inside: avoid;
        break-inside: avoid;
    }
    </style>
</head>

<body>
    <div class="container page" style="padding: 30px;">

        <table width="100%">
            <tr>
                <td width="10%">
                    <img src="<?= base_url(); ?>assets/img/logo/tpqi_logo1.png" alt="" width="60px">
                </td>
                <td width="90%" style="vertical-align:middle;font-size:16px"> สถาบันคุณวุฒิวิชาชีพ (องค์การมหาชน) <br>
                    Thailand Professional Qualification Institute <br>(Public Organization)</td>
            </tr>
        </table>
        <hr />
        <br />

        <div style="font-size:20px;font-weight:bold;text-align:center">
            <?php echo "ข้อสอบ" . $tool_typename; ?><br /><?php echo $occ_levelname; ?>
        </div>
        <br />

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
        // $criteria_detail = "";
        if (is_array($result)) {
            // print_r($result);
            foreach ($result as $v) {

                //$criteria_detail = $this->SharedModel->get_criteria_advise_type($v->criteria_type_byexamier);
        ?>
        <div><strong>คำแนะนำ </strong></div>
        <div style="padding-left:10px"><?= $v->desc_for_examier ?></div>
        <?php }
        } ?>
        <div style="page-break-before: always;"></div>

        <table class=" tableToPrint" id="tableToPrint" border="1" width="100%"
            style="table-layout: fixed;border-collapse: collapse;font-size:16px" autosize="1">
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
                <td colspan="4" style="background-color:#F1F1F1;">
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
                <td colspan="4" style="font-style: italic;">
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
                    <td>
                        <?php
                                // $str_q = str_replace("&nbsp;", '', $v_detail->question);
                                // $str_txt = wordwrap($v_detail->question, 40, "<br/>");
                                echo $j . "." . str_replace("&nbsp;", '',  $v_detail->question);

                                //echo $j . "." . str_replace("&nbsp;", '', $v_detail->question);
                                ?><br />

                    </td>
                    <td>


                        <?php $str_q = str_replace("&nbsp;", '', $v_detail->guide_answer);
                                // $str_ans = wordwrap($v_detail->guide_answer, 40, "<br/>");
                                echo $str_q; // $ans = str_replace("&nbsp;", '', $v_detail->guide_answer);
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
    </div>

</body>

</html>