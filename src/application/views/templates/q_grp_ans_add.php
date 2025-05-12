<?php

$initial = 1;
$i = 1;
for ($i = 1; $i <= 1; $i++) {
?>
<div class="overlay" id="overlay"></div>
    <div class="popup" id="popup">
        <h2>Select Options</h2>
        <form id="checkboxForm">
            <label><input type="checkbox" name="options[]" value="Option 1">&nbsp;&nbsp; &nbsp; UOC 1</label><br>
            <label><input type="checkbox" name="options[]" value="Option 2">&nbsp;&nbsp; &nbsp; UOC 2</label><br>
            <label><input type="checkbox" name="options[]" value="Option 3">&nbsp;&nbsp; &nbsp; UOC 3</label><br>
            <button type="button" id="submitPopup">Submit</button>
            <button type="button" id="closePopup">Close</button>
        </form>
    </div>
<div class="col-md-12">

<div id="form_q_g<?//= $uoc_code ?><?//= $eoc_code ?>">
        <div id="g<?//= $uoc_code ?><?//= $eoc_code ?><?= $i ?>">
		<div class="card template">
	<div class="row" style="padding-right:10px;padding-left:10px;padding-top:10px">
	
					<div class="col-md-7">
                        <label for=""><strong>แนวทางคำตอบ</strong></label>&nbsp; &nbsp; &nbsp;
						<input type="radio" value="1" checked
                            id="list[<?//= $uoc_code ?>][<?//= $eoc_code ?>][<?//= $i ?>][grp_question_status1]"
                            name="list[<?//= $uoc_code ?>][<?//= $eoc_code ?>][<?//= $i ?>][grp_question_status]">
                        &nbsp; ใช้งาน &nbsp; &nbsp; &nbsp;
                        <input type="radio" value="0"
                            id="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][grp_question_status2]"
                            name="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][grp_question_status]">
							&nbsp; ไม่ใช้งาน &nbsp; &nbsp; &nbsp;
					</div>		
					<div class="col-md-5 text-right">
                        <div class="btn-group  btn-group-sm edit-area" role="group">
                            <button type="button" class="btn btn-success2 add"
                                onClick="" id="showPopup">
                                <i class="fa fa-plus-circle" aria-hidden="true"><label style="padding-left:2px;">UOC</label></i>
                            </button>&nbsp; &nbsp; &nbsp;
							<button type="button" class="btn btn-success add"
                                onClick="add_q_grp_form('<?= $uoc_code ?>','<?= $eoc_code ?>','<?= $i ?>')">
                                <i class="fa fa-plus-circle" aria-hidden="true"><label style="padding-left:2px;">คำถาม</label></i>
                            </button>&nbsp; &nbsp; &nbsp;
					<!--		<button type="button" class="btn btn-success3 add"
                                onClick="add_q_grp_form('<?//= $uoc_code ?>','<?//= $eoc_code ?>','<?//= $i ?>')">
                                <i class="fa fa-plus-circle" aria-hidden="true"><label style="padding-left:2px;">กลุ่มคำถาม</label></i>
                            </button>   -->
                        </div>
                    </div>
					<div class="col-md-12" style="padding:5px;">
                        <textarea class="ckeditor chgrpq" id="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][grpquestion]"
                            name="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][grpquestion]"></textarea>
                    </div>
					
			</div>
		<div id="form_q_a<?//= $uoc_code ?><?//= $eoc_code ?>">
        <div id="f<?//= $uoc_code ?><?//= $eoc_code ?><?= $i ?>">	
            <div class="card template">
                <div class="row" style="padding-right:10px;padding-left:10px;padding-top:10px">
                    <div class="col-md-7">
                        <label for="">สถานะคำถาม เพิ่มใหม่</label>&nbsp; &nbsp; &nbsp;
                        <input type="radio" value="1" checked
                            id="list[<?//= $uoc_code ?>][<?//= $eoc_code ?>][<?//= $i ?>][question_status1]"
                            name="list[<?//= $uoc_code ?>][<?//= $eoc_code ?>][<?//= $i ?>][question_status]">
                        &nbsp; ใช้งาน &nbsp; &nbsp; &nbsp;
                        <input type="radio" value="0"
                            id="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][question_status2]"
                            name="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][question_status]">
                        &nbsp; ไม่ใช้งาน &nbsp; &nbsp; &nbsp;
				<!--		<select data-dropup-auto="false"
                                                id="exam_type" name="exam_type" required=""
                                                data-live-search="true"> 
                                              <option value="0">--กรุณาเลือก--</option>   
                                                
                                            </select>    -->
						<input class="col-md-1" type="text" id="marks_for_q" name="marks_for_q">
                    </div>
                    <div class="col-md-5 text-right">
                        <div class="btn-group  btn-group-sm edit-area" role="group">
                            <button type="button" class="btn btn-success2 add"
                                onClick="" id="showPopup">
                                <i class="fa fa-plus-circle" aria-hidden="true"><label style="padding-left:2px;">UOC</label></i>
                            </button>&nbsp; &nbsp; &nbsp;
							<button type="button" class="btn btn-success add"
                                onClick="add_q_form('<?= $uoc_code ?>','<?= $eoc_code ?>','<?= $i ?>')">
                                <i class="fa fa-plus-circle" aria-hidden="true"><label style="padding-left:2px;">คำถาม</label></i>
                            </button>&nbsp; &nbsp; &nbsp;
					<!--		<button type="button" class="btn btn-success3 add"
                                onClick="add_q_grp_form('<?//= $uoc_code ?>','<?//= $eoc_code ?>','<?//= $i ?>')">
                                <i class="fa fa-plus-circle" aria-hidden="true"><label style="padding-left:2px;">กลุ่มคำถาม</label></i>
                            </button>   -->
                        </div>
                    </div>
                </div>
		
                <hr>
                <div class="card-body row">
				
                    <input type="hidden" class="form-control"
                        name="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][order_line]" value="<?= $i ?>" />
                    <input type="hidden" class="form-control"
                        name="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][uoc_code]" value="<?= $uoc_code ?>" />
                    <input type="hidden" class="form-control"
                        name="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][eoc_code]" value="<?= $eoc_code ?>" />
					
                    <div class="col-md-12" style="padding:5px;">
                        <label for=""><strong>คำถาม ข้อที่ <span class="num_q<?= $uoc_code ?><?= $eoc_code ?>"
                                    id="q_num_<?= $uoc_code ?><?= $eoc_code ?><?= $i ?>">
                                    <?= $i ?></span></strong></label>
                        <textarea class="ckeditor ckq"
                            id="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][question]"
                            name="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][question]"></textarea>
                    </div>
                    <div class=" col-md-12">
                        <label for=""><strong>แนวทางคำตอบ</strong></label>
                        <textarea class="ckeditor cka" id="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][answer]"
                            name="list[<?= $uoc_code ?>][<?= $eoc_code ?>][<?= $i ?>][answer]"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
   </div>
   </div>
</div>
</div>

<?php  } ?>