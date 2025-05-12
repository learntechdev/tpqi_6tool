<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Importdata extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("shared/SharedModel");
        $this->load->model("settings/ImportdataModel");
    }
    public function index()
    {
        $this->SharedModel->layouts("importdata/index", "");
    }

    public function process()
    {
        $import_type = "2"; // 2 = exam_round
        $rs = $this->ImportdataModel->checkdata($_POST['api_url'], $_POST['page_no'], $import_type);
        // $data["result"] = $this->ExamscheduleModel->tpqi_examround();
        echo json_encode($rs);
    }
}