<?php if (number_format($dataList["numRowsAll"]) == 0) { ?>
<div class="row">
    <div class="col-md-12" style="font-weight:bold;color:red;text-align:center">
        <br> == ไม่พบข้อมูล ==
    </div>
</div>
<?php } ?>
<?php if (is_array($dataList)) { ?>
<div class="table-responsive">
    <table class="table text-nowrap table-bordered">
        <thead class="bg-primary">
            <tr>
                <th class="text-center" style="width: 5%;font-weight:bold;">ลำดับ</th>
                <th class="text-center" style="width: 25%;font-weight:bold;">ชื่อผู้ใช้งาน</th>
                <th class="text-center" style="width: 35%;font-weight:bold;">ชื่อ-นามสกุล</th>
                <th class="text-center" style="width: 10%;font-weight:bold;">สถานะ</th>
                <th class="text-center" style="width: 15%;font-weight:bold;">วันที่สร้างรายการ</th>
                <th class="text-center" style="width: 10%;font-weight:bold;"></th>
            </tr>
        </thead>
        <?php
            $i = 0;
            foreach ($dataList["result"] as $key => $v) {
                $i++;
            ?>
        <tbody>
            <tr>
                <td>
                    <?= (($dataList["pageNo"] - 1) * $dataList["perPage"]) + $i; ?>
                </td>
                <td>
                    <?= $v['username'] ?>
                </td>
                <td>
                    <?= $v['name'] ?>
                </td>
                <td class="text-wrap text-center">
                    <?= $v['flag'] == 1 ? "ใช้งาน" : "ไม่ใช้งาน" ?>
                </td>
                <td class="text-wrap">
                    <?= $this->BaseModel->dateToThai($v['created_date'], true) ?> น.
                </td>
                <td style="text-center">
                    <div class="btn-group  btn-group-sm" role="group">
                        <!-- <button type="button" title="แก้ไข" alt="แก้ไข" class="btn btn-info" onClick="">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </button> -->
                        <button type="button" title="สิทธิ์ในการเห็นคุณวุฒิวิชาชีพ" alt="สิทธิ์ในการเห็นคุณวุฒิวิชาชีพ" class="btn btn-success" onclick="gotoAocc(<?= $v['username'] ?>,<?= $v['id'] ?>)">
                            <i class="fa fa-cog" aria-hidden="true"></i>
                        </button>
                        <button type="button" title="สิทธิ์ในการเห็นรอบสอบ" alt="สิทธิ์ในการเห็นรอบสอบ" class="btn btn-info" onclick="gotoAER(<?= $v['username'] ?>,<?= $v['id'] ?>)">
                            <i class="fa fa-cog" aria-hidden="true"></i>
                        </button>
                        <button type="button" title="ลบ" alt="ลบ" class="btn btn-danger" onClick="cancel(<?= $v['username'] ?>)">
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

if (!empty($dataList)) {
    $this->load->view("pagination/show_pagination", array(
        "dataList" => $dataList,
    ));
}
?>