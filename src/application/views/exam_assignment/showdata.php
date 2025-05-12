<?php if (number_format($dataList["numRowsAll"]) == 0) { ?>
<div class="row">
    <div class="col-md-12" style="font-weight:bold;color:red;text-align:center">
        <br> == ไม่พบข้อมูล ==
    </div>
</div>
<?php } ?>
<?php if (is_array($dataList)) { ?>
<div class="table-responsive">
    <table id="myTable" class="table text-nowrap table-bordered">
        <thead class="bg-primary">
            <tr>
                <th class="text-center" style="width: 5%;font-weight:bold;">ลำดับ</th>
                <th class="text-center" style="width: 15%;font-weight:bold;" onclick="sortTable(0)">เลขที่สัญญา</th>
                <th class="text-center" style="width: 15%;font-weight:bold;" onclick="sortTable(1)">วันที่เริ่ม-สิ้นสุด สัญญา</th>
                <th class="text-center" style="width: 50%;font-weight:bold;" onclick="sortTable(2)">คุณวุฒิวิชาชีพ</th>
				<th class="text-center" style="width: 15%;font-weight:bold;" onclick="sortTable(3)">ผู้ออกข้อสอบ</th>
				<th class="text-center" style="width: 15%;font-weight:bold;" onclick="sortTable(4)">ผู้ตรวจข้อสอบ</th>
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
                    <?= $v['contract_no'] ?>
                </td>
                <td>
                    <?= $this->BaseModel->dateToThai($v['start_date'], false) ?> ถึง
                    <?= $this->BaseModel->dateToThai($v['end_date'], false) ?>
                </td>
                <td class="text-wrap">
					<?php if( $this->SharedModel->get_occlevelname($v['occ_level_id']) != null )  echo $this->SharedModel->get_occlevelname($v['occ_level_id'])['levelName'] ?></span>
                </td>
				<td class="text-wrap">
					<?php if( $this->SharedModel->get_username($v['user_exam_assign']) != null )  echo $this->SharedModel->get_username($v['user_exam_assign']) ?></span>
                </td>
				<td class="text-wrap">
					<?php if( $this->SharedModel->get_username($v['user_assessor']) != null )  echo $this->SharedModel->get_username($v['user_assessor']) ?></span>
                </td>
                <td style="text-center">
                    <div class="btn-group  btn-group-sm" role="group">
                        <button type="button" title="แก้ไข" alt="แก้ไข" class="btn btn-info"
                            onClick="edit(<?= $v['exam_assign_id'] ?>)">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </button>
                        <button type="button" title="ลบ" alt="ลบ" class="btn btn-danger"
                            onClick="cancel(<?= $v['exam_assign_id'] ?>)">
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
    <script>
        function sortTable(columnIndex) {
            const table = document.getElementById("myTable");
            let rows, switching, i, x, y, shouldSwitch;
            switching = true;

            // Loop until no switching is needed
            while (switching) {
                switching = false;
                rows = table.rows;

                // Skip the header row (hence start from index 1)
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;

                    // Compare two rows based on the specified column
                    x = rows[i].getElementsByTagName("TD")[columnIndex];
                    y = rows[i + 1].getElementsByTagName("TD")[columnIndex];

                    // Check if the rows should switch place
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
            }
        }
    </script>