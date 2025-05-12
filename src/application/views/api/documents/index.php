<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">การเชื่อมโยง API </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">หน้าแรก</a></li>
                        <li class="breadcrumb-item active">การเชื่อมโยง API</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- /.card -->
                    <div class="card" id="login">
                        <div class="card-header">
                            <h3 class="card-title"><b>1.Authentication</b> </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-bordered">
                                <thead style="background-color:#cccccc">
                                    <tr>
                                        <th style="width: 30%">Service</th>
                                        <th style="width: 70%">URL </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Login</td>
                                        <td>
                                            <span class="right badge badge-primary">POST</span>
                                            https://tpqi.codehansa.com/api/Authentication/login
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <table class="table table-bordered">
                                <thead style="background-color:#cccccc">
                                    <tr>
                                        <th style="">Key/Parameter</th>
                                        <th style="">Required</th>
                                        <th style="">Type</th>
                                        <th style="">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>username</td>
                                        <td>true</td>
                                        <td>string</td>
                                        <td>ชื่อผู้ใช้งาน</td>
                                    </tr>
                                    <tr>
                                        <td>password</td>
                                        <td>true</td>
                                        <td>string</td>
                                        <td>รหัสผ่าน</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div style="padding-left:20px;padding-top:20px;padding-bottom:20px;">
                                <b>วิธีการ</b><br>
                                ผู้ใช้ ทําการ Authentication โดยใช้ username และ password ที่ออกให้เพื่อขอ Token <br>
                                Token นี้จะมีกําหนดเวลาหมดอายุ 30 นาที
                            </div>
                            <img src="<?=base_url()?>assets/api/img/authen.jpg"
                                style="width:100%; border: 5px solid #555;">
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

                <div class="col-md-12">
                    <!-- /.card -->
                    <div class="card" id="Examresult">
                        <div class="card-header">
                            <h3 class="card-title"><b>2.Exam result all</b> </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-bordered">
                                <thead style="background-color:#cccccc">
                                    <tr>
                                        <th style="width: 30%">Service</th>
                                        <th style="width: 70%">URL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>ผลการประเมิน</td>
                                        <td>
                                            <span class="right badge badge-primary">POST</span>
                                            https://tpqi.codehansa.com/api/Examresult/all_examresult
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>


                            <div style="padding-left:20px;padding-top:20px;padding-bottom:20px;">
                                <b>วิธีการ</b><br>
                                ผู้ใช้ ทําการ ใส่ Token ที่ได้จากการ Login และ กรอกข้อมูลตามที่ระบุข้างต้น
                            </div>
                            <img src="<?=base_url()?>assets/api/img/send token.jpg"
                                style="width:100%; border: 5px solid #555;">
                            <img src="<?=base_url()?>assets/api/img/all_examresult.jpg"
                                style="width:100%; border: 5px solid #555;">

                        </div>

                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>


                <div class="col-md-12">
                    <!-- /.card -->
                    <div class="card" id="ExamresultRound">
                        <div class="card-header">
                            <h3 class="card-title"><b>3.Exam result round</b> </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-bordered">
                                <thead style="background-color:#cccccc">
                                    <tr>
                                        <th style="width: 30%">Service</th>
                                        <th style="width: 70%">URL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>ผลการประเมิน</td>
                                        <td>
                                            <span class="right badge badge-primary">GET</span>
                                            https://tpqi.codehansa.com/api/Examresult/round_examresult
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <table class="table table-bordered">
                                <thead style="background-color:#cccccc">
                                    <tr>
                                        <th style="">Key/Parameter</th>
                                        <th style="">Required</th>
                                        <th style="">Type</th>
                                        <th style="">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>tpqi_exam_no</td>
                                        <td>true</td>
                                        <td>string</td>
                                        <td>รหัสชุดข้อสอบ</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div style="padding-left:20px;padding-top:20px;padding-bottom:20px;">
                                <b>วิธีการ</b><br>
                                ผู้ใช้ ทําการ ใส่ Token ที่ได้จากการ Login และ กรอกข้อมูลตามที่ระบุข้างต้น
                            </div>


                            <img src="<?=base_url()?>assets/api/img/send token.jpg"
                                style="width:100%; border: 5px solid #555;">
                            <img src="<?=base_url()?>assets/api/img/round_exam.jpg"
                                style="width:100%; border: 5px solid #555;">

                        </div>

                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>



                <div class="col-md-12">
                    <!-- /.card -->
                    <div class="card" id="Useexamresult">
                        <div class="card-header">
                            <h3 class="card-title"><b>4.Use exam result</b> </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-bordered">
                                <thead style="background-color:#cccccc">
                                    <tr>
                                        <th style="width: 30%">Service</th>
                                        <th style="width: 70%">URL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>ปรับสถานะ การดึงข้อมูลไปประเมินผลกับเครื่องมืออื่นๆ</td>
                                        <td>
                                            <span class="right badge badge-primary">POST</span>
                                            https://tpqi.codehansa.com/api/Examresult/confirm_get_examresult
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>


                            <div style="padding-left:20px;padding-top:20px;padding-bottom:20px;">
                                <b>วิธีการ</b><br>
                                ผู้ใช้ ทําการ ใส่ Token ที่ได้จากการ Login และ กรอกข้อมูลตามที่ระบุข้างต้น
                            </div>

                            <table class="table table-bordered">
                                <thead style="background-color:#cccccc">
                                    <tr>
                                        <th style="">Key/Parameter</th>
                                        <th style="">Required</th>
                                        <th style="">Type</th>
                                        <th style="">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>tpqi_exam_no</td>
                                        <td>true</td>
                                        <td>string</td>
                                        <td>รหัสชุดข้อสอบ</td>
                                    </tr>
                                </tbody>
                            </table>
                            <img src="<?=base_url()?>assets/api/img/send token.jpg"
                                style="width:100%; border: 5px solid #555;">



                            <img src="<?=base_url()?>assets/api/img/comfirm_get_examresult.jpg"
                                style="width:100%; border: 5px solid #555;">

                        </div>

                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>




            </div>
    </section>
</div>