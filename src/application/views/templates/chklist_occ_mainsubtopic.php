<?php
$initial = "";
if ($template_id != "") {
    $detail = $this->PortfolioToolsModel->get_detail_maintopic($template_id);
    $initial = count($detail);
    ?>

<input type="hidden" id="last_idx" name="last_idx" value="<?=$initial?>">

<?php for ($i = 1; $i <= $initial; $i++) {
        if (!empty($detail)) {
            foreach ($detail as $v) {
                ?>
<div id="form_q<?=$i?>">
    <div id="f_topic<?=$i?>">
        <div class="row" id="port_type" style="padding-left:20px;padding-right:20px;">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-12 py-2" style=" background-color: #eeeeee ">
                        <div class="col-md-12">
                            <div class="input-group mb-1">
                                <div class="input-group-prepend">
                                    <span class="label_head num_q"><?=$i?>. &nbsp;</span>
                                </div>
                                &nbsp;&nbsp;
                                <input type="text" class="form-control" style=" background-color: #fff "
                                    id="topic_<?=$i?>" name="list[<?=$i?>][topic]" placeholder=""
                                    value="<?=$v->maintopic?>" />
                                &nbsp;&nbsp;
                                <div class="btn-group  btn-group-sm" role="group">
                                    <button type="button" class="btn btn-success" id="btn_add_q_form"
                                        name="btn_add_q_form" onClick="add_main_topic('<?=$i?>')">
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                    </button>
                                    <!--<button type="button" class="btn btn-danger" id="btn_del_q_form"
                                        name="btn_del_q_form" onClick="remove_main_topic('<?=$i?>')">
                                        <i class="fa fa-minus-circle" aria-hidden="true"></i>
                                    </button>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12" id="subtopic_div_<?=$i?>">

                <?php
$subtopic = $this->PortfolioToolsModel->get_detail_subtopic($v->id);
                $initial_sub = count($subtopic);

                $j = 1;
                for ($j = 1; $j <= $initial_sub; $j++) {
                    foreach ($subtopic as $v_subtopic) {
                        ?>
                <input type="hidden" id="last_sub_idx_<?=$i?>" name="last_sub_idx_<?=$i?>" value="<?=$initial_sub?>">
                <div class="col-md-12" id="subtopic_<?=$i?>_<?=$j?>">
                    <div id="f_subtopic<?=$i?><?=$j?>">
                        <div class="col-md-12 ">
                            <div class="row">
                                <div class="col-md-11 py-2">
                                    <div class="col-auto">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="num_subtopic<?=$i?> "> <?=$i?>.<?=$j?></span>
                                            </div>
                                            &nbsp;&nbsp;
                                            <input type="text" class="form-control" style=" background-color: #fff"
                                                id="sub_topic_<?=$i?>" name="list[<?=$i?>][detail][<?=$j?>][subtopic]"
                                                value="<?=$v_subtopic->subtopic?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1 py-2">
                                    <div class="btn-group  btn-group-sm" role="group">
                                        <button type="button" class="btn btn-info" id="btn_add_q_form"
                                            name="btn_add_q_form" onClick="add_sub_topic('<?=$i?>','<?=$j?>')">
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                        </button>
                                        <?php 
                                        if($j != 1){ ?>
                                        <button type="button" class="btn btn-danger" id="btn_del_q_form"
                                            name="btn_del_q_form" onClick="remove_subtopic('<?=$i?>','<?=$j?>')">
                                            <i class="fa fa-minus-circle" aria-hidden="true"></i>
                                        </button>
                                        <?php }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
$j++;
                    }
                }?>
            </div>

        </div>
    </div>
</div>
<?php
$i++;
            }?>

<?php }
    }?>

<!-- เพิ่มใหม่ -->
<?php
} else {
    $this->load->view("templates/chklist_occ_mainsubtopic_add",
        array(
            "initial" => '1',
            "initial_sub" => $initial_sub,
        ));
}?>
<script type="text/javascript"
    src="<?=base_url();?>assets/custom_js/templates/chklist_occ_mainsubtopic.js?<?=date("YmdHis")?>">
</script>