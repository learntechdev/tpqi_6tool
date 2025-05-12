<div class="col-md-12">
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header header-elements-sm-inline">
                    <span class="label_head">กำหนดเกณฑ์การประเมิน</span>
                </div>
                <div class="card-body" id="show_data">
                    <?php
if (!empty($dataList)) {
    $this->load->view("settings/criteria-asm/show_occ_level", array(
        "dataList" => $dataList,
    ));
}
?>

                </div>
            </div>
        </div>


        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="txt-title">เกณฑ์ที่ผู้ออกข้อสอบแนะนำ</div>
                    <div class="row">
                        <div class="col-md-12 background-box">
                            <div class="row">
                                <label class="col-md-4 col-form-label">
                                    <input type="radio" id="advise_status_score" name="advise_status_score" value="0"
                                        Checked />
                                    ไม่กำหนดเกณฑ์ผ่าน
                                </label>

                                <label class="col-md-3 col-form-label text-right">
                                    คะแนนเต็ม
                                </label>
                                <div class="col-md-3">
                                    <input type="number" class="form-control" style=" background-color: #fff " />
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-md-4 col-form-label">
                                    <input type="radio" id="advise_status_score" name="advise_status_score" value="1" />
                                    %
                                    ผ่าน
                                </label>
                                <div class="col-md-3">
                                    <input type="number" class="form-control" style=" background-color: #fff " />

                                </div>
                                <label class="col-md-3 col-form-label text-left">
                                    %
                                </label>
                            </div>

                            <div class="row">
                                <label class="col-md-4 col-form-label">
                                    <input type="radio" id="advise_status_score" name="advise_status_score" value="2" />
                                    คะแนนผ่าน
                                </label>
                                <div class="col-md-3">
                                    <input type="number" class="form-control" style=" background-color: #fff " />
                                </div>

                                <label class="col-md-3 col-form-label text-left">
                                    คะแนนเต็ม
                                </label>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" style=" background-color: #fff " />
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="txt-title">กำหนดเกณฑ์สำหรับการสอบ</div>
                    <div class="row">
                        <div class="col-md-12 background-box">
                            <div class="row">
                                <label class="col-md-4 col-form-label">
                                    <input type="radio" id="exam_status_score" name="exam_status_score" value="0"
                                        Checked />
                                    ไม่กำหนดเกณฑ์ผ่าน
                                </label>

                                <label class="col-md-3 col-form-label text-right">
                                    คะแนนเต็ม
                                </label>
                                <div class="col-md-3">
                                    <input type="number" class="form-control" style=" background-color: #fff " />
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-md-4 col-form-label">
                                    <input type="radio" id="exam_status_score" name="exam_status_score" value="1" /> %
                                    ผ่าน
                                </label>
                                <div class="col-md-3">
                                    <input type="number" class="form-control" style=" background-color: #fff " />

                                </div>
                                <label class="col-md-3 col-form-label text-left">
                                    %
                                </label>
                            </div>

                            <div class="row">
                                <label class="col-md-4 col-form-label">
                                    <input type="radio" id="exam_status_score" name="exam_status_score" value="2" />
                                    คะแนนผ่าน
                                </label>
                                <div class="col-md-3">
                                    <input type="number" class="form-control" style=" background-color: #fff " />
                                </div>

                                <label class="col-md-3 col-form-label text-left">
                                    คะแนนเต็ม
                                </label>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" style=" background-color: #fff " />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 text-center">
                            <br />
                            <button type="button" class="btn btn-primary"> บันทึก </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>