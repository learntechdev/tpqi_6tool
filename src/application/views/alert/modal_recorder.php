<!--<link href="<?=base_url();?>assets/css/recorder.css?<?=date("YmdHis")?>" rel="stylesheet" type="text/css">-->

<div class="modal fade" id="modal_recorder" data-backdrop="">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">อัดคลิปเสียง</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p style="color:blue;text-align:center">
                    <strong>
                        <span id="span_msg" name="span_msg"></span>
                    </strong><br />
                <div>
                    <input type="hidden" value="" id="txt_uoc_code" name="txt_uoc_code" />
                    <input type="hidden" value="" id="txt_pc_code" name="txt_pc_code" />
                    <input type="hidden" value="" id="txt_app_id" name="txt_app_id" />
                    <input type="hidden" name="template_detail_id" id="template_detail_id">

                </div>
                </p>
                <div style="color:blue;text-align:center">
                    <div class="btn-group  btn-group-sm" role="group" id="controls">
                        <button style="padding:7px" type="button" class="btn btn-warning" id="recordButton"
                            name="recordButton">
                            <i class="fa fa-microphone" aria-hidden="true"></i> Record
                        </button>
                        <button type="button" class="btn btn-success" id="pauseButton" name="pauseButton">
                            <i class="fa fa-pause-circle-o" aria-hidden="true"></i> Pause</button>
                        <button type="button" class="btn btn-danger" id="stopButton" name="stopButton">
                            <i class="fa fa-stop-circle-o" aria-hidden="true"></i> Stop
                        </button>
                    </div>
                </div>

                <div id="formats"></div>
                <!--<p><strong>คลิปเสียง:</strong></p>-->
                <ol id="recordingsList" name="recordingsList"></ol>
                <input type="hidden" id="txt_url" name="txt_url">
                <input type="hidden" id="txt_filename" name="txt_filename">
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?=base_url();?>assets/js/recorder/recorder.js?<?=date("YmdHis")?>">
</script>
<script type="text/javascript" src="<?=base_url();?>assets/js/recorder/app.js?<?=date("YmdHis")?>">
</script>