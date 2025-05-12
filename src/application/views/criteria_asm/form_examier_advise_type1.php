<div class="">
    <div class="col-md-12" style="padding-left:0px;">
        <div class="d-flexss">
		<div class="sub-containers" style="width: 50%; padding-bottom: 5px;">
            <label class="form-label newtypelabel">
             <!--   <input type="radio" id="criteria_used_byexamier_0" name="criteria_used_byexamier" value="0" Checked />   -->
                ไม่กำหนดเกณฑ์
			</label>
			<div class="" style="padding-bottom:5px; display:flex;padding-left:0px;">
				<input type="text" id="criteria_used_byexamier1" name="criteria_used_byexamier1" value="" />
				<label class="col-md-3 col-form-label">marks</label>
			</div>
			
		</div>
		
        <div class="sub-containers" style="width: 50%; padding-bottom: 5px;">
            <label class="form-label newtypelabel">
       <!--         <input type="radio" id="criteria_used_byexamier_1" name="criteria_used_byexamier" value="1" />    -->
                กำหนดเกณฑ์
			</label>
			<div class="col-md-3" style="padding-bottom:5px;display:flex;padding-left:0px;">
				<input type="text" id="criteria_used_byexamier2" name="criteria_used_byexamier2" value="" />
				<label class="col-md-3 col-form-label">%</label>
			</div>
			
<!--            <div class="col-md-5" style="padding-bottom:5px">
                <?php
					//$dt = $this->MasterDataModel->criteria_examier_advise_chklist();
					//if (is_array($dt)) {
					?>
					
					<select class="form-control criteria_type_byexamier" data-dropup-auto="false"
                    id="criteria_type_byexamier" name="criteria_type_byexamier" required="" data-live-search="true"
                    style="height:40px">
						<option value="0">--กรุณาเลือก--</option>
						<?php //foreach ($dt as $v) {?>
							<option value="<?php //echo $v->criteria_type_id; ?>">
								<?php// echo $v->title; ?>
							</option>
							<?php //}
						//}
					?>
				</select>
				
                <input type="hidden" class="form-control" id="txt_criteria_type_byexamier"
				name="txt_criteria_type_byexamier" />
			</div>
			
            <div id="div_criteria_detail" style="display:none">
                <button type="button" class="btn btn-primary" id="btn_view_criteria">
                    <i class="fa fa-eye" aria-hidden="true"></i>
				<strong>รายละเอียด</strong> </button>
			</div>  -->
            <?php //require_once dirname(__FILE__) . "/modal_criteria_detail.php";?>
		</div>
	</div>
</div>



<script>
	$(document).ready(function() {
		$('#criteria_type_byexamier').prop('disabled', true);
	});
	
	$("#criteria_type_byexamier").change(function() {
		$("#div_criteria_detail").show();
	});
	
	
	
	$("#btn_view_criteria").click(function() {
		get_criteria_detail();
	});
	
	function get_criteria_detail() {
		$.ajax({
			url: "../../settings/CriteriaASM/get_criteria_detail",
			method: "POST",
			data: {
				criteria_type_id: $("#criteria_type_byexamier").val(),
			},
			dataType: "JSON",
			success: function(data) {
				var rs = JSON.parse(JSON.stringify(data));
				// console.log(rs);
				$(".modal-body #txt_criteria_detail").html(rs[0].description);
				$("#modal_criteria_detail").modal("show");
			},
		});
	}
	
	$('input[type=radio][name=criteria_used_byexamier]').change(function() {
		if (this.value == '1') {
			$('#criteria_type_byexamier').prop('disabled', false);
			} else {
			$('#criteria_type_byexamier').prop('disabled', true);
			$("#criteria_type_byexamier").val('0');
		}
	});
</script>	