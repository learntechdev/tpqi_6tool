<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Importdata extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("shared/SharedModel");
        $this->load->model("v2/settings/ImportdataModel");
        $this->load->model("v2/settings/ImportQualificationModel");
        $this->load->model("v2/settings/ImportItemQualificationModel");
    }
    public function index()
    {
        $this->SharedModel->layouts("settings/importdata/index", "");
    }

    public function process()
    {
        if (isset($_POST['import_type']) && isset($_POST['api_url']) && isset($_POST['tpqi_exam_no'])) {
            $rs = $this->ImportdataModel->checkdata($_POST['api_url'], $_POST['tpqi_exam_no']);
            echo json_encode($rs);
        } else {
            echo json_encode(
                [
                    "error" => 1,
                    "message" => "กรุณาระบุข้อมูลให้ครบถ้วน"
                ]
            );
        }
    }

    public function process_all_qualification()
    {
        if (isset($_POST['api_url']) && isset($_POST['start_page']) && isset($_POST['end_page'])) {
            $rs = $this->ImportQualificationModel->checkdata($_POST['api_url'], $_POST['start_page'], $_POST['end_page']);
            echo json_encode($rs);
        } else {
            echo json_encode(
                [
                    "error" => 1,
                    "message" => "กรุณาระบุข้อมูลให้ครบถ้วน"
                ]
            );
        }
    }

    public function process_item_qualification()
    {
        if (isset($_POST['api_url']) && isset($_POST['occ_level_id'])) {
            $rs = $this->ImportItemQualificationModel->checkdata($_POST['api_url'], $_POST['occ_level_id']);
            echo json_encode($rs);
        } else {
            echo json_encode(
                [
                    "error" => 1,
                    "message" => "กรุณาระบุข้อมูลให้ครบถ้วน"
                ]
            );
        }
    }
}