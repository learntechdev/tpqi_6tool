<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Portfolio extends CI_Controller
{
    public function __construct()
    {
        header("Content-Type: text/html; charset=UTF-8");
        parent::__construct();
        $this->load->model("masterdata/MasterDataModel");
        $this->load->model("portfolio/PortfolioExamModel");
        $this->load->model("interview/InterviewModel");
        $this->load->model("shared/SharedModel");
    }

    private function criteria()
    {
        $filter = array();

        if (isset($_POST["template"])) {
            $filter["template"] = $_POST["template"];
        } else {
            $filter["template"] = '';
        }

        if (isset($_POST["exam_schedule_id"])) {
            $filter["exam_schedule_id"] = $_POST["exam_schedule_id"];
        } else {
            $filter["exam_schedule_id"] = '';
        }

        if (isset($_POST["app_id"])) {
            $filter["app_id"] = $_POST["app_id"];
        } else {
            $filter["app_id"] = '';
        }

        if (isset($_POST["action"])) {
            $filter["action"] = $_POST["action"];
        } else {
            $filter["action"] = '';
        }

        return $filter;
    }

    public function index()
    {
        $filter = array();
        $filter = $this->criteria();

        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb("1,9,2");
        $data["active_title"] = array("active_title" => "แฟ้มผลงาน");
        $data["template"] = $this->SharedModel->get_template_new($filter["template"], $filter["exam_schedule_id"]);

        $filter['template_type'] = $data["template"][0]->template_type;
        $data["blueprint_detail"] = $this->PortfolioExamModel->getTemplateDetail($filter);

        $data["template_id"] = $filter["template"];
        $data["app_id"] = $filter["app_id"];
        $data["action"] = $filter["action"];
        $data["exam_schedule_id"] = $filter["exam_schedule_id"];

        $this->SharedModel->layouts("portfolio/exam/index", $data);
    }

    public function uploadFile()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $this->input->post("action");
            $appID = $this->input->post("app_id");
            $blueprintID = $this->input->post("blueprint_id");
            $tpqiExamNo = $this->input->post("tpqi_exam_no");
            $uocCode = $this->input->post("uoc_code");
            $tpChkID = $this->input->post("tp_checklist_id");
            $mainTopicID = $this->input->post("maintopic_id");
            $subTopicID = $this->input->post("maintopic_id");

            $folderUpload = "portfolio_file/" . $appID . "/";

            if (!is_dir($folderUpload)) {
                mkdir($folderUpload, 0777, true);
            }

            ini_set('post_max_size', '512G');
            ini_set('upload_max_filesize', '512G');

            $array = explode('.', $_FILES['upload']['name']);
            $ext = end($array);

            $newFilename = $tpqiExamNo . "_" . $tpChkID  . "." . $ext;
            if (move_uploaded_file($_FILES['upload']['tmp_name'], $folderUpload . $_FILES['upload']['name'])) {
                $result = $this->insertPersonAssessmentFile($action, $appID, $blueprintID, $tpqiExamNo, $uocCode, $tpChkID, $mainTopicID, $subTopicID, $_FILES['upload']['name'], $newFilename);
                echo $result;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    private function insertPersonAssessmentFile($action, $appID, $blueprintID, $tpqiExamNo, $uocCode, $tpChkID, $mainTopicID, $subTopicID, $originFilename, $newFilename)
    {
        $data_insert = [
            "tp_checklist_id" => $tpChkID,
            "exam_schedule_id" => $tpqiExamNo,
            "blueprint_id" => $blueprintID,
            "tp_uoc_code" => $uocCode,
            "maintopic_id" => $mainTopicID,
            "subtopic_id" => $subTopicID,
            "app_id" => $appID,
            "file" => $originFilename,
            "new_filename" => $newFilename,
            "create_date" => date('Y-m-d H:i:s'),
            "assessment_status" => "0",
        ];

        if ($action == "edit") {
            $condition = [
                "exam_schedule_id" => $tpqiExamNo,
                "blueprint_id" => $blueprintID,
                "app_id" => $appID,
                "tp_checklist_id" => $tpChkID
            ];
            $result = $this->PortfolioExamModel->updatePersonAssessmentFile($data_insert, $condition);
        } else {
            $result = $this->PortfolioExamModel->insertPersonAssessmentFile($data_insert);
        }
        return $result;
    }
}