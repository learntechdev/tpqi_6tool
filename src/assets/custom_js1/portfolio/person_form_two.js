$(document).ready(function () {
    $('.file').change(function () {
        //console.log($(this).get(0).files[0])
        if ($(this).get(0).files[0] != undefined) {
            var file_name = $(this).get(0).files[0].name; //ชื่อไฟล์
            var size = $(this).get(0).files[0].size; // ขนาดไฟล์
            var max = 20000000; //ขนาดไฟล์กำหนดสูงสุด
            var ext = file_name.split(".").pop();//นามสกุลไฟล์
            if (size < max) {
                if (ext != 'pdf' && ext != 'jpg' && ext != 'png' && ext != 'ppt' && ext != 'pptx' && ext != 'xls' && ext != 'xlsx' && ext != 'doc' && ext != 'docx') {
                    sweet_alert("<strong>นามสกุลไฟล์ไม่ถูกต้อง</strong>");
                    $(this).val('')
                } else {
                    id_ = $(this).attr('id')
                    document.getElementsByName(id_)[0].textContent = '';
                }
            } else {
                sweet_alert("<strong>ขนาดไฟล์เกิน 20 mb</strong>");
                $(this).val('')
            }

        }
    });


    $("form").submit(function (e) {
        e.preventDefault();
        var chk_file = true;
        $('.file').each(function () {
            id_ = $(this).attr('id')
            if (document.getElementById(id_).files.length < 1) {
                document.getElementsByName(id_)[0].textContent = '*กรุณาเลือกไฟล์';
                // console.log(id_)
                // console.log(document.getElementById(id_).files.length)
                chk_file = false;
            } else {
                document.getElementsByName(id_)[0].textContent = '';
            }
        });

        if (chk_file) {
            Swal.fire({
                title: 'ยืนยัน!!!',
                text: 'คุณต้องการบันทึกข้อมูลใช่หรือไม่?',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ใช่',
                cancelButtonText: 'ยกเลิก',
            }).then((result) => {
                if (result.isConfirmed) {
                    submit_form();
                }
            });
        } else {
            sweet_alert("<strong>กรุณาเลือกไฟล์ให้ครบ</strong>");
        }


    });

    /* $("form").submit(function (e) {
         e.preventDefault();
         var data = $('form').serializeJSON();
         console.log(data)
 
 
     });*/


    function submit_form() {
        var data = $('form').serializeJSON();
        var file = []
        i = 0;
        $('.file').each(function () {
            id_ = $(this).attr('id')
            file[i] = document.getElementById(id_).files
            i++;
        });
        //   console.log(file);
        uploadFileAssessor(file, data)
    }

    function uploadFileAssessor(file_array, data_array) {
        for (i = 0; i < file_array.length; i++) {
            data = data_array.list[i];
            //  console.log(file_array[i][0].name)
            var myfile = file_array[i][0].name
            var ext = myfile.split(".").pop();

            var url = "../Portfolio/uploadFile";
            var xhr = new XMLHttpRequest();
            var fd = new FormData();

            xhr.open("POST", url, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Every thing ok, file uploaded
                    // console.log(xhr.responseText); // handle response.
                }
            };
            fd.append("upload_file", file_array[i][0]);
            fd.append("app_id", data.app_id);
            fd.append(
                "name_flie",
                data.app_id + "_" + data.blueprint_id + "_" + data.subtopic_id + "_" + data.order_line + "." + ext
            );//ชื่อไฟล์+นามสกุล
            fd.append("data", JSON.stringify(data));

            data_array.list[i].file = data.app_id + "_" + data.blueprint_id + "_" + data.subtopic_id + "_" + data.order_line + "." + ext;

            xhr.send(fd);
        }

        //    console.log(data_array)
        insertAssessmentData(data_array)
    }


    function insertAssessmentData(data_array) {
        $.ajax({
            method: "POST",
            url: "../Portfolio/insertPersonAssessmentFile",
            data: {
                data: JSON.stringify(data_array),
            },
            success: function (response) {
                if (response) {
                    success_alert("<strong>บันทึกข้อมูลเรียบร้อยแล้ว!!!</strong>");
                    $.redirect("../../assessment/PersonAssessment/index");
                } else {
                    sweet_alert("<strong>ไม่สามารถบันทึกข้อมูลได้!!!</strong>");
                }

            },
        });
    }

});