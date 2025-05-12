<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <form>
            <br />
            <div class="row">
                <label for="api_url" class="col-md-2 col-form-label">ลิงค์เอพีไอ</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="api_url"
                       
						value="https://tpqinet-api.tpqi.go.th/web_api/v1/item_exam_around">
						<!--value="https://tpqinet-api.tpqi.go.th/web_api/v1/item_exam_around">-->
                </div>
            </div>
            <div class="row">
                <label for="api_url" class="col-md-2 col-form-label">รอบสอบ</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" id="tpqi_exam_no" name="tpqi_exam_no" value="">
                </div>
            </div>
            <br />
            <div class="row" style="text-align:center">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary" id="btn_process">ประมวลผล</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-2"></div>
</div>
<script type="text/javascript" src="<?= base_url(); ?>assets/custom_js/setting/importdata.js?<?= date("YmdHis") ?>">
</script>
