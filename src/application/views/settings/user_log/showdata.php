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
                <th class="text-center" style="width: 10%;font-weight:bold;">วันที่เข้าใช้งาน</th>
                <th class="text-center" style="width: 15%;font-weight:bold;">ชื่อผู้ใช้งาน</th>
                <th class="text-center" style="width: 15%;font-weight:bold;">การกระทำ</th>
                <th class="text-center" style="width: 10%;font-weight:bold;">เครื่องมือ</th>
            </tr>
        </thead>
        <?php
$i = 0;
    $asm_tool = $this->MasterDataModel->tool_type_array();
    $log_action = $this->MasterDataModel->get_log_action();

    foreach ($dataList["result"] as $key => $v) {
        $i++;
        ?>
        <tbody>
            <tr>
                <td class="text-center">
                    <?=(($dataList["pageNo"] - 1) * $dataList["perPage"]) + $i;?>
                </td>
                <td class="text-wrap tbl-td-content">
                    <?=$this->BaseModel->dateToThai($v['date_action'], true)?> น.
                </td>
                <td class="text-center">
                    <?=$v['name']?>
                </td>
                <td class="text-left">

                    <?php
foreach ($log_action as $vv) {
            if ($vv['action'] == $v['action']) {
                echo $vv['name'];
                if ($v['template_id'] != '') {
                    echo ' (รหัสข้อสอบ ' . $v['template_id'] . ')';
                }

            }
        }
        ?>


                </td>
                <td class="text-left">

                <?php
foreach ($asm_tool as $vv) {
            if ($vv['name_eng'] == $v['menu_name']) {
                echo $vv['name'];
            }
        }
        ?>

                </td>
            </tr>
        </tbody>
        <?php

    }?>
    </table>

</div>
<?php }

if (!empty($dataList)) {
    $this->load->view("pagination/show_pagination", array(
        "dataList" => $dataList,
    ));
}
?>