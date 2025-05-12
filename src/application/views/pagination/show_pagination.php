<div class="table-responsive">
    <div id="example_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
        <div class="dataTables_info" id="example_info" role="status" aria-live="polite">ทั้งหมด &nbsp;&nbsp;
            <span class="text-danger"
                style="font-size:bold"><?=number_format($dataList["numRowsAll"])?>&nbsp;&nbsp;</span>
            รายการ
        </div>
        <div class="dataTables_paginate paging_simple_numbers">
            <ul class="pagination">
                <?php
							$paging["perPage"] = $dataList["perPage"];
							$paging["pageNo"] = $dataList["pageNo"];
							$paging["startPage"] = $dataList["pageNo"] - 2;
							$paging["endPage"] = $dataList["pageNo"] + 2;
							$paging["pageUp"] = $dataList["pageNo"] + 3;
							$paging["maxPage"] = $dataList["maxPage"];
							
							if ($paging["startPage"] < 1) {
								$paging["startPage"] = 1;
							}
							if ($paging["endPage"] > $paging["maxPage"]) {
								$paging["endPage"] = $paging["maxPage"];
							}
							if ($paging["pageUp"] > $paging["maxPage"]) {
								$paging["pageUp"] = $paging["maxPage"];
							}
						?>
                <li class="paginate_button page-item previous first pageNo" pageNo="1" onclick="page('1')"><a
                        class="page-link">ก่อนหน้า</a></li>
                <?php
									for ($i = $paging["startPage"]; $i <= $paging["endPage"]; $i++) {
										if ($i == $paging["pageNo"]) {
											$pageClass = "active";
											} else {
											$pageClass = "";
										}
									?>

                <li class="paginate_button page-item pageNo <?=$pageClass?>" pageNo="<?=$i?>" onclick="page(<?=$i?>)"><a
                        class="page-link"><?=$i?></a></li>
                <?php
									}
								?>
                <li class="paginate_button page-item next last pageNo" pageNo="<?=$paging['maxPage']?>"
                    onclick="page(<?=$paging['maxPage']?>)"><a class="page-link">ถัดไป</a></li>
            </ul>
        </div>
    </div>
</div>

<!--<div class="row" style="margin-top:50px;margin-bottom:20px">
    <div class="col-md-6">ทั้งหมด<span class="row-amount"><?=number_format($dataList["numRowsAll"])?></span>รายการ
    </div>
    <div class="col-md-6">
        <div id="show_pagination">
            <ul class="ul-custom">
                <?php
							$paging["perPage"] = $dataList["perPage"];
							$paging["pageNo"] = $dataList["pageNo"];
							$paging["startPage"] = $dataList["pageNo"] - 2;
							$paging["endPage"] = $dataList["pageNo"] + 2;
							$paging["pageUp"] = $dataList["pageNo"] + 3;
							$paging["maxPage"] = $dataList["maxPage"];
							
							if ($paging["startPage"] < 1) {
								$paging["startPage"] = 1;
							}
							if ($paging["endPage"] > $paging["maxPage"]) {
								$paging["endPage"] = $paging["maxPage"];
							}
							if ($paging["pageUp"] > $paging["maxPage"]) {
								$paging["pageUp"] = $paging["maxPage"];
							}
						?>
                <li style="float:left" class="first pageNo" pageNo="1" onclick="page(1)"><a id="first">ล่าสุด</a></li>
                <?php
									for ($i = $paging["startPage"]; $i <= $paging["endPage"]; $i++) {
										if ($i == $paging["pageNo"]) {
											$pageClass = "p-active";
											} else {
											$pageClass = "";
										}
                                    ?>
                <li style="float:left" class=" pageNo <?=$pageClass?>" pageNo="<?=$i?>" onclick="page(<?=$i?>)">
                    <a><?=$i?></a>
                </li>
                <?php
									}
								?>
                <li style="float:left" class="last pageNo" pageNo="<?=$paging["maxPage"]?>"
                    onclick="page(<?=$paging["maxPage"]?>)"><a>เก่ากว่า</a>
            </ul>
        </div>
    </div>
</div>-->