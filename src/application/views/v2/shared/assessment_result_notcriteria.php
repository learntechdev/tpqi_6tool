<div class="row">
    <div class="col-md-12">
        <div class="card" style="min-height:480px">
            <div class="card-body">
                <h4 class="title">
                    <label class="col-md-2 col-form-label">
                        สรุปผลการประเมิน
                    </label>
                </h4>

                <div class="col-md-12 ">
                    <?php

                    ?>
                    <label class="radio-inline">
                        <input type="radio" id="exam_result1" name="exam_result" value="ผ่าน" <?php if ($dataForEdit["result"]["exam_result"] == "ผ่าน") {
                                                                                                    echo 'checked="checked"';
                                                                                                } ?>>&nbsp;&nbsp;ผ่าน
                    </label>&nbsp; &nbsp;&nbsp; &nbsp;
                    <label class="radio-inline">
                        <input type="radio" id="exam_result2" name="exam_result" value="ไม่ผ่าน"
                            <?php if ($dataForEdit["result"]["exam_result"] == "ไม่ผ่าน") {
                                                                                                        echo 'checked="checked"';
                                                                                                    } ?>>&nbsp;&nbsp;ไม่ผ่าน
                    </label>
                </div>

                <br />
                <div class="col-md-12">
                    <label for=""><strong>ความคิดเห็น/ข้อเสนอแนะ</strong></label>
                    <?php $this->load->view(
                        "richtext/richtext",
                        array(
                            "id" => "recomment",
                            "data" => $dataForEdit["result"]["recomment"]
                        )
                    ); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
CKEDITOR.replace('recomment', {
    fullPage: false, // ถ้ากำหนดเป็น false จะลบแท็ก HEAD/BODY/HTML ออกไม่ต้องเก็บลง db
    allowedContent: true,
    autoGrow_onStartup: true,
    enterMode: CKEDITOR.ENTER_BR,
    extraPlugins: 'wysiwygarea'
});
</script>