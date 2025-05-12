<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PersonAssessment extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("masterdata/MasterDataModel");
        $this->load->model("assessment/AssessmentModel");
        $this->load->model("assessment/PersonAssessmentModel");
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
        if (isset($_GET["keyword"])) {
            $filter["keyword"] = $_GET["keyword"];
        } else {
            $filter["keyword"] = "";
        }

        if (isset($_GET["ass_status"])) {
            $filter["ass_status"] = $_GET["ass_status"];
        } else {
            $filter["ass_status"] = "";
        }
        return $filter;
    }

    public function index()
    {
        $filter = array();
        $filter = $this->criteria();
        $data["dataList"] = $this->PersonAssessmentModel->get_all($filter);
        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb("1,4");
        $data["active_title"] = array("active_title" => "ข้อมูลการประเมิน");
        $this->SharedModel->layouts("assessment/person_assessment/index", $data);
    }

    //ค้นหาข้อมูล CB ที่จะประเมินผล

    public function search()
    {
        $filter = array();
        $filter = $this->criteria();
        $data["dataList"] = $this->PersonAssessmentModel->get_all($filter);
        $this->load->view("assessment/person_assessment/showdata", $data);
    }
}