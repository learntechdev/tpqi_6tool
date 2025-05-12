<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../images/favicon.ico">
    <title>DIGITAL EXAM CENTER</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
        href="<?= base_url(); ?>assets/fonts_saraban/thsarabunnew.css?<?= date("YmdHis") ?>" />
    <link rel="stylesheet" type="text/css"
        href="<?= base_url(); ?>assets/tp_new/css/custom_style.css?<?= date("YmdHis") ?>" />
    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/tp_new/css/bootstrap.css?<?= date("YmdHis") ?>">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/select2/css/select2.css?<?= date("YmdHis") ?>">

    <!-- theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/tp_new/css/horizontal-menu.css?<?= date("YmdHis") ?>">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/tp_new/css/style.css?<?= date("YmdHis") ?>">
    <!-- Admin skins -->

    <link rel="stylesheet" href="<?= base_url(); ?>assets/tp_new/css/skin_color.css?<?= date("YmdHis") ?>">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/sweetalert2/sweetalert2.min.css?<?= date("YmdHis") ?>">
    <link rel="stylesheet"
        href="<?= base_url(); ?>assets/bootstrap-datepicker-thai/css/datepicker.css?<?= date("YmdHis") ?>">


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    

    <link rel="stylesheet" href="<?= base_url(); ?>assets/tp_new/css/style2.css">
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
    rel="stylesheet">
    <!-- ทดลองใช้งาน-->
    <!-- jQuery library   -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="<?= base_url(); ?>assets/tp_new/js/vendors.min.js"></script>

    <script src="<?= base_url(); ?>ckeditor/ckeditor.js"> </script>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/chart.js-2.9.4/dist/Chart.css?<?= date("YmdHis") ?>">
    <script src="<?= base_url(); ?>assets/chart.js-2.9.4/dist/Chart.bundle.js"></script>
    <script src="<?= base_url(); ?>assets/chart.js-2.9.4/dist/Chart.js"></script>
	
	
</head>

<body class="layout-top-nav light-skin theme-classic">
    <!-- Site wrapper -->
    <div class="wrapper">
        <header class="main-header custom-header">
            <div class="inside-header  index-ele">
                <div class="d-flex align-items-center logo-box justify-content-between">
                    <a href="#" class="" style="padding-top:9px">
                        <div class="" style="width:550px;margin-top:2px;">
                            <span class="light-logo"><img src="<?= base_url(); ?>assets/img/logo/new_logo2.png"
                                    alt="logo">
                            </span>
                        </div>
                    </a>
                </div>
                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <div></div>
                    <div style="padding-top:10px" class="pull-right">
                        <span>ยินดีต้อนรับ </span>
                        <span style="color:red;font-weight:bold"><?= $_SESSION['name'] ?></span>
                        &nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-rounded btn-primary" onClick="logout()"><i
                                class="fa fa-sign-out"></i>
                            ออกจากระบบ</button>
                    </div>
                </nav>
            </div>
        </header>

        <nav class="main-nav" role="navigation">
            <!-- Mobile menu toggle button (hamburger/x icon) -->
            <input id="main-menu-state" type="checkbox" />
            <label class="main-menu-btn" for="main-menu-state">
                <span class="main-menu-btn-icon"></span> Toggle main menu visibility
            </label>

            <!-- Sample menu definition -->

            <ul id="main-menu" class="sm sm-blue">
                <?php
				
                if ($_SESSION["user_type"] == "1") {
                    require_once dirname(__FILE__) . "/menu/menu_admin.php";
                } else if ($_SESSION["user_type"] == "2") {
                    require_once dirname(__FILE__) . "/menu/menu_notrole.php";
                    // require_once dirname(__FILE__) . "/menu/menu_r_exam.php";
                } else if ($_SESSION["user_type"] == "3") {
                    require_once dirname(__FILE__) . "/menu/menu_notrole.php";
                    // require_once dirname(__FILE__) . "/menu/menu_c_exam.php";
                } else if ($_SESSION["user_type"] == "4") {
                    require_once dirname(__FILE__) . "/menu/menu_notrole.php";
                    //require_once dirname(__FILE__) . "/menu/menu_ap_criteria.php";
                } else if ($_SESSION["user_type"] == "5") {
                    require_once dirname(__FILE__) . "/menu/menu_notrole.php";
                } else if ($_SESSION["user_type"] == "6") {
                    require_once dirname(__FILE__) . "/menu/menu_notrole.php";
                    //require_once dirname(__FILE__) . "/menu/menu_used_exam.php";
                } else if ($_SESSION["user_type"] == "7") {
                    require_once dirname(__FILE__) . "/menu/menu_notrole.php";
                    //require_once dirname(__FILE__) . "/menu/menu_ass_exam.php";
                }else if ($_SESSION["user_type"] == "9") {
                    require_once dirname(__FILE__) . "/menu/menu_notrole.php";
                }/*else if ($_SESSION["role_id"] = "57") {
                    require_once dirname(__FILE__) . "/menu/menu.php";
                }*/ else {
                    require_once dirname(__FILE__) . "/menu/menu_notrole.php";
                }
                ?>
            </ul>
        </nav>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container-full">