<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ข้อสอบ<?= $tool_typename ?></title>
    <link rel="stylesheet" type="text/css"
        href="<?= base_url(); ?>assets/fonts_saraban/thsarabunnew.css?<?= date("YmdHis") ?>" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/tp_new/css/bootstrap.css?<?= date("YmdHis") ?>">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<style>
    body {
        margin: 10;
        font-family: "THSarabunNew" !important;
        text-align: left;
        font-size: 16px;
        /* margin: 15mm 15mm 15mm 15mm;*/
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
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

    /* table th,
    td {
        line-height: 100%;
        padding: 6px;
    }

    table {
        border-collapse: separate;
        border-spacing: 2px;
    }
    */

    @media screen,
    print {
        footer {
            page-break-after: always;
        }

        #requiredprinting {
            display: block;
        }

    }



    /*
    @page {
        size: portrait;
        margin: 20cm
    }

    @page :first {
        margin-top: 10cm
    }

    @page rotated {
        size: landscape
    }

    .section1 {
        page: rotated
    }*/
    </style>
</head>

<body>

    <div class="container">
        <!-- <div class="row">
            <div class="col">
                <table class="table">
                    <tr>
                        <td class="text-right">
                            <button type="button" class="btn btn-primary" id="btn_print" name="btn_print" onclick="printDiv()">
                                <i class="fa-solid fa-print"></i>
                                พิมพ์
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
        </div> -->
		
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
    </div>
    <br />

    <div class="container">
        <div id="requiredprinting">
            <table width="100%">
                <tr>
                    <td width="10%">
                        <img src="<?= base_url(); ?>assets/img/logo/tpqi_logo1.jpg" alt="" width="60px">
                    </td>
                    <td width="90%" style="vertical-align:middle;font-size:12px"> สถาบันคุณวุฒิวิชาชีพ(องค์การมหาชน)
                        <br>
                        Thailand Professional Qualification Institute <br>(Public Organization)
                    </td>

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
                        <strong>ชุดข้อสอบ<?= $tool_typename ?> </strong><br />
						<?php if( $this->SharedModel->get_occlevelname($v->occ_level_id) != null )  echo $this->SharedModel->get_occlevelname($v->occ_level_id)['levelName'] ?>

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

            <!--<pagebreak orientation="landscape"></pagebreak> -->

            <div style="break-after:page;margin-top:10px"></div>
            <div class="">
                <table border="1" style="border-collapse: collapse;overflow:wrap;font-size:16px" autosize="1">
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
        </div>
    </div>
</body>

</html>

<script>
function printDiv() {
    var divElements = document.getElementById("requiredprinting").innerHTML;
    document.body.innerHTML =
        "<html><head>" +
        "<title></title>" +
        "</head><body>" +

        divElements +
        "</body>";
    window.print();
    self.close();
}
</script>