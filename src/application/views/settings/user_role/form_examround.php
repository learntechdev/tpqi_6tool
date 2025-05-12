<div class="modal fade" id="form_examround" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel"><span id="modal_title"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <input type="hidden" class="form-control" id="txt_username">
                        <label class="col-md-3 col-form-label text-right"> รอบสอบ<span class="span-req-field">*</span></label>
                        <div class="col-md-7" style="padding-bottom:5px">
                            <input type="text" class="form-control" id="examround">
                        </div>
                    </div>
                </form>
                <div class="col-md-12 text-center" style="margin-top:5px">
                    <button type="button" class="btn btn-primary" onclick="authorized_examround()">บันทึก</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row text-left">
                    <label>แสดงรายการรอบสอบที่มีสิทธิ์</label>
                </div>
                <div class="row" id="show_data_examround">
                </div>

            </div>
        </div>
    </div>
</div>