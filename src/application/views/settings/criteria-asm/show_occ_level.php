<div class="row">
    <div class="col-md-12">
        <input type="text" class="form-control" placeholder="กรอกคำค้น..." />
    </div>
</div>

<?php if (number_format($dataList["numRowsAll"]) == 0) {?>
<div style="font-weight:bold;color:red;text-align:center">
    <br> == ไม่พบข้อมูล ==
</div>
<?php }?>
<?php if (is_array($dataList)) {?>
<div class="table-responsive">
    <table class="table text-nowrap">
        <thead>
            <tr>
                <th style="width: 50px"></th>
                <th style="width: 300px;">สาขาวิชาชีพ</th>
                <th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
            </tr>
        </thead>

        <?php
							$i = 0;
							foreach ($dataList["result"] as $key => $v) {
								$i++;
							?>
        <tbody>
            <tr>
                <td class="text-center">
                    <input type="checkbox" id="" name="" value="">
                </td>
                <td class="text-wrap tbl-td-content">
                    <?=$v['levelName']?>
                </td>
                <td class="text-center">
                    xx
                </td>
            </tr>
        </tbody>
        <?php }?>
    </table>
</div>
<?php }?>


<?php
if (!empty($dataList)) {
    $this->load->view("pagination/show_pagination", array(
        "dataList" => $dataList,
    ));
}
?>


<script type="text/javascript"
    src="<?= base_url(); ?>assets/custom_js/settings/criteria_asm/show_occ_level.js?<?= date("YmdHis") ?>">
</script>