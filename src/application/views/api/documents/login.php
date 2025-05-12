<div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <div class="sticky-top mb-3" style="margin-top:200px">
                <div class="card">

                    <div class="card-body">
                    <!-- the events -->
                    <div id="external-events">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Username</label>
                            <input type="text" class="form-control" id="username" placeholder="" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="" autocomplete="off">
                        </div>
                        <button type="button" class="btn btn-primary  btn-block" id="btnLogin" onclick="Login()">Login</button>
                    </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                </div>
            </div>

            </div>
        </div>

<script>

function Login(){
        username = $('#username').val();
        password = $('#password').val();

        $.ajax({
            type: "POST",
            url: "../Authentication/login_document",
            data: {
                username: username,
                password: password,
            },
            dataType: "text",
            success: function (data) {
                if(data){
                    window.location.assign("<?=base_url();?>api/Documents/index")
                }else{
                    alert('ชื่อผู้ใช้งาน หรือ รหัสผ่านไม่ถูกต้อง');
                }
            }
        });
    }
</script>