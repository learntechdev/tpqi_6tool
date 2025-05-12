<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RptSummaryExam extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("shared/SharedModel");
        $this->load->model("BaseModel");
        $this->load->model("report/RptSummaryExamModel");
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
            $filter["per_page"] = 15;
        }

        if (isset($_GET['num_rows'])) {
            $filter['num_rows'] = $_GET['num_rows'];
        }

        if (isset($_GET['keyword'])) {
            $filter['keyword'] = $_GET['keyword'];
        } else {
            $filter['keyword'] = '';
        }

        return $filter;
    }

    public function index()
    {
        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb("1,20");
        $data["active_title"] = array("active_title" => "รายงานสรุปจำนวนชุดข้อสอบ");

        $filter = array();
        $filter = $this->criteria();
        $data["dataList"] = $this->RptSummaryExamModel->getSummaryExam($filter);

        $this->SharedModel->layouts("report/summaryexam/index", $data);
    }

    public function search()
    {
        $filter = array();
        $filter = $this->criteria();
        $data["dataList"] = $this->RptSummaryExamModel->getSummaryExam($filter);
        $this->load->view("report/summaryexam/showdata", $data);
    }
}