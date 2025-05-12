<style>
/* Customize the label (the container) */
.container {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 16px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Hide the browser's default checkbox */
.container input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}

/* Create a custom checkbox */
.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #eee;
}

/* On mouse-over, add a grey background color */
.container:hover input~.checkmark {
    background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container input:checked~.checkmark {
    background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the checkmark when checked */
.container input:checked~.checkmark:after {
    display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
    left: 9px;
    top: 5px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}

.autocomplete {
    /*the container must be positioned relative:*/
    position: relative;
    /* display: inline-block;*/
}

.autocomplete-items {
    /*position: absolute;*/
    border: 1px solid #d4d4d4;
    border-bottom: none;
    border-top: none;
    /* z-index: 99;*/
    /*position the autocomplete items to be the same width as the container:*/
    top: 100%;
    /*left: 0;
    right: 0;*/
}

.autocomplete-items div {
    padding: 10px;
    cursor: pointer;
    background-color: #fff;
    border-bottom: 1px solid #d4d4d4;
}

.autocomplete-items div:hover {
    /*when hovering an item:*/
    background-color: #e9e9e9;
}

.autocomplete-active {
    /*when navigating through the items using the arrow keys:*/
    background-color: DodgerBlue !important;
    color: #ffffff;
}
</style>
<?php $this->load->view("breadcrumb/breadcrumb", $breadcrumb); ?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="min-height:480px">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <span class="label_head">ข้อมูลผู้ใช้งานระบบ</span>
                            <hr />
                        </div>

                        <div class="col-md-12">
                            <form id="form" name="form">
                                <div class="row">
                                    <?php
                                    $action = "";
                                    $rs = "";
                                    //  $str_user_assessor = [];
                                    if (isset($_POST['action'])) {
                                        $action = $_POST['action'];
                                        if ($action == 'edit') {
                                            // $rs = $this->ExamAssignmentModel->get_foredit($_POST['exam_assign_id']);
                                            // print_r($rs);
                                        }
                                    } else {
                                        $action = "create";
                                        // $str_user_assessor = "";
                                        $rs = null;
                                    }
                                    ?>

                                    <input type="hidden" class="form-control" id="action" name="action" value="<?= $action; ?>" />
                                    <input type="hidden" class="form-control" id="id" name="id" value="<?= $rs['id'] ?>" />
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label"> ชื่อ-นามสกุล <span class="span-req-field">*</span></label>
                                    <div class="col-md-5" style="padding-bottom:5px">
                                        <input class="form-control" type="text" id="name" name="name" value="<?= $rs['name'] ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label"> ชื่อผู้ใช้งาน<span class="span-req-field">*</span></label>
                                    <div class="col-md-5" style="padding-bottom:5px">
                                        <input class="form-control" type="number" id="username" name="username" value="<?= $rs['username'] ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label"> รหัสผ่าน <span class="span-req-field">*</span></label>
                                    <div class="col-md-5" style="padding-bottom:5px">
                                        <input class="form-control" type="password" id="pwd" name="pwd" value="<?= $rs['password'] ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label"> ยืนยันรหัสผ่าน <span class="span-req-field">*</span></label>
                                    <div class="col-md-5" style="padding-bottom:5px">
                                        <input class="form-control" type="password" id="re_pwd" name="re_pwd" value="<?= $rs['password'] ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label"> สถานะการใช้งาน <span class="span-req-field">*</span></label>
                                    <div class="col-md-5" style="padding-bottom:5px">
                                        <label class="col-md-2 col-form-label">
                                            <input type="radio" id="flag" name="flag" value="1" Checked />
                                            ใช้งาน
                                        </label>
                                        <label class="col-md-6 col-form-label">
                                            <input type="radio" id="flag" name="flag" value="0" />
                                            ระงับสิทธิ์การใช้งาน
                                        </label>
                                    </div>
                                </div>
                                <!-- <div class="row">
                                    <label class="col-md-2 col-form-label"> องค์กรรับรอง <span class="span-req-field">*</span></label>
                                    <div class="col-md-5" style="padding-bottom:5px">
                                        <input type="hidden" id="txt_org_code" name="txt_org_code">
                                        <select class="form-control occ_level" data-dropup-auto="false" id="org" name="org" required="" data-live-search="true" single="single">
                                            <option value="0">--กรุณาเลือก--</option>
                                            <?php foreach ($org as $v) { ?>
                                            <option value="<?php echo $v->orgCode; ?>" <?php echo ($rs['orgCode'] ==  $v->orgCode) ? 'selected="selected"' : ''; ?>>
                                                <?php echo $v->orgCode; ?> <?php echo $v->orgName; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div> -->
                                <br />
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4><label for="">เมนูการใช้งาน</label> </h4>
                                        <div class="card" style="min-height:400px">
                                            <div style="padding-left:25px;padding-top:10px">
                                                <label class="container"><strong>ทั้งหมด</strong>
                                                    <input type="checkbox" name="ckAll" id="ckAll">
                                                    <span class="checkmark"> </span>
                                                </label>
                                            </div>
                                            <div class="row">
                                                <?php foreach ($all_menu as $v_menu) { ?>
                                                <div class="col-md-6" style="padding-left:35px">
                                                    <label class="container"><?php echo $v_menu->menu_name; ?>
                                                        <input class="menu" type="checkbox" id="menu_<?php echo $v_menu->menu_id ?>" name="menu" value="<?php echo $v_menu->menu_id ?>">
                                                        <span class="checkmark"> </span>
                                                    </label>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-6">
                                        <h4><label for="">สิทธิ์ในการเห็นรอบสอบ</label> </h4>
                                        <div class="card" style="min-height:400px">
                                            <div class="col-md-12" style="padding:20px">
                                                <div class="autocomplete">
                                                    <input class="form-control" id="exam_round" type="text"
                                                        name="exam_round" placeholder="ค้นหารอบสอบ">
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>

                                <br />
                                <div class="col-md-12">
                                    <div class="row" style="text-align:center">
                                        <div class="col-md-5"></div>
                                        <div style="padding:5px;">
                                            <button type="button" class="btn btn-primary" id="btn_save">
                                                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                                <strong>บันทึก</strong>
                                            </button>
                                        </div>
                                        <div style="padding:5px">
                                            <a href="#" class="btn btn-secondary">
                                                <i class="fa fa-arrow-circle-left" style="color:#fff"></i>
                                                <strong>กลับ</strong>
                                            </a>
                                        </div>
                                    </div>
                                    <br /><br />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- /.content -->

<script type="text/javascript" src="<?= base_url(); ?>assets/custom_js/setting/user_role_form.js?<?= date("YmdHis") ?>">
</script>