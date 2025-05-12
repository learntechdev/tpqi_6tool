<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <form>
            <br />
            <div class="row">
                <label for="api_url" class="col-md-2 col-form-label">ลิงค์เอพีไอ</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="api_url"
                        value="https://tpqi-net.tpqi.go.th/web_api/v1/all_qualification">
                </div>
            </div>
            <div class="row">
                <label for="" class="col-md-2 col-form-label">เพจเริ่มต้น</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" id="start_page" name="start_page" value="">
                </div>
            </div>
            <div class="row">
                <label for="" class="col-md-2 col-form-label">เพจสิ้นสุด</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" id="end_page" name="end_page" value="">
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
<script type="text/javascript"
    src="<?= base_url(); ?>assets/custom_js/setting/import_item_qualification.js?<?= date("YmdHis") ?>">
</script>
