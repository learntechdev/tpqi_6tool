<?php if (number_format($dataList["numRowsAll"]) == 0) { ?>
<div style="font-weight:bold;color:red;text-align:center">
    <br> == ไม่พบข้อมูล ==
</div>
<?php } ?>
<?php if (is_array($dataList)) { ?>
<div class="table-responsive">
    <table class="table text-nowrap table-bordered">
        <thead class="bg-primary">
            <tr>
                <th class="text-center" style="width: 5%;font-weight:bold;">ลำดับ</th>
                <th class="text-center" style="width: 15%;font-weight:bold;">รหัสผู้สมัคร</th>
                <th class="text-center" style="width: 40%;font-weight:bold;">ชื่อ-นามสกุล</th>
                <th class="text-center" style="width: 10%;font-weight:bold;">คะแนนเต็ม</th>
                <th class="text-center" style="width: 10%;font-weight:bold;">คะแนนสอบ</th>
                <th class="text-center" style="width: 10%;font-weight:bold;">คะแนนสอบ <br />(%)</th>
                <th class="text-center" style="width: 10%;font-weight:bold;">ผลการประเมิน</th>
            </tr>
        </thead>
        <?php
            $i = 0;
            foreach ($dataList["result"] as $key => $v) {
                $i++;
            ?>
        <tbody>
            <tr>
                <td class="text-left">
                    <?= (($dataList["pageNo"] - 1) * $dataList["perPage"]) + $i; ?>
                </td>
                <td class="text-left">
                    <?= $v["app_id"] ?>
                </td>
                <td class="text-left">
                    <?= $v["fullname"] ?>
                </td>
                <td class="text-center ">
                    <?= $v["full_score"] ?>
                </td>
                <td class="text-center">
                    <?= $v["total_score"] ?>
                </td>
                <td class="text-right">
                    <?= $v["exam_percent_score"] ?>
                </td>
                <td class="text-center">
                    <?= $v["exam_result"] ?>
                </td>
            </tr>
        </tbody>
        <?php

            } ?>
    </table>

</div>


<?php }

if (!empty($dataList)) {
    $this->load->view("pagination/show_pagination", array(
        "dataList" => $dataList,
    ));
}
?>