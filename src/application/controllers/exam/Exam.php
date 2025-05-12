<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);

class Exam extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("masterdata/MasterDataModel");
        $this->load->model("shared/SharedModel");
        $this->load->model("v2/exam/ExamModel");
        $this->load->model("exam/ExamscheduleModel");
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

        if (isset($_GET["keyword"])) {
            $filter["keyword"] = trim($_GET["keyword"]);
        } else {
            $filter["keyword"] = "";
        }

        if (isset($_GET["tool_type"])) {
            $filter["tool_type"] = trim($_GET["tool_type"]);
        } else {
            $filter["tool_type"] = "";
        }

        if (isset($_GET["type"])) {
            $filter["type"] = trim($_GET["type"]);
        } else {
            $filter["type"] = "";
        }

        if (isset($_GET["status"])) {
            $filter["status"] = $_GET["status"];
        } else {
            $filter["status"] = "";
        }

        return $filter;
    }

    public function index()
    {
        $filter = array();
        $filter = $this->criteria();
        $data["dataList"] = $this->ExamscheduleModel->get_all($filter);
        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb("1,8");
        $active_title = $filter["type"] == "define" ? "กำหนดชุดข้อสอบ" : "อนุมัติเกณฑ์การประเมิน";
        $data["active_title"] = array("active_title" => $active_title);
        
        $this->SharedModel->layouts("exam/index", $data);
    }

    public function get_template()
    {
        $rs = $this->ExamscheduleModel->get_template_arr($_POST["occ_level_id"]);
        if ($rs != "" || $rs != null) {
            $result = "<option value='0'>--ทั้งหมด--</option>";
            $idx = 0;
            foreach ($rs as $v) {
                $idx++;
                $result .= "<option value='" . $v['template_id'] . "'>" .
                    $v['template_id'] . ' เทมเพลตที่ ' . $idx . ' ( จัดทำ ' . $this->BaseModel->dateToThai($v['created_date'], false) . ')' .
                    "</option>";
            }
        } else {
            $result = "<option value='0'>-- ไม่มีเทมเพลต สำหรับสาขาวิชาชีพนี้ --</option>";
        }
        
        echo $result;
    }

    public function get_criteria_advise()
    {
        $data = $this->ExamscheduleModel->get_exam_criteria_advise($_POST["template_id"]);
        echo json_encode($data);
    }

    //เลือกชุดข้อสอบสำหรับจัดสอบ

    public function pickexam()
    {
        $rs = "";
        if (isset($_POST['action']) == "create") {
            $json = str_replace(array("\t", "\n"), "", $_POST["dt"]);
            $data = json_decode($json);
            $rs = $this->ExamscheduleModel->insert_exam_criteria($data->template, $data->exam_schedule_id);
        }
        echo $rs;
    }

    //อนุมัติเกณฑ์การประเมิน

    public function approve_exam_criteria()
    {
        $rs = $this->ExamscheduleModel->approve_exam_criteria($_POST['approve_status'], $_POST['exam_schedule_id'], $_POST["reason_disapproval"]);
        echo json_decode($rs);
    }

    public function search()
    {
        $filter = array();
        $filter = $this->criteria();
        $data["dataList"] = $this->ExamscheduleModel->get_all($filter);
        $this->load->view("exam/showdata", $data);
    }

    private function criteria_examforexaminee()
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

        if (isset($_GET["tool_type"])) {
            $filter["tool_type"] = $_GET["tool_type"];
        } else {
            $filter["tool_type"] = "";
        }

        if (isset($_GET["exam_used"])) {
            $filter["exam_used"] = $_GET["exam_used"];
        } else {
            $filter["exam_used"] = "";
        }

        return $filter;
    }

    public function examforexaminee()
    {
        $filter = array();
        $filter = $this->criteria_examforexaminee();
        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb("1,7");
        $data["dataList"] = $this->ExamModel->get_examforexaminee($filter);
        $data["active_title"] = array("active_title" => "นำข้อสอบไปใช้งาน");
        $this->SharedModel->layouts("exam/examforexaminee/index", $data);
    }

    public function search_examforexaminee()
    {
        $filter = array();
        $filter = $this->criteria_examforexaminee();
        $data["dataList"] = $this->ExamModel->get_examforexaminee($filter);
        $this->load->view("exam/examforexaminee/showdata", $data);
    }

    //เมื่อกด print ให้อัพเดตสถานะของข้อสอบว่าถูกใช้งานแล้ว

    public function update_exam_status()
    {
        $asm_tool = $this->MasterDataModel->tool_type_array();
        foreach ($asm_tool as $v) {
            if ($v['tool_type'] == $_POST['tool_type']) {
                $menu_name = $v['name_eng'];
            }
        }
        $this->SharedModel->insert_user_log("examused", $menu_name, $_POST['template_id'], '', $_POST['exam_schedule_id']);

        $rs = $this->ExamModel->update_exam_status($_POST['template_id'], $_POST['exam_schedule_id']);
        echo json_decode($rs);
    }
}