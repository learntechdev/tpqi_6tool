<?php

defined('BASEPATH') or exit('No direct script access allowed');

class UploadFiles extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();

        $this->load->model("upload/UploadFilesModel");

    }

    public function uploadfile()
    {

        //print_r($_FILES);

        $app_id = $_POST["app_id"];

        $tool_type = $_POST["tool_type"];

        $template_detail_id = $_POST["template_detail_id"];
        $exam_schedule_id = $_POST["exam_schedule_id"];

        $path = "interview_upload/" . date("Y-m-d") . "/" . $app_id . "/";

        if (!@mkdir($path, 0777, true)) {

        } else {

            chmod($path, 0777);

        }

        if (isset($_FILES['audio_data']) && !empty($_FILES['audio_data'])) {

            $size = $_FILES['audio_data']['size'];

            $input = $_FILES['audio_data']['tmp_name'];

            $output = $_FILES['audio_data']['name'] . ".wav";

            $result = $this->UploadFilesModel->delForUpdate($app_id, $tool_type, $template_detail_id);

            $filesInfo = array(

                "filename" => $path . $output,

                "app_id" => $app_id,

                "created_date" => date("Y-m-d H:i:s"),

                "tool_type" => $tool_type,

                "template_detail_id" => $template_detail_id,
                "exam_schedule_id" => $exam_schedule_id,
            );

            $result = $this->UploadFilesModel->uploadfile($filesInfo);

            if ($result = 1) {

                move_uploaded_file($input, $path . $output);

                //echo 1;

                echo $path . $output;

            }

        } else {

            echo 0;

        }

    }

    // ฟังก์ชันสำหรับอัพโหลดไฟล์ โดยใช้ ckeditor

    public function upload_img_ritchtext()
    {

        $path = 'ckeditor/upload/files';

        if (!@mkdir($path, 0777, true)) {

        } else {

            chmod($path, 0777);

        }

        if (($_FILES['upload'] == "none") || (empty($_FILES['upload']['name']))) {

            $message = "ไม่มีไฟล์สำหรับอัพโหลด";

        } else if ($_FILES['upload']["size"] == 0) {

            $message = "ไฟล์มีขนาด 0 Kb";

        } else if (($_FILES['upload']["type"] != "image/pjpeg") && ($_FILES['upload']["type"] != "image/jpeg")

            && ($_FILES['upload']["type"] != "image/png") && ($_FILES['upload']["type"] != "image/gif")) {

            $message = "ระบบรองรับนามสกุลรูปภาพ .jpg, .png เท่านั้น!!!";

        } else if (!is_uploaded_file($_FILES['upload']["tmp_name"])) {

            $message = "เซิร์ฟเวอร์มีปัญหาไม่สามารถอัพโหลดได้!!!";

        } else {

            $message = "";

            move_uploaded_file($input, $path . $output);

            $move = move_uploaded_file($_FILES['upload']['tmp_name'], $path . "/" . time() . "_" . $_FILES['upload']['name']);

            if (!$move) {

                $message = "ไม่สามารถอ่านเขียนไฟล์ไปยังโฟลเดอร์ที่ระบุได้";

            }

        }

        if ($message != "") {

            $path = "";

        }

        $img_url = base_url() . $path . "/" . time() . "_" . $_FILES['upload']['name'];

        $funcNum = $_GET['CKEditorFuncNum'];

        echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$img_url', '$message');</script>";

    }

}
