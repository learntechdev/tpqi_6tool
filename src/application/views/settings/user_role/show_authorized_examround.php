<?php if (number_format($dataListExamRound["numRowsAll"]) == 0) { ?>
<div class="row">
    <div class="col-md-12" style="font-weight:bold;color:red;text-align:center">
        <br> == ไม่พบข้อมูล ==
    </div>
</div>
<?php } ?>
<?php if (is_array($dataListExamRound)) { ?>
<div class="table-responsive">
    <table class="table text-nowrap table-bordered">
        <thead class="bg-primary">
            <tr>
                <th class="text-center" style="width: 5%;font-weight:bold;">ลำดับ</th>
                <th class="text-center" style="width: 25%;font-weight:bold;">รอบสอบ</th>
                <th class="text-center" style="width: 15%;font-weight:bold;">วันที่สร้างรายการ</th>
                <th class="text-center" style="width: 10%;font-weight:bold;"></th>
            </tr>
        </thead>
        <?php
            $i = 0;
            foreach ($dataListExamRound["result"] as $key => $v) {
                $i++;
            ?>
        <tbody>
            <tr>
                <td>
                    <?= (($dataListExamRound["pageNo"] - 1) * $dataListExamRound["perPage"]) + $i; ?>
                </td>
                <td><?= $v['tpqi_exam_no'] ?></td>
                <td class="text-wrap">
                    <?= $this->BaseModel->dateToThai($v['created_date'], true) ?> น.
                </td>
                <td style="text-center">
                    <div class="btn-group  btn-group-sm" role="group">
                        <button type="button" title="ลบ" alt="ลบ" class="btn btn-danger" onClick="cancelAuthorizedExamround(<?= $v['id'] ?>)">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
        <?php } ?>
    </table>
</div>
<?php }

if (!empty($dataListExamRound)) {
    $this->load->view("pagination/show_pagination", array(
        "dataList" => $dataListExamRound,
    ));
}
?>

<script>
function cancelAuthorizedExamround(id) {
    Swal.fire({
        title: "ยืนยัน!!!",
        text: "คุณต้องการลบข้อมูลใช่หรือไม่?",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        confirmButtonText: "ใช่",
        cancelButtonText: "ยกเลิก",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                method: "POST",
                url: "../../settings/UserRole/cancelAuthorizedExamround",
                data: {
                    username: $("#txt_username").val(),
                    id: id
                },
                dataType: "JSON",
                success: function(res) {
                    // alert(res);
                    if (res == 1) {
                        success_alert("<strong>ลบข้อมูลเรียบร้อยแล้ว</strong>");
                        showauthorized_examround(1);
                    }
                },
            });
        }
    });
}

function showauthorized_examround(prm_page_no) {
    $.ajax({
        url: "../../settings/UserRole/getAuthorizedExamround",
        method: "GET",
        data: {
            page_no: prm_page_no,
            per_page: "10",
            username: $("#txt_username").val()
        },
        success: function(data) {
            $("#show_data_examround").empty();
            $("#show_data_examround").html(data);
        },
    });
}

function page(page_no) {
    showauthorized_examround(page_no);
}
</script>