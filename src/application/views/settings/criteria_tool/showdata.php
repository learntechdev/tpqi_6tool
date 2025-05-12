<?php if (number_format($dataList["numRowsAll"]) == 0) {?>
<div style="font-weight:bold;color:red;text-align:center">
    <br> == ไม่พบข้อมูล ==
</div>
<?php }?>
<?php if (is_array($dataList)) {?>
<div class="table-responsive">
    <table class="table text-nowrap table-bordered">
        <thead class="bg-primary">
            <tr>
                <th class="text-center" style="width: 5%;font-weight:bold;">ลำดับ</th>
                <th class="text-left" style="width: 20%;font-weight:bold;">เกณฑ์การประเมิน</th>
                <th class="text-left" style="width: 40%;font-weight:bold;">รายละเอียด</th>
               <!-- <th class="text-center" style="width: 10%;font-weight:bold;">วันที่สร้าง</th> -->
                <th class="text-center" style="width: 10%;ภfont-weight:bold;">วันที่สร้าง</th>
                <th class="text-center" style="width: 5%;font-weight:bold;">สถานะ</th>
                <th class="text-center" style="width: 5%;ภfont-weight:bold;">ตั้งค่า</th>

            </tr>
        </thead>
        <?php
$i = 0;

    foreach ($dataList["result"] as $key => $v) {
        $i++;

        $str_status = "";
        $color = "";
        if ($v['status'] == "1") {
            $str_status = "ใช้งาน";
            $color = "green";
        } else {
            $str_status = "ปิดใช้งาน";
            $color = "red";
        }

        ?>
        <tbody>
            <tr>
                <td class="text-left">
                    <?=(($dataList["pageNo"] - 1) * $dataList["perPage"]) + $i;?>
                </td>
                <td class="text-wrap tbl-td-content">
                <?=$v['title']?>
                </td>
                <td class="text-left text-wrap tbl-td-content" >
                <?=$v['description']?>
                </td>
                <!--<td class="text-left">



                </td> -->
                <td class="text-center">
                <?=$this->BaseModel->dateToThai($v['created_date'], true)?> น.
<br>
              (อัพเดทล่าสุด  <?=$this->BaseModel->dateToThai($v['last_update_date'], true)?> น.)
                </td>
                <td class="text-ecnter">
                <span style="color:<?=$color?>"><strong>

                        <?=$str_status;?>

                    </strong> </span>
                </td>
                <td class="text-center">
                <button type="button" title="แก้ไข" alt="แก้ไข" class="btn btn-warning"
                        onclick="btn_edit('<?=$v['criteria_type_id']?>')">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </button>

                </td>
            </tr>
        </tbody>
        <?php

    }?>
    </table>

</div>

<?php include 'form_modal.php';?>

<?php }

if (!empty($dataList)) {
    $this->load->view("pagination/show_pagination", array(
        "dataList" => $dataList,
    ));
}
?>