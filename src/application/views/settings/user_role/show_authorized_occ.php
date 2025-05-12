<?php if (number_format($dataListAocc["numRowsAll"]) == 0) { ?>
<div class="row">
    <div class="col-md-12" style="font-weight:bold;color:red;text-align:center">
        <br> == ไม่พบข้อมูล ==
    </div>
</div>
<?php } ?>
<?php if (is_array($dataListAocc)) { ?>
<div class="table-responsive">
    <table class="table text-nowrap table-bordered">
        <thead class="bg-primary">
            <tr>
                <th class="text-center" style="width: 5%;font-weight:bold;">ลำดับ</th>
                <th class="text-center" style="width: 25%;font-weight:bold;">ชื่อคุณวุฒิวิชาชีพ</th>
                <th class="text-center" style="width: 15%;font-weight:bold;">วันที่สร้างรายการ</th>
                <th class="text-center" style="width: 10%;font-weight:bold;"></th>
            </tr>
        </thead>
        <?php
            $i = 0;
            foreach ($dataListAocc["result"] as $key => $v) {
                $i++;
            ?>
        <tbody>
            <tr>
                <td>
                    <?= (($dataListAocc["pageNo"] - 1) * $dataListAocc["perPage"]) + $i; ?>
                </td>
                <td><?php
                            $occ = $this->MasterDataModel->getOCCName($v['occ_level_id']); ?>
                    <?= $occ['tier1_title'] ?> <?= $occ['tier2_title'] ?> <?= $occ['tier3_title'] ?> <?= $occ['level_name'] ?></td>
                <td class="text-wrap">
                    <?= $this->BaseModel->dateToThai($v['created_date'], true) ?> น.
                </td>
                <td style="text-center">
                    <div class="btn-group  btn-group-sm" role="group">
                        <button type="button" title="ลบ" alt="ลบ" class="btn btn-danger" onClick="cancelAocc(<?= $v['occ_level_id'] ?>)">
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

if (!empty($dataListAocc)) {
    $this->load->view("pagination/show_pagination", array(
        "dataList" => $dataListAocc,
    ));
}
?>

<script>
function cancelAocc(occ_level_id) {
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
                url: "../../settings/UserRole/cancelAocc",
                data: {
                    username: $("#txt_username").val(),
                    occ_level_id: occ_level_id
                },
                dataType: "JSON",
                success: function(res) {
                    // alert(res);
                    if (res == 1) {
                        success_alert("<strong>ลบข้อมูลเรียบร้อยแล้ว</strong>");
                        showAocc(1);
                    }
                },
            });
        }
    });
}

function page(page_no) {
    showAocc(page_no);
}
</script>