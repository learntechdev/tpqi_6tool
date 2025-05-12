<?php
ini_set('post_max_size', '512M');
ini_set('upload_max_filesize', '512M');

require_once __DIR__ . '../../../vendor/autoload.php';

defined('BASEPATH') or exit('No direct script access allowed');



class Simulation extends CI_Controller

{



    public function __construct()

    {

        parent::__construct();



        $this->load->model("masterdata/MasterDataModel");

        $this->load->model("demonstration/DemonstrationToolsModel");

        $this->load->model("interview/InterviewModel");

        $this->load->model("shared/SharedModel");

        $this->load->model("demonstration/DemonstrationModel");
    }



    public function saveFileAssessment()

    {

        //เช็คโฟลเดอร์ที่เก็บไฟล์ ถ้าไม่มีให้สร้างใหม่

        if (!@mkdir('demonstration_assessment_flie/' . $_POST['app_id'], 0, true)) {



            echo "มีโฟเดอร์อยู่แล้ว";
        } else {

            echo "สร้างโฟเดอร์ใหม่แล้ว";
        }



        $path = "demonstration_assessment_flie/" . $_POST['app_id'] . "/";

        chmod($path, 0777);



        //บันทึกไฟล์

        if (isset($_POST['name_flie'])) {

            echo $_POST['name_flie'];
        }

        if (isset($_FILES['upload_file'])) {

            if (move_uploaded_file($_FILES['upload_file']['tmp_name'], $path . $_POST['name_flie'])) {

                echo $_POST['name_flie'] . " OK";
            } else {

                echo $_POST['name_flie'] . " KO";
            }

            exit;
        } else {

            echo "No files uploaded ...";
        }
    }



    public function saveDetailFile()

    {

        //บันทึกข้อมูลไฟล์ของการประเมินครั้งนั้นๆ

        $rs = $this->DemonstrationModel->save_assessment_detail_file($_POST['data'], $_POST['assessment_detail_id']);

        echo json_encode($rs);
    }
}