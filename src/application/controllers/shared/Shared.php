<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Shared extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("masterdata/MasterDataModel");
        $this->load->model("shared/SharedModel");
    }

    public function get_uoc()
    {
        $data["uoc"] = $this->MasterDataModel->fetch_uoc($_POST["occ_level_id"]);
        $data["template"] = $_POST["template_id"];
        $data["asm_tool"] = $_POST["asm_tool"];
        //print_r($data);
        $this->load->view("std_list/uoc", $data);
    }

    public function get_eoc()
    {
        $data = [];
        $data["uoc"] = $this->MasterDataModel->fetch_uoc($_POST["occ_level_id"]);
        $data["template"] = $_POST["template_id"];
        $data["asm_tool"] = $_POST["asm_tool"];
        $this->load->view("std_list/eoc", $data);
    }

    // อัพโหลดไฟล์เพิ่มเติมสำหรับใช้สอบ
    public function upload_docs_forexam()
    {
		echo "Request method : " . $_SERVER['REQUEST_METHOD'] . "\n";
        $countfiles = count($_FILES['files']['name']);
        // echo $countfiles;

        $folderUpload = "docs_forexam/" . $_POST["template_id"] . "/";;

        if (!is_dir($folderUpload)) {
            mkdir($folderUpload, 0777, true);
        }

        ini_set('post_max_size', '512G');
        ini_set('upload_max_filesize', '512G');

        // $files_arr = array();

        for ($index = 0; $index < $countfiles; $index++) {
            if (isset($_FILES['files']['name'][$index]) && $_FILES['files']['name'][$index] != '') {
                $filename = $_FILES['files']['name'][$index];
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                $valid_ext = array("pdf", "doc", "docx", "mp4", "zip");
                if (in_array($ext, $valid_ext)) {
                    $path = $folderUpload . $filename;
                    if (move_uploaded_file($_FILES['files']['tmp_name'][$index], $path)) {
                        // $files_arr[] = $path;
                        $insert_file = $this->SharedModel->insert_docs_forexam($_POST["template_id"], $filename);
                    }
                }
            }
        }

        // echo $files_arr;
        if ($insert_file == '1') {
            echo  $_POST["template_id"];
        } else {
            echo 0;
        }
    }

    public function getDocsforExam()
    {
        $data["dataList"] = $this->SharedModel->getDocsFiles($_POST["template_id"]);
        $this->load->view("shared/list_docs", $data);
    }
}