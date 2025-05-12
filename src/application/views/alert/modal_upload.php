<!--<link href="<?=base_url();?>assets/css/recorder.css?<?=date("YmdHis")?>" rel="stylesheet" type="text/css">-->

<div class="modal fade" id="modal_upload" data-backdrop="">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">อัพโหลดคลิปเสียง</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
    
                <div style="color:blue;text-align:center">
                    <input type="file" id="sound_upload" name="sound_upload">
                </div>


            </div>

            <div class="modal-footer">
                <div style="color:blue;text-align:center">
                    <button type="button" class="btn btn-success" id="saveSound" name="saveSound">
                            <i class="fa fa-save" aria-hidden="true"></i> บันทึก</button>
                </div>
            </div>
        </div>
    </div>
</div>
