<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ข้อสอบ<?= $tool_typename ?></title>
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/fonts_saraban/thsarabunnew.css?<?= date("YmdHis") ?>" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/tp_new/css/bootstrap.css?<?= date("YmdHis") ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

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

<body>
    
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
            
            <hr class="mb-0">

            <div class="row">
                <div class="col-1 my-auto">
                    <img src="<?= base_url(); ?>assets/img/logo/tpqi_logo1.jpg" class="w-100 py-4">
                </div>
                <div class="col my-auto">
                    <p class="mb-0">
                        สถาบันคุณวุฒิวิชาชีพ (องค์การมหาชน)
                        <br>
                        Thailand Professional Qualification Institute
                        <br>
                        (Public Organization)
                    </p>
                </div>
            </div>

            <hr class="mt-0 mb-4">

            <div class="row my-4">
                <div class="col text-center">
                    <p class="fs-normal mb-0">
                        <b>ข้อสอบ<?=$tool_typename;?></b>
                        <br />

                        <?php
                            $explode = preg_split('@ @', $occ_levelname, NULL, PREG_SPLIT_NO_EMPTY);
                            $countSpace = count($explode);
                            $splitOccupation = $countSpace - 3;
                            $occupation = "";

                            foreach($explode as $i =>$key) {
                                $spaceText = ($i == $splitOccupation) ? "<br>$key" : " $key";
                                $occupation = $occupation.$spaceText;
                            }
                        ?>

                        <b><?=$occupation;?></b>
                    </p>
                </div>
            </div>

            <div class="row my-4">
                <div class="col">

                    <?php
                        if (is_array($result)) {
                            foreach ($result as $v) {
                    ?>
                            <table class="table">
                                <tr>
                                    <td class="fs-small">
                                        <strong>คำอธิบายสำหรับเจ้าหน้าที่สอบ</strong>
                                        <br />
                                        &nbsp;&nbsp;&nbsp;&nbsp;<?= $v->desc_for_examier ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fs-small">
                                        <strong>คำอธิบายสำหรับผู้เข้ารับการประเมิน</strong>
                                        <br />
                                        &nbsp;&nbsp;&nbsp;&nbsp;<?= $v->des_for_applicant ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fs-small">
                                        <strong>เกณฑ์การประเมิน :</strong>

                                        <?php
                                            if ($v->criteria_used_byexamier == 0) {
                                                echo "ไม่กำหนดเกณฑ์";
                                            } else {
                                                $criteria_detail = $this->SharedModel->get_criteria_advise_type($v->criteria_type_byexamier);
                                                echo "ผู้ออกข้อสอบได้แนะนำการกำหนดเกณฑ์การประเมิน ดังนี้ " . "<br/> &nbsp;&nbsp;&nbsp;&nbsp;" . $criteria_detail["description"];
                                            }
                                        ?>

                                    </td>
                                </tr>
                            </table>
                            <table class="table">
                                <tr>
                                    <td class="fs-small">

                                    <?php 
                                        if ($v->case_study != "") { 
                                    ?>

                                        <strong>&nbsp;&nbsp; กรณีศึกษา</strong><br />
                                        &nbsp;&nbsp;<?= $v->case_study ?>

                                    <?php 
                                        } 
                                    ?>

                                    </td>
                                </tr>
                            </table>
                    <?php
                            }
                        } 
                    ?>

                    <div><strong>หน่วยสมรรถนะ</strong></div>

                    <?php 
                        if (is_array($rs_detail)) {
                            $tmp_uoc_code = "";

                            foreach ($rs_detail as $v_detail) {
                                if ($tmp_uoc_code != $v_detail->uoc_code) {
                                    $rs = $this->SharedModel->get_uocname($v_detail->uoc_code); 
                    ?>

                    <div>
                        <?php echo  $rs["uoc_code"] . " " . $rs["uoc_name"]; ?>
                    </div>

                    <?php 
                                    $tmp_uoc_code = $v_detail->uoc_code;
                                } 
                            }
                        } 
                    ?>
                    
                </div>
            </div>

            <div class="row my-4">
                <div class="col">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-gray">
                                <th>คำถาม </th>
                                <th>แนวคำตอบ </th>
                                <th class="fit">สถานะคำถาม </th>
                            </tr>
                        </thead>

                        <?php
                            if (is_array($rs_detail)) {
                                $tmp_uoc_code = "";
                                $j = 1;

                                foreach ($rs_detail as $v_detail) {
                                    $j++;
                        ?>

                        <tbody>
    
                            <?php
                                if ($tmp_uoc_code != $v_detail->uoc_code) {
                            ?>

                            <tr>
                                <td colspan="3" class="table-secondary">
                                    <?php $rs = $this->SharedModel->get_uocname($v_detail->uoc_code); ?>
                                    <strong><?php echo "หน่วยสมรรถนะ : " . $rs["uoc_code"] . " " . $rs["uoc_name"]; ?></strong>
                                </td>
                            </tr>

                            <?php
                                    $tmp_uoc_code = $v_detail->uoc_code;
                                    $j = 1;
                                }
                            ?>

                            <tr>
                                <td class="v-top"> <?php echo $j . "." . $v_detail->question ?> </td>
                                <td> <?= $v_detail->guide_answer; ?> </td>
                                <td class="v-top text-center"> <?= $v_detail->question_status == 1 ? "ใช้งาน" : "ไม่ใช้งาน" ?> </td>
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
    </section>
</body>

</html>