<div class="row">
    <form id="form_assessment" name="form_assessment">
        <?php
			if ($template_detail != '') { ?>
			<table class="table table-bordered">
				<thead>
					<tr style="background-color:#cccccc;" rowspan=''>
						<th scope="col" class="text-center" style="width:50%" colspan="2" rowspan="2">
							<b>รายการเอกสาร</b>
						</th>
						<th scope="col" class="text-center"><b>ผ่าน</b>
						</th>
						<th scope="col" class="text-center"><b>ไม่ผ่าน</b>
						</th>
					</tr>
				</thead>
				<?php
					$i = 0;
					$uoc_ = '';
					$n = 0;
					foreach ($template_detail as $row) {
						$n++;
						$uoc_data = $this->SharedModel->get_uocname($row->uoc_code);
					?>
					<tbody>
						<?php if ($uoc_ != $row->uoc_code) {
						$n = 1; ?>
						<tr>
							<td colspan="6" style="background-color:#f1f1f1;">
								<b>หน่วยสมรรถนะ : <?= $row->uoc_code ?>
								<?= $uoc_data["uoc_name"] ?></b>
							</td>
						</tr>
						<?php } ?>
						<?php $uoc_ = $row->uoc_code; ?>
						<tr>
							<td colspan="2">
								<b><?= $n ?>) <?= $row->main_topic ?> </b>
								<input type="hidden" class="form-control" style=" background-color: #fff "
								name="detail[<?= $i ?>][tp_checklist_id]" value="<?= $row->id ?>" placeholder="" />
								<input type="hidden" class="form-control" style=" background-color: #fff "
								name="detail[<?= $i ?>][uoc_code]" value="<?= $row->uoc_code ?>" placeholder="" />
								<input type="hidden" class="form-control" style=" background-color: #fff "
								name="detail[<?= $i ?>][score]" value="" placeholder="" />
								<input type="hidden" class="form-control" style=" background-color: #fff "
								name="detail[<?= $i ?>][criteria_used_byexamier]" value="0" placeholder="" />
							</td>
							
							<td colspan="1" style="width:15%">
								<input style=" width: 100%; height: 1.5em; margin-top:10px" type="radio" id="<?= $row->id ?>"
								name="detail[<?= $i ?>][exam_status]" value="1" checked>
							</td>
							
							<td colspan="1" style="width:15%">
								<input style=" width: 100%; height: 1.5em; margin-top:10px" type="radio" id="<?= $row->id ?>"
								name="detail[<?= $i ?>][exam_status]" value="0">
							</td>
						</tr>
					</tbody>
					<?php $i++;
					} ?>
			</table>
			
			
		<div class="col-md-12">
				<br>
				<div class="col-md-12">
					<b>สรุปผลการประเมิน</b>
				</div>
				<div class="col-md-12">
					&nbsp;&nbsp; <input type="radio" name="assessment_status" value="1" checked> ผ่าน &nbsp; &nbsp;
					<input type="radio" name="assessment_status" value="0"> ไม่ผ่าน
				</div>
				<br />
				
				<div></div>
				<strong>เอกสารเพิ่มเติม</strong>
			
			
			<input type="hidden" id="num_input" value="1">
			<div class="row" id="row0">
				<div class="col-md-3">
					<input type="text" class="form-control name-file" id="" name="" value="" placeholder="ชื่อไฟล์">
				</div>
				<div class="col-md-9">
					<input type="file" class="form-control-file file-data" id="file0">
				</div>
			</div>
			
			<div class="row row-form">
				<div class="col-md-12">
					<button type='button' class="btn btn-success add_more"><i class="fa fa-plus"></i></button>
				</div>
			</div>
		
		</div>
		
		
		
		
	</form>
</div>



<form id="form" name="form">
	
	<br />
	
	<div class="row">
		
		<div class="col-md-12">
			
			<?php require_once dirname(__FILE__) . "../../../shared/assessment_result.php"; ?>
			
		</div>
		
		</div>
		
		
		
		<div class="row">
		
		<div class="col-md-12 text-center">
			
			<button type="button" class="btn btn-primary" id="btn_save">
				
				<i class="fa fa-floppy-o" aria-hidden="true"></i>
				
			<strong>บันทึก</strong> </button>
			
			&nbsp;
			
			<button type="button" class="btn btn-danger" id="btn_cancel" name="btn_cancel"
			onclick="goto_applicant_assessment()">
				
				<i class="fa fa-repeat" aria-hidden="true"></i>
				
			<strong>ยกเลิก</strong> </button>
			
			&nbsp;
			
		</div>
		
	</div>
	
</form>



<?php } else { ?>

<div class="text-center">
	
	<span style="color:red;font-size:18px">
		
		<b>== ไม่พบข้อมูลการทำแบบประเมิน ==</b>
		
	</span>
	
</div>



<?php } ?>



<script>
	$('.assessment-result-form').hide()
	</script>										