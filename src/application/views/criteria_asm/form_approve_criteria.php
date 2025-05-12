<div class="modal fade" id="modal_approvecriteria" data-backdrop="">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">อนุมัติเกณฑ์การประเมิน</h5>

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

                            <div class="txt-title" style="text-align:center">เกณฑ์การประเมินสำหรับการสอบ</div>

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

                            <div class="row">

                                <div class="col-md-12">

                                    <label class="col-md-2 col-form-label">

                                        <input type="radio" id="approve_status_5" name="approve_status" value="5"
                                            checked />

                                        อนุมัติ

                                    </label>

                                    <label class="col-md-2 col-form-label">

                                        <input type="radio" id="approve_status_6" name="approve_status" value="6" />

                                        ไม่อนุมัติ

                                    </label>

                                </div>

                            </div>



                            <div class="row">

                                <div class="col-md-12">

                                    <textarea class="form-control" name="" id="reason_disapproval" rows="4"
                                        name="reason_disapproval" style="background-color:white"
                                        placeholder="ระบุเหตุผล ที่ไม่อนุมัติเกณฑ์การสอบประเมิน"></textarea>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-12" style="text-align:center">

                        <button type="button" class="btn btn-primary btn-bg" id="btn_approve_criteria"
                            name="btn_approve_criteria">

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