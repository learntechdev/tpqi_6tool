<div>
    <form>
        <div class="row">
            <label for="api_url" class="col-md-2 col-form-label">ลิงค์เอพีไอ</label>
            <div class="col-md-10">
                <input type="text" class="form-control" id="api_url" value="">
            </div>
        </div>
        <!--<div class="row">
            <label for="" class="col-md-2 col-form-label">ชื่อผู้ใช้งาน</label>
            <div class="col-md-4">
                <input type="text" class="form-control" id="username">
            </div>
        </div>
        <div class="row">
            <label for="" class="col-md-2 col-form-label">รหัสผ่าน</label>
            <div class="col-md-4">
                <input type="password" class="form-control" id="password">
            </div>
        </div>-->
        <br />
        <div class="row" style="text-align:center">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary" id="btn_process">ประมวลผล</button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript" src="<?= base_url(); ?>assets/custom_js/setting/importdata.js?<?= date("YmdHis") ?>">
</script>