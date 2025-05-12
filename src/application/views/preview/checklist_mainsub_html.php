<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>เครื่องมือประเมิน แฟ้มสะสมผลงาน</title>
	 <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/fonts_saraban/thsarabunnew.css?<?= date("YmdHis") ?>" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/tp_new/css/bootstrap.css?<?= date("YmdHis") ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!--
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/bootstrap.css" />
        -->

    <style>
        body {
            font-family: "THSarabunNew" !important;
            text-align: left;
            font-size: 20px;
        }
        
        img {
            max-width: 100%;
            height: auto !important;
        }

        .fs-normal {
            font-size: 20px !important;
        }

        .fs-small {
            font-size: 16px !important;
        }

        @page {
            size: 7in 9.25in;
            margin: 27mm 16mm 27mm 16mm;
        }

        .table {
            word-break: break-word;
            table-layout: fixed;
        }

        .table td.fit,
        .table th.fit {
            white-space: nowrap;
            width: 12%;
            text-align: center;
        }

        .table-gray {
            background-color: gray;
        }

        @media print {
            .table td.fit,
            .table th.fit {
                width: 10%;
            }

            .table-gray {
                background-color: gray;
            }

            #nonPrint {
                display: none;
            }

            body {
                font-size: 10px;
            }

            .fs-normal {
                font-size: 10x !important;
            }

            .fs-small {
                font-size: 8x !important;
            }
        }
    </style>
</head>



<body xfa:APIVersion="Acroform:2.7.0.0" xfa:spec="2.1" xmlns="http://www.w3.org/1999/xhtml"
    xmlns:xfa="http://www.xfa.org/schema/xfa-data/1.0/">
    <p dir="ltr"
        style="letter-spacing: -0.04cm; margin-top:0pt;margin-bottom:8pt;line-height:12.95pt;font-family:Calibri;font-size:11pt">
    <p dir="ltr"
        style="letter-spacing: -0.04cm; margin-top:0pt;margin-bottom:8pt;line-height:12.95pt;font-family:Calibri;font-size:11pt">
    <section id="requiredprinting">
	<div class="container">
	<div class="row mt-3" id="nonPrint">
				<div class="col-auto ml-auto">
					<div class="dropdown">
						<button type="button" class="btn btn-secondary dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							เอกสารเพิ่มเติม
						</button>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">

                        <?php
                            $template_id = $_GET['template_id'];

                            $host = "localhost";
                            $database = "tpqinet_asm";
                            $user = "tpqi";
                            $pass = "db@tpqi";
                            $con=mysqli_connect($host, $user, $pass, $database);
                            
                            // Check connection
                            if (mysqli_connect_errno()) { echo "Failed to connect to MySQL: " . mysqli_connect_error(); }
                            
                            // Change character set to utf8
                            mysqli_set_charset($con,"utf8");

                            date_default_timezone_set('Asia/Bangkok');

                            $sql = " SELECT * FROM docs_forexam WHERE template_id	 = '" . $template_id . "' ";
                            $query = mysqli_query($con, $sql) or die(mysqli_error($con));

                             if(mysqli_num_rows($query) > 0) {
                                 while ($resultFile = mysqli_fetch_array($query)) {
                                     $path = "docs_forexam/" . $template_id . "/";
                        ?>

							<a class="dropdown-item" href="<?= base_url() . $path . $resultFile['docs_filename'] ?>" target="blank"><?=str_replace(".pdf", "", $resultFile['docs_filename']);?></a>
                            
                        <?php
                                 }
                             } else {
                        ?>

                            <a class="dropdown-item disabled" href="#" disabled>ไม่พบไฟล์แนบ</a>

                        <?php
                             }
                        ?>

						</div>
					</div>
				</div>
                <div class="col-auto">
                    <button type="button" class="btn btn-primary w-100" id="btn_print" name="btn_print" onclick="window.print();">
                    <!-- <button type="button" class="btn btn-primary" id="btn_print" name="btn_print" onclick="printDiv()"> -->
                        <i class="fa-solid fa-print"></i>
						พิมพ์
                    </button>
                </div>
            </div>
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
	</section>
</body>

</html>