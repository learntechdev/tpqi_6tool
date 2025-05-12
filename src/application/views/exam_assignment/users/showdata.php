<?php if (number_format($dataList["numRowsAll"]) == 0) { ?>
<div class="row">
    <div class="col-md-12" style="font-weight:bold;color:red;text-align:center">
        <br> == ไม่พบข้อมูล ==
    </div>
</div>
<?php } ?>
<?php if (is_array($dataList)) { ?>

<?php
    $i = 0;
    foreach ($dataList["result"] as $key => $v) {
        $strContractNo = $v['contract_no'];
		$strLevelId = $v['occ_level_id'];
        $i++;
    ?>
<div class="col-md-12 ">
    <div class="row">
        <div class="box-body p-0">
            <div class=" media-list media-list-hover media-list-divided">
                <div class="media media-single ">
                    <div class="col-md-1">
                        <span class="avatar avatar-md bg-primary"><i class="fa fa-file-text-o" aria-hidden="true"></i>

                        </span>
                    </div>
                    <div class="col-md-7">
                        <span class="title"><strong><?= $v['contract_no'] ?></strong>
                        </span><br />
                        <span class="title"><?= $v['project_name'] ?></span><br>
                        <span class="title">
                            <?php if( $this->SharedModel->get_occlevelname($v['occ_level_id']) != null )  $examAssLevelName = $this->SharedModel->get_occlevelname($v['occ_level_id'])['levelName']; echo $examAssLevelName; $_SESSION['examAssLevelName'] = $examAssLevelName; $_SESSION['examAssLevelId'] = $v['occ_level_id'] ?></span>
                    </div>
                    <div class="col-md-4">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                        <span>เริ่มต้น <?= $this->BaseModel->dateToThai($v['start_date'], false) ?> ถึง
                            <?= $this->BaseModel->dateToThai($v['end_date'], false) ?></span>
                    </div>
                </div>
				<?php 
					if($v['created_by'] == $_SESSION["user_id"] || $v['created_by'] == 1){ ?>
                <div class="row">
                    <div class="box-body" style="padding-left:0px">
                        <ul class="flexbox flex-justified text-center my-20">
                            <?php
                                    if (is_array($menu_asmtool)) {
                                        foreach ($menu_asmtool as $v) {
                                            if ($v->tool_type != "") {
                                    ?>
                            <li class="br-1">
                                <div class="font-size-17"> <?= $v->menu_name ?></div>
                                <h2 class="text-warning">
                                    <?= $this->MasterDataModel->count_exam($v->tool_type, $strContractNo)['num_exam'] ?>
                                    ชุด</h2>
                                <div>
                                    <div class="btn-group  btn-group-sm" role="group">
                                        <a href="<?= $v->url . "&contract_no=" . $strContractNo . "&level_id=" . $strLevelId ?>" title="ดูข้อสอบ"
                                            alt="ดูข้อสอบ" class="btn btn-primary" id="btn_detail" name="btn_detail"
                                            onClick="">
                                            <i class="fa fa-eye" aria-hidden="true" style="color:white"></i>
                                        </a>
										
                                        <button type="button" title="สร้างข้อสอบ" alt="สร้างข้อสอบ" class="btn btn-info"
                                            onClick="gotocreate('<?= $v->tool_type ?>','<?= $strContractNo ?>','<?= $strLevelId ?>')">
                                            <i class="fa fa-plus-circle" aria-hidden="true" style="color:white"></i>
                                        </button>
											
                                    </div>
                                </div>
                            </li>
                            <?php  }
                                            ?>

                            <?php         }
                                    } ?>
                        </ul>
                    </div>
                </div>
				<?php } else {?>
				<div class="row">
                    <div class="box-body" style="padding-left:0px">
                        <ul class="flexbox flex-justified text-center my-20">
                            <?php
                                    if (is_array($menu_asmtool)) {
                                        foreach ($menu_asmtool as $v) {
                                            if ($v->tool_type != "") {
                                    ?>
                            <li class="br-1">
                                <div class="font-size-17"> <?= $v->menu_name ?></div>
                                <h2 class="text-warning">
                                    <?= $this->MasterDataModel->count_exam($v->tool_type, $strContractNo)['num_exam'] ?>
                                    ชุด</h2>
                                <div>
                                    <div class="btn-group  btn-group-sm" role="group">
                                        <a href="<?= $v->url . "&contract_no=" . $strContractNo ?>" title="ดูข้อสอบ"
                                            alt="ดูข้อสอบ" class="btn btn-primary" id="btn_detail" name="btn_detail"
                                            onClick="">
                                            <i class="fa fa-eye" aria-hidden="true" style="color:white"></i>
                                        </a>		
                                    </div>
                                </div>
                            </li>
                            <?php  }
                                            ?>

                            <?php         }
                                    } ?>
                        </ul>
                    </div>
                </div>
				<?php } ?>
                <hr>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php }

if (!empty($dataList)) {
    $this->load->view("pagination/show_pagination", array(
        "dataList" => $dataList,
    ));
}
?>