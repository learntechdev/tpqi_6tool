<?php //$this->load->view("breadcrumb/breadcrumb",$breadcrumb); 
?>

<div class="content-header">
    <h3>
        สรุปผลการประเมิน
    </h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a href="../../assessment/Assessment/index" style="color:red">สรุปผลการประเมิน</a>
        </li>
    </ol>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="min-height:480px">
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-md-12" style="margin-bottom:10px">
                            <div class="col-md-12 ">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="">คำค้น</label>
                                        <input type="text" class="form-control" id="keyword" placeholder="">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="">สถานะ</label>
                                        <select class="form-control " data-dropup-auto="false" id="ass_status"
                                            name="ass_status" required="" data-live-search="true">
                                            <option value="">--ทั้งหมด--</option>
                                            <option value="0">ยังไม่ได้ประเมินผล</option>
                                            <option value="1">ประเมินผลเรียบร้อยแล้ว</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3" style="padding-top:20px">
                                        <div class="btn-group  btn-group-md" role="group">
                                            <button type="button" class="btn btn-primary" id="btn_search"
                                                name="btn_search">
                                                <i class="fa fa-search" aria-hidden="true"></i> ค้นหา</button>
                                            <button type="button" class="btn btn-info" id="btn_clear" name="btn_clear">
                                                <i class="fa fa-repeat" aria-hidden="true"></i> ล้างค่า</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12" id="show_data">
                            <?php
							if (!empty($dataList)) {
								$this->load->view("assessment/list_assessment/showdata", array(
									"dataList" => $dataList,
								));
							} else { ?>

                            <div style="font-weight:bold;color:red;text-align:center">
                                <br> == ไม่พบข้อมูล ==
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?PHP=$_SESSION['username'] ?>
<?PHP if ($_SESSION['username'] == "1509901136681") { ?> <!-- hrdcode for rmutt -->
	<script>
			$("#show_data tbody:lt(8)").hide();
			$("#show_data tbody:gt(10)").hide();
	</script>
<?PHP } ?>
<?PHP if ($_SESSION['username'] == "3333344444555") { ?> <!-- hrdcode for rmutt -->
	<script>
			$("#show_data tbody:gt(1)").hide();
	</script>
<?PHP } ?>
<?PHP if ($_SESSION['username'] == "1470500010221" || $_SESSION['username'] == "3909900205801" || $_SESSION['username'] == "3119900038731" || $_SESSION['username'] == "3101201117635" || $_SESSION['username'] == "3451000652590" || $_SESSION['username'] == "3520400179890") { ?> <!-- hrdcode for rmutt -->
	<script>
			$("#show_data tbody:gt(1)").hide();
	</script>
<?PHP } ?>
<?PHP if ($_SESSION['username'] == "3130200144042") { ?> <!-- hrdcode for resk haircut -->
	<script>
			$("#show_data tbody:lt(4)").hide();
			$("#show_data tbody:gt(5)").hide();
			
			$("#show_data").append("<a href='http://asm.mylearntime.com/docs_forexam/20036/%E0%B8%84%E0%B8%B9%E0%B9%88%E0%B8%A1%E0%B8%B7%E0%B8%AD%E0%B9%80%E0%B8%88%E0%B9%89%E0%B8%B2%E0%B8%AB%E0%B8%99%E0%B9%89%E0%B8%B2%E0%B8%97%E0%B8%B5%E0%B9%88%E0%B8%AA%E0%B8%AD%E0%B8%9A_%E0%B8%8A%E0%B9%88%E0%B8%B2%E0%B8%87%E0%B8%97%E0%B8%B3%E0%B8%9C%E0%B8%A1%E0%B8%AA%E0%B8%95%E0%B8%A3%E0%B8%B5%20%E0%B8%A3%E0%B8%B0%E0%B8%94%E0%B8%B1%E0%B8%9A%204.pdf' target=_blank>เอกสารเพิ่มเติมอาชีพช่างทำผมสตรี ระดับ 4</a><br><a href='http://asm.mylearntime.com/docs_forexam/20037/%E0%B8%84%E0%B8%B9%E0%B9%88%E0%B8%A1%E0%B8%B7%E0%B8%AD%E0%B9%80%E0%B8%88%E0%B9%89%E0%B8%B2%E0%B8%AB%E0%B8%99%E0%B9%89%E0%B8%B2%E0%B8%97%E0%B8%B5%E0%B9%88%E0%B8%AA%E0%B8%AD%E0%B8%9A_%E0%B8%8A%E0%B9%88%E0%B8%B2%E0%B8%87%E0%B8%97%E0%B8%B3%E0%B8%9C%E0%B8%A1%E0%B8%9A%E0%B8%B8%E0%B8%A3%E0%B8%B8%E0%B8%A9%20%E0%B8%A3%E0%B8%B0%E0%B8%94%E0%B8%B1%E0%B8%9A4.pdf' target=_blank>เอกสารเพิ่มเติมอาชีพช่างทำผมบุรุษ ระดับ 4</a><br><br>");
			
			
	</script>
<?PHP } ?>

<script type="text/javascript" src="<?= base_url(); ?>assets/custom_js/exam/index.js?<?= date("YmdHis") ?>">

</script>