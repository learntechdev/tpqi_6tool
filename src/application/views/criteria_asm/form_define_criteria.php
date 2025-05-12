<div class="modal fade" id="modal_approvecriteria" data-backdrop="">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">กำหนดเกณฑ์การประเมิน</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form_exam_criteria" name="form_exam_criteria">
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 background-box">
                                    <div class="row">
                                        <input type="hidden" class="form-control" id="txt_action" name="txt_action" />
                                        <input type="hidden" class="form-control" id="txt_tool_type"
                                            name="txt_tool_type" />
                                        <input type="hidden" class="form-control" id="template_id" name="template_id"
                                            value="" />
                                        <input type="hidden" class="form-control" id="exam_schedule_id"
                                            name="exam_schedule_id" />
                                        <div class="col-md-12 col-form-label">
                                            <span id="occ_level_name"></span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-form-label">
                                            สถานที่สอบ : <span id="place">
                                            </span> วันที่สอบ :
                                            <span id="exam_date"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </br>

                            <div class="txt-title" style="text-align:left">เกณฑ์การประเมิน (ผู้ออกข้อสอบแนะนำ)</div>
                            <div class="row">
                                <div class="col-md-12 background-box">
                                    <div class="row">
                                        <div class="col-md-12 col-form-label">
                                            <span id="span_criteria" name="span_criteria"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br />

                            <div class="txt-title" style="text-align:left">เกณฑ์การประเมิน</div>

                            <div class="row">
                                <div class="col-md-12 background-box">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="col-md-4 col-form-label">
                                                <input type="radio" id="define_criteria_1" name="define_criteria_status"
                                                    value="1" checked />
                                                ไม่กำหนดเกณฑ์ผ่าน
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="row">
                                            <label class="col-md-3 col-form-label">
                                                <input type="radio" id="define_criteria_2" name="define_criteria_status"
                                                    value="2" />
                                                กำหนดเกณฑ์ผ่าน
                                            </label>

                                            <!-- <div class="col-md-3">

                                                <label for="">คะแนนเต็ม</label>

                                                <input type="number" class="form-control bg-textfield" id="full_score"

                                                    name="full_score" placeholder="ระบุคะแนนเต็ม" />

                                            </div>

                                            <div class="col-md-3">

                                                <label for="">คะแนนผ่าน</label>

                                                <input type="number" class="form-control bg-textfield" id="pass_score"

                                                    name="pass_score" placeholder="ระบุคะแนนผ่าน" />

                                            </div>-->

                                            <div class="col-md-2 col-form-label">
                                                <label for="">เปอร์เซ็นต์ผ่าน</label>
                                            </div>

                                            <div class="col-md-3">
                                                <input type="number" class="form-control bg-textfield"
                                                    id="percent_score" name="percent_score"
                                                    placeholder="ระบุเปอร์เซ็นต์ผ่าน" />
                                            </div>
                                        </div>
                                    </div>
                                    <br />
                                </div>
                            </div>
                            <br />
                        </div>
                    </div>
                    <div class="col-md-12" style="text-align:center">
                        <button type="button" class="btn btn-primary btn-bg" id="btn_define_criteria"
                            name="btn_define_criteria">
                            บันทึก
                        </button>
                        <button id="btn_cancel" name="btn_cancel" type="button" class="btn btn-secondary"
                            data-dismiss="modal">ยกเลิก</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<script type="text/javascript"
    src="<?= base_url(); ?>assets/custom_js/approve/form_define_criteria.js?<?= date("YmdHis") ?>">

</script>