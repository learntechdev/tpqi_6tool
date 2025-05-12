<?php
$tmp_tp_id = "";
$rs_detail = "";
if (isset($_GET['template_id'])) {
    $tmp_tp_id = $_GET['template_id'];
    $rs_detail = $this->PortfolioToolsModel->get_template_detail($tmp_tp_id);
} else {
    $tmp_tp_id = '';
}
/*
//echo print_r(json_encode($rs_detail[1]));
echo "<br>";
echo "<br>";
echo "<br>";
echo print_r(($rs_detail));
echo "<br>";*/
$i = 0;
?>
<?php foreach ($rs_detail as $v) {
    $detail = json_decode($v->detail);
    // echo print_r($v->des_for_applicant);
    // echo "<br>";
    ?>


<div class="row" id="port_type" style="padding-left:20px;padding-right:20px;">
    <div class="col-md-12 ">
        <div class="row">
            <div class="col-sm-12 py-2" style=" background-color: #eeeeee ">
                <div class="col-auto">
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="label_head"> <?=$i + 1?> &nbsp;</span>
                        </div>
                        <select class="form-control" data-dropup-auto="false" id="portfolio_type_"
                            name="list[<?=$i?>][portfolio_type]" required="" data-live-search="true">
                            <option value="0">-- เลือกประเภทแฟ้มสะสมผลงาน --</option>
                            <?php foreach ($portfolio_type as $p) {?>
                            <option value="<?php echo $p->id ?>" <?=$p->id == $v->portfolio_type ? 'selected' : ''?>>
                                <?php echo $p->name; ?>
                            </option>
                            <?php }?>
                        </select>

                        <input type="hidden" class="form-control" style=" background-color: #fff "
                            name="list[<?=$i?>][template_detail_id]" value="<?=$v->template_detail_id?>" />

                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php $i1 = 0;foreach ($detail as $v1) {?>
    <div class="col-sm-12 " id="port_detail">
        <div class="col-sm-12 ">
            <div class="row">
                <div class="col-sm-9 py-2">
                    <div class="col-auto">
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="label"> <?=$i + 1?>.<?=$i1 + 1?> &nbsp;</span>
                            </div>

                            <input type="text" class="form-control" style=" background-color: #fff "
                                name="list[<?=$i?>][detail][<?=$i1?>][file]" value="<?=$v1->file?>" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 py-2">
                    <input type="radio" id="status" name="list[<?=$i?>][detail][<?=$i1?>][status]" value="1"
                        <?=$v1->status == '1' ? 'Checked' : ''?> />
                    จำเป็น
                    <br />
                    <input type="radio" id="status" name="list[<?=$i?>][detail][<?=$i1?>][status]" value="0"
                        <?=$v1->status == '0' ? 'Checked' : ''?> />
                    ไม่จำเป็น
                </div>
            </div>

            <div class="row">
                <div class="col-sm-11 " style=" padding-left: 65px;margin-top:-25px ">
                    คำแนะนำในการส่งเอกสาร
                </div>
                <div class="col-sm-9 py-2">
                    <div class="col-auto">
                        <div class="input-group mb-1" style=" padding-left: 45px ">
                            <input type="text" class="form-control" style=" background-color: #fff "
                                name="list[<?=$i?>][detail][<?=$i1?>][info]" value="<?=$v1->info?>" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 py-2">

                </div>
            </div>

            <?php $i1++;}?>
        </div>
    </div>
</div>
<?php $i++;}?>
</div>

<!--
<div class="row" style="padding-left:20px;padding-right:20px;">
    <div class="col-sm-12 py-1 text-right">
        <button type="button" class="btn btn-warning" style=" width: 150px "
            onclick="addDetailForm()">เพิ่มรายการ</button>
    </div>
</div>

<hr />

<div class="row" style="padding-left:20px;padding-right:20px;">
    <div class="col-sm-12 py-1 text-right">
        <button type="button" class="btn btn-success" style=" width: 150px "
            onclick="addPortfolioType()">เพิ่มหัวข้อ</button>
    </div>
</div>-->