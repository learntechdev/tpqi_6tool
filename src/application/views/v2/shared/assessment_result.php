<div class="row">
    <div class="col-md-12">
        <div class="card" style="min-height:480px">
            <div class="card-body">
                <h4 class="title">
                    <label class="col-md-2 col-form-label">
                        ผลการประเมิน
                    </label>
                </h4>
                <div class="row assessment-result-form">
                    <label class="col-md-1 col-form-label text-right">
                        คะแนนรวม
                    </label>
                    <div class="col-md-2">
                        <input type="number" class="form-control" id="total_score" name="total_score" readonly
                            value="<?php if( $dataForEdit["result"] != null )  echo $dataForEdit["result"]["total_score"] ?>" />
							
                    </div>
                    <label class="col-md-1 col-form-label text-right">
                        คะแนนเต็ม
                    </label>
                    <div class="col-md-2">
                        <input type="number" class="form-control" id="full_score" name="full_score" readonly
                            value="<?php if( $dataForEdit["result"] != null )  echo $dataForEdit["result"]["full_score"] ?>" />

                    </div>
                    <label class="col-md-1 col-form-label text-right">
                        คิดเป็น(%)
                    </label>

                    <div class="col-md-2">
                        <input type="number" class="form-control" id="exam_percent_score" name="exam_percent_score"
                            readonly value="<?php if( $dataForEdit["result"] != null )  echo $dataForEdit["result"]["exam_percent_score"] ?>" />
						
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" id="exam_result" name="exam_result" readonly
                            value="<?php if( $dataForEdit["result"] != null )  echo $dataForEdit["result"]["exam_result"] ?>" />
						
                    </div>
                </div>

                <hr class="assessment-result-form" />
                <div class="col-md-12">
                    <label for=""><strong>ความคิดเห็น/ข้อเสนอแนะ</strong></label>
                    <?php 
						if( $dataForEdit["result"] != null ) {					
							$this->load->view(
								"richtext/richtext",
								array(
									"id" => "recomment",
									"data" => $dataForEdit["result"]["recomment"]
								)
							); 
						}else{
							$this->load->view(
								"richtext/richtext",
								array(
									"id" => "comment",
									"data" => ""
								)
							); 						
						}
					?>
                </div>
            </div>
        </div>
    </div>
</div>