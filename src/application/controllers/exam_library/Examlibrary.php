<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Examlibrary extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("masterdata/MasterDataModel");
        $this->load->model("exam_library/ExamlibraryModel");
        $this->load->model("shared/SharedModel");
    }

    private function criteria()
    {
        $filter = array();
        if (isset($_GET["page_no"])) {
            if (trim($_GET["page_no"]) != "") {
                $filter["page_no"] = $_GET["page_no"];
            }
        } else {
            $filter["page_no"] = 1;
        }

        if (isset($_GET["per_page"])) {
            if (trim($_GET["per_page"]) != "") {
                $filter["per_page"] = $_GET["per_page"];
            }
        } else {
            $filter["per_page"] = 20;
        }

        if (isset($_GET['num_rows'])) {
            $filter['num_rows'] = $_GET['num_rows'];
        }

        if (isset($_GET["cmd"])) {
            $filter["cmd"] = $_GET["cmd"];
        }

        if (isset($_GET["tool_type"])) {
            $filter["tool_type"] = $_GET["tool_type"];
        } else {
            $filter["tool_type"] = '';
        }

        if (isset($_GET["occ_level_id"])) {
            $filter["occ_level_id"] = $_GET["occ_level_id"];
        } else {
            $filter["occ_level_id"] = '';
        }

        if (isset($_GET["tp_created_date_start"])) {
            $filter["tp_created_date_start"] = $_GET["tp_created_date_start"];
        } else {
            $filter["tp_created_date_start"] = '';
        }

        if (isset($_GET["tp_created_date_end"])) {
            $filter["tp_created_date_end"] = $_GET["tp_created_date_end"];
        } else {
            $filter["tp_created_date_end"] = '';
        }

        if (isset($_GET["contract_no"])) {
            $filter["contract_no"] = $_GET["contract_no"];
        } else {
            $filter["contract_no"] = '';
        }

        return $filter;
    }

    public function index()
    {

        $filter = array();
        $filter = $this->criteria();
        $data["dataList"] = $this->ExamlibraryModel->get_all($filter);
        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb("1,2");
        $data["url"] = $this->MasterDataModel->url_create_tool($filter["tool_type"]);
        $data["active_title"] = array("active_title" => "คลังข้อสอบ");
        $data["tool_type"] = $filter["tool_type"];

        $this->SharedModel->layouts("exam_library/index", $data);
    }

    public function search()
    {

        $filter = array();

        $filter = $this->criteria();

        $data["dataList"] = $this->ExamlibraryModel->get_all($filter);

        $data["tool_type"] = $filter["tool_type"];

        $this->load->view("exam_library/show_occ_level", $data);
    }

    public function cancel()
    {
        $menu_name = '';
        $rs = $this->ExamlibraryModel->cancel_data($_POST['tp_id']);

        $asm_tool = $this->MasterDataModel->tool_type_array();
        foreach ($asm_tool as $v) {
            if ($v['tool_type'] == $_POST['tool_type']) {
                $menu_name = $v['name_eng'];
            }
        }
        $this->SharedModel->insert_user_log("delete", $menu_name, $_POST['tp_id'], '', '');
        echo json_decode($rs);
    }
	
	public function approve_review_exam()
    {

        $rs = $this->ExamlibraryModel->approve_review_exam($_POST['status'], $_POST['template_id'], $_POST['reason_disapprove']);

        $asm_tool = $this->MasterDataModel->tool_type_array();
        foreach ($asm_tool as $v) {
            if ($v['tool_type'] == $_POST['tool_type']) {
                $menu_name = $v['name_eng'];
            }
        }
        $this->SharedModel->insert_user_log("reviewexam", $menu_name, $_POST['template_id'], $_POST['status'], '');

        echo json_encode($rs);
    }
}