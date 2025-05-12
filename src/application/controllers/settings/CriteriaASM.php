<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CriteriaASM extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("settings/CriteriaASMModel");
        $this->load->model("shared/SharedModel");
    }

    private function criteria()
    {
        $filter = array();
        
        if (isset($_GET["pageNo"])) {
            if (trim($_GET["pageNo"]) != "") {
                $filter["pageNo"] = $_GET["pageNo"];
            }
        } else {
            $filter["pageNo"] = 1;
        }

        if (isset($_GET["perPage"])) {
            if (trim($_GET["perPage"]) != "") {
                $filter["perPage"] = $_GET["perPage"];
            }
        } else {
            $filter["perPage"] = 20;
        }

        if (isset($_GET['num_rows'])) {
                $filter['num_rows'] = $_GET['num_rows'];
        }

        return $filter;
    }

    public function create()
    {
        $filter = array();
        $filter = $this->criteria();
        $data["dataList"] = $this->CriteriaASMModel->get_all($filter);

        $this->UIModel->header();
        $this->load->view('settings/criteria-asm/form', $data);
        $this->UIModel->footer();
    }

    public function get_criteria_detail()
    {
        $rs = $this->SharedModel->get_criteria_detail($_POST['criteria_type_id']);
        echo json_encode($rs);
    }

}