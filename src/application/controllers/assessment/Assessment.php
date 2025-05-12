<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);
class Assessment extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("masterdata/MasterDataModel");
        $this->load->model("v2/assessment/AssessmentModel");
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
        $data["dataList"] = $this->AssessmentModel->get_all($filter);
        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb("1,4");
        $data["active_title"] = array("active_title" => "ปรเมินผล");

        $this->layouts("assessment/list_assessment/index", $data);
    }

    //ค้นหาข้อมูล CB ที่จะประเมินผล
    public function search()
    {
        $filter = array();
        $filter = $this->criteria();
        $data["dataList"] = $this->AssessmentModel->get_all($filter);
        $this->load->view("assessment/list_assessment/showdata", $data);
    }

    private function criteria_applicant_assessment()
    {
        $filter = array();

        if (isset($_POST["page_no"])) {
            if (trim($_POST["page_no"]) != "") {
                $filter["page_no"] = $_POST["page_no"];
            }
        } else {
            $filter["page_no"] = 1;
        }

        if (isset($_POST["per_page"])) {
            if (trim($_POST["per_page"]) != "") {
                $filter["per_page"] = $_POST["per_page"];
            }
        } else {
            $filter["per_page"] = 30;
        }

        if (isset($_POST['num_rows'])) {
            $filter['num_rows'] = $_POST['num_rows'];
        }

        if (isset($_POST['exam_schedule_id'])) {
            $filter['exam_schedule_id'] = $_POST['exam_schedule_id'];
        } else {
            $filter['exam_schedule_id'] = "";
        }

        if (isset($_POST['occ_level_id'])) {
            $filter['occ_level_id'] = $_POST['occ_level_id'];
        } else {
            $filter['occ_level_id'] = "";
        }

        if (isset($_POST['keyword'])) {
            $filter['keyword'] = $_POST['keyword'];
        } else {
            $filter['keyword'] = "";
        }

        if (isset($_POST['tool_type'])) {
            $filter['tool_type'] = $_POST['tool_type'];
        } else {
            $filter['tool_type'] = "";
        }

        if (isset($_POST['assessment_status'])) {
            $filter['assessment_status'] = $_POST['assessment_status'];
        } else {
            $filter['assessment_status'] = "";
        }

        return $filter;
    }

    //แสดงรายชื่อผู้เข้ารับการประเมิน
    public function applicant_assessment()
    {

        $filter = array();
        $filter = $this->criteria_applicant_assessment();
        $data["dataList"] = $this->AssessmentModel->get_applicant_assessment($filter);
        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb("1,4,5");
        $data["tool_type"] = $filter['tool_type'];
        $data["active_title"] = array("active_title" => "แสดงรายชื่อผู้เข้ารับการประเมิน");

        $this->layouts("v2/assessment/applicant_assessment/index", $data);
    }

    //ค้นหารายชื่อผู้เข้ารับการประเมิน
    public function search_applicant_assessment()
    {
        $filter = array();
        $filter = $this->criteria_applicant_assessment();
        $data["dataList"] = $this->AssessmentModel->get_applicant_assessment($filter);
        $data["tool_type"] = $filter['tool_type'];
        $this->load->view("v2/assessment/applicant_assessment/showdata", $data);
    }

    //ยืนยันการประเมินและส่งผลการประเมิน
    public function confirm_applicant_assessment()
    {
        $rs = $this->SharedModel->confirm_applicant_assessment($_POST['exam_schedule_id'], $_POST['app_id']);
        echo json_decode($rs);
    }

    private function layouts($view, $data)
    {
        $this->UIModel->header();
        $this->load->view($view, $data);
        $this->UIModel->footer();
    }
}