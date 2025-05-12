<div class="modal fade" id="modal_criteriaforexam" data-backdrop="">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>จัดชุดข้อสอบ</strong> </h5>
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
                                        <input type="hidden" class="form-control" id="occ_level_id"
                                            name="occ_level_id" />
                                        <input type="hidden" class="form-control" id="exam_schedule_id"
                                            name="exam_schedule_id" />
                                        <input type="hidden" class="form-control" id="txt_tool_type"
                                            name="txt_tool_type" />
                                        <div class="col-md-12 col-form-label">
                                            <span id="occ_level_name"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-form-label">
                                            สถานที่สอบ : <span id="place"></span>
                                            วันที่สอบ :
                                            <span id="exam_date"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 col-form-label">
                                            ชุดข้อสอบ
                                        </div>
                                        <div class="col-md-5">
                                            <select class="form-control" data-dropup-auto="false" id="template"
                                                name="template" required="" data-live-search="true">
                                                <option value="0">--ทั้งหมด--</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-primary btn-bg btn-md"
                                                id="btn_priview_choose_exam" name="btn_priview_choose_exam">
                                                <i class="fa fa-eye" aria-hidden="true"></i> ดูข้อสอบ
                                            </button>
                                        </div>
                                    </div>
                                    <br />
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="col-md-12" style="text-align:center">
                        <button type="button" class="btn btn-primary btn-bg" id="btn_pickexam" name="btn_pickexam">
                            ตกลง
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>

<script>
$("#btn_priview_choose_exam").click(function() {
    var template_id = $("#template").val();
    var tool_type = $("#txt_tool_type").val();
    var template_type = $("#txt_template_type").val();
    var exam_type = $("#txt_exam_type").val();

    if (template_id == 0 || template_id == "") {
        sweet_alert("<strong>กรุณาเลือกชุดข้อสอบ!!!</strong>");
    } else {
        if (tool_type == 4) {
            window.open(
                "../../simulation/SimulationTools/exam_preview?template_id=" +
                template_id,
                "_blank"
            );
            /*window.open(
                "../../templates/Longanswer/new_preview?template_id=" +
                template_id +
                "&tool_type=4" +
                "&doc_type=2",
                "_blank"
            );*/
        } else if (tool_type == 5) {
            window.open(
                "../../demonstration/DemonstrationTools/exam_preview?template_id=" +
                template_id,
                "_blank"
            );
        } else if (tool_type == 3) {
            window.open(
                "../../interview/InterviewTool/preview?template_id=" + template_id,
                "_blank"
            );
        } else if (tool_type == 2) {
            window.open(
                "../../portfolio/PortfolioTools/exam_preview?template_id=" +
                template_id,
                "_blank"
            );
        } else if (tool_type == 6) {
            window.open(
                "../../observation/Observation/exam_preview?template_id=" +
                template_id,
                "_blank"
            );
            /*if (template_type == "3" && exam_type == "3") {
                window.open(
                    "../../templates/Longanswer/preview?template_id=" +
                    template_id +
                    "&tool_type=6",
                    "_blank"
                );
            } else {
                window.open(
                    "../../observation/Observation/exam_preview?template_id=" +
                    template_id,
                    "_blank"
                );
            }*/

            /* window.open(
                 "../../templates/Longanswer/preview?template_id=" +
                 template_id +
                 "&tool_type=6",
                 "_blank"
             );*/

        } else if (tool_type == 7) {
            window.open(
                "../../tools/Thirdparty/exam_preview?template_id=" + template_id,
                "_blank"
            );
        } else {
            sweet_alert("<strong>อยู่ระหว่างดำเนินการ!!!</strong>");
        }
    }
})

function validate() {
    var isValid = true;
    var template_id = $("#template").val();
    if (template_id == "0") {
        sweet_alert("<strong>กรุณาเลือกชุดข้อสอบ!!!</strong>");
        isValid = false;
    }

    return isValid;
}

$("#btn_pickexam").click(function() {
    //console.log(JSON.stringify($("#form_exam_criteria").serializeJSON()));
    var valid = validate();
    if (valid) {
        $.ajax({
            method: "POST",
            url: "../../approve/Approve/pickexam",
            data: {
                dt: JSON.stringify($("#form_exam_criteria").serializeJSON()),
                action: "create",
            },
            success: function(response) {
                if (response == 1) {
                    $("#modal_criteriaforexam").modal("hide");
                    success_alert("<strong>กำหนดชุดข้อสอบเรียบร้อยแล้ว</strong>")
                    search(1)
                }
            },
        });
    }
});
</script>