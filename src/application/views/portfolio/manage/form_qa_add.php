<div class="row" id="port_type" style="padding-left:20px;padding-right:20px;">
    <div class="col-md-12 ">
        <div class="row">
            <div class="col-sm-12 py-2" style=" background-color: #eeeeee ">
                <div class="col-auto">
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="label_head"> 1 &nbsp;</span>
                        </div>
                        <!--    <select class="form-control" data-dropup-auto="false" id="portfolio_type_"
                            name="list[0][portfolio_type]" required="" data-live-search="true">
                            <option value="0">-- เลือกประเภทแฟ้มสะสมผลงาน --</option>
                            <?php foreach ($portfolio_type as $v) {?>
                            <option value="<?php echo $v->id ?>">
                                <?php echo $v->name; ?>
                            </option>
                            <?php }?>
                        </select>-->
                        <input type="text" class="form-control" style=" background-color: #fff " id="portfolio_type_"
                            name="list[0][portfolio_type]" placeholder="" />
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="col-sm-12 " id="port_detail">
        <div class="col-sm-12 ">
            <div class="row">
                <div class="col-sm-9 py-2">
                    <div class="col-auto">
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="label"> 1.1 &nbsp;</span>
                            </div>
                            <input type="text" class="form-control" style=" background-color: #fff "
                                name="list[0][detail][0][file]" placeholder="" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 py-2">
                    <input type="radio" id="status" name="list[0][detail][0][status]" value="1" Checked />
                    จำเป็น
                    <br />
                    <input type="radio" id="status" name="list[0][detail][0][status]" value="0" /> ไม่จำเป็น
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
                                name="list[0][detail][0][info]" value="" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 py-2">

                </div>
            </div>
        </div>
    </div>
</div>

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
</div>