<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ReportExamResults extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("shared/SharedModel");
        $this->load->model("settings/CriteriaToolModel");
        $this->load->model("BaseModel");
        $this->load->model("report/ReportExamResultsModel");
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
            $filter["per_page"] = 10;
        }

        if (isset($_GET['num_rows'])) {
            $filter['num_rows'] = $_GET['num_rows'];
        }

        if (isset($_GET['keyword'])) {
            $filter['keyword'] = $_GET['keyword'];
        } else {
            $filter['keyword'] = '';
        }

        if (isset($_GET['tp_created_date_start'])) {
            $filter['tp_created_date_start'] = $_GET['tp_created_date_start'];
        } else {
            $filter['tp_created_date_start'] = '';
        }

        if (isset($_GET['tp_created_date_end'])) {
            $filter['tp_created_date_end'] = $_GET['tp_created_date_end'];
        } else {
            $filter['tp_created_date_end'] = '';
        }

        if (isset($_GET['form_type'])) {
            $filter['form_type'] = $_GET['form_type'];
        } else {
            $filter['form_type'] = '';
        }
        if (isset($_GET['criteria_type_id'])) {
            $filter['criteria_type_id'] = $_GET['criteria_type_id'];
        } else {
            $filter['criteria_type_id'] = '';
        }
        if (isset($_GET['title'])) {
            $filter['title'] = $_GET['title'];
        } else {
            $filter['title'] = '';
        }
        if (isset($_GET['description'])) {
            $filter['description'] = $_GET['description'];
        } else {
            $filter['description'] = '';
        }
        if (isset($_GET['status'])) {
            $filter['status'] = $_GET['status'];
        } else {
            $filter['status'] = '';
        }

        if (isset($_GET['min_score'])) {
            $filter['min_score'] = $_GET['min_score'];
        } else {
            $filter['min_score'] = '';
        }
        if (isset($_GET['max_score'])) {
            $filter['max_score'] = $_GET['max_score'];
        } else {
            $filter['max_score'] = '';
        }

        return $filter;
    }

    public function index()
    {
        $filter = array();
        $filter = $this->criteria();
        $menu = $_SESSION["user_type"] == "8" ? "1,8" : "8";
        $data["data"] = $this->ReportExamResultsModel->exam_results($filter);
        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb($menu);

        $active_title = "แก้ไขเกณฑ์การประเมิน";
        $data["active_title"] = array("active_title" => $active_title);

        $this->SharedModel->layouts("report/exam_results/index", $data);
    }

    public function roundExamResult()
    {
        $filter = array();
        $filter = $this->criteria();
        $menu = $_SESSION["user_type"] == "8" ? "1,8" : "8";
        $data["dataList"] = $this->ReportExamResultsModel->search($filter);
        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb($menu);

        $active_title = "แก้ไขเกณฑ์การประเมิน";
        $data["active_title"] = array("active_title" => $active_title);

        $this->SharedModel->layouts("report/round_examresult/index", $data);
    }

    public function search()
    {
        $filter = array();
        $filter = $this->criteria();
        $data["dataList"] = $this->ReportExamResultsModel->search($filter);

        $this->load->view("report/round_examresult/showdata", $data);
    }

    private function criteriaDetailExamResult()
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
            $filter["per_page"] = 10;
        }

        if (isset($_POST['tpqi_exam_no'])) {
            $filter['tpqi_exam_no'] = $_POST['tpqi_exam_no'];
        } else {
            $filter['tpqi_exam_no'] = '';
        }

        if (isset($_POST['tool_type'])) {
            $filter['tool_type'] = $_POST['tool_type'];
        } else {
            $filter['tool_type'] = '';
        }

        if (isset($_POST['keyword'])) {
            $filter['keyword'] = $_POST['keyword'];
        } else {
            $filter['keyword'] = '';
        }

        if (isset($_POST['tp_created_date_start'])) {
            $filter['tp_created_date_start'] = $_POST['tp_created_date_start'];
        } else {
            $filter['tp_created_date_start'] = '';
        }

        if (isset($_POST['tp_created_date_end'])) {
            $filter['tp_created_date_end'] = $_POST['tp_created_date_end'];
        } else {
            $filter['tp_created_date_end'] = '';
        }
        return $filter;
    }

    public function detailRoundExamResult()
    {
        $filter = array();
        $filter = $this->criteriaDetailExamResult();
        $data["dataList"] = $this->ReportExamResultsModel->detailRoundExamResult($filter);

        $this->SharedModel->layouts("report/detail_roundexamresult/index", $data);
    }

    public function searchDetailRoundExamResult()
    {
        $filter = array();
        $filter = $this->criteriaDetailExamResult();
        $data["dataList"] = $this->ReportExamResultsModel->detailRoundExamResult($filter);
        // $data["tpqi_exam_no"] = $_POST["tpqi_exam_no"];

        $this->load->view("report/detail_roundexamresult/showdata", $data);
    }
}