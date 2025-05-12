<style>
.wrapword {
    white-space: -moz-pre-wrap !important;
    /* Mozilla, since 1999 */
    white-space: -pre-wrap;
    /* Opera 4-6 */
    white-space: -o-pre-wrap;
    /* Opera 7 */
    white-space: pre-wrap;
    /* css-3 */
    word-wrap: break-word;
    /* Internet Explorer 5.5+ */
    white-space: -webkit-pre-wrap;
    /* Newer versions of Chrome/Safari*/
    word-break: break-all;
    white-space: normal;
}
</style>

<?php if (number_format($dataList["numRowsAll"]) == 0) { ?>
<div class="row">
    <div class="col-md-12" style="font-weight:bold;color:red;text-align:center">
        <br> == ไม่พบข้อมูล ==
    </div>
</div>
<?php } ?>
<?php if (is_array($dataList)) { ?>
<div class="table-responsive">
    <table class="table text-wrap table-bordered" style="font-size:14px">
        <thead class="bg-primary">
            <tr>
                <th class="text-center" style="width: 5%;font-weight:bold;">ลำดับ</th>
                <th class="text-center" style="width: 35%;font-weight:bold;">คุณวุฒิวิชาชีพ</th>
                <th class="text-center" style="width: 10%;font-weight:bold;">แฟ้มสะสมผลงาน (ชุด)</th>
                <th class="text-center" style="width: 10%;font-weight:bold;">สัมภาษณ์ (ชุด)</th>
                <th class="text-center" style="width: 10%;font-weight:bold;">จำลองสถานการณ์ (ชุด)</th>
                <th class="text-center" style="width: 10%;font-weight:bold;">สาธิตการปฏิบัติงาน (ชุด)</th>
                <th class="text-center" style="width: 10%;font-weight:bold;">สังเกตการณ์ ณ หน้างานจริง (ชุด)</th>
                <th class="text-center" style="width: 10%;font-weight:bold;">ประเมินด้วยบุคคลที่สาม (ชุด)</th>

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
                <td class="text-wrap">
                    <?= $v['occ'] ?>
                </td>
                <td class="text-wrap text-center">
                    <?= $v['tool2'] ?>
                </td>
                <td class="text-wrap text-center">
                    <?= $v['tool3'] ?>
                </td>
                <td class="text-wrap text-center">
                    <?= $v['tool4'] ?>
                </td>
                <td class="text-wrap text-center">
                    <?= $v['tool5'] ?>
                </td>
                <td class="text-wrap text-center">
                    <?= $v['tool6'] ?>
                </td>
                <td class="text-wrap text-center">
                    <?= $v['tool7'] ?>
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