<div class="modal fade" id="form_criteria_tool" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span id="modal_title"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
<input type="hidden" id="form_type" >
<input type="hidden" id="criteria_type_id">

    <form>
        <div class="form-group">

            <label for="">ชื่อเกณฑ์การประเมิน	</label>
            <input type="text" class="form-control" id="title">
            <span style="color:red" id="valid_title"></span>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">รายละเอียดเกณฑ์การประเมิน	</label>

            <textarea class="form-control"  rows="4" id="description"></textarea>
            <span style="color:red" id="valid_description"></span>

        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">คะแนนต่ำสุด	</label>
            <input type="number" class="form-control" id="min_score">
            <span style="color:red" id="valid_min_score"></span>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">คะแนนสูงสุด	</label>
            <input type="number" class="form-control" id="max_score">
            <span style="color:red" id="valid_max_score"></span>

        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">สถานะ	</label><br>
                <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="status1" value="1" checked>
                    <label class="form-check-label" for="status1" >
                    ใช้งาน
                    </label>
                </div>
                <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="status0" value="0">
                    <label class="form-check-label" for="status0">
                        ปิดใช้งาน
                    </label>
                </div>
        </div>
    </form>

      </div>
      <div class="modal-footer text-right">
      <button type="button" class="btn btn-primary" onclick="btn_save()">บันทึก</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
      </div>
    </div>
  </div>
</div>
