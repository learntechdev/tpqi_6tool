<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Approve extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();

        $this->load->model("masterdata/MasterDataModel");

        $this->load->model("shared/SharedModel");

        $this->load->model("approve/ApproveModel");

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

            $filter["per_page"] = 10;
        }

        if (isset($_GET['num_rows'])) {

            $filter['num_rows'] = $_GET['num_rows'];
        }

        if (isset($_GET["cmd"])) {

            $filter["cmd"] = $_GET["cmd"];
        }

        if (isset($_GET["occ_level_id"])) {

            $filter["occ_level_id"] = trim($_GET["occ_level_id"]);
        } else {

            $filter["occ_level_id"] = "";
        }

        if (isset($_GET["tool_type"])) {

            $filter["tool_type"] = trim($_GET["tool_type"]);
        } else {

            $filter["tool_type"] = "";
        }

        if (isset($_GET["status"])) {

            $filter["status"] = $_GET["status"];
        } else {

            $filter["status"] = "";
        }

        if (isset($_GET["action"])) {

            $filter["action"] = $_GET["action"];
        } else {

            $filter["action"] = "";
        }

        return $filter;
    }

    public function index()
    {
        $filter = array();
        $filter = $this->criteria();
        $menu = $_SESSION["user_type"] == "8" ? "1,8" : "8";
        $data["dataList"] = $this->ApproveModel->get_review_exam($filter);
        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb($menu);
        $active_title = "อนุมัติชุดข้อสอบ";
        $data["active_title"] = array("active_title" => $active_title);

        $this->SharedModel->layouts("approve/review_exam/index", $data);
    }

    public function search()
    {

        $filter = array();

        $filter = $this->criteria();

        $data["dataList"] = $this->ApproveModel->get_review_exam($filter);

        $this->load->view("approve/review_exam/showdata", $data);
    }

    public function approve_review_exam()
    {

        $rs = $this->ApproveModel->approve_review_exam($_POST['status'], $_POST['template_id'], $_POST['reason_disapprove']);

        $asm_tool = $this->MasterDataModel->tool_type_array();
        foreach ($asm_tool as $v) {
            if ($v['tool_type'] == $_POST['tool_type']) {
                $menu_name = $v['name_eng'];
            }
        }
        $this->SharedModel->insert_user_log("reviewexam", $menu_name, $_POST['template_id'], $_POST['status'], '');

        echo json_encode($rs);
    }

    //ดึงข้อมูลกำหนดการจัดสอบ เพื่อมากำหนดชุดข้อสอบ

    public function choose_exam()
    {

        $filter = array();

        $filter = $this->criteria();

        $menu = $_SESSION["user_type"] == "8" ? "1,9" : "9";

        $data["dataList"] = $this->ApproveModel->get_define_exam($filter);

        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb($menu);

        $active_title = "กำหนดชุดข้อสอบ";

        $data["active_title"] = array("active_title" => $active_title);

        if ($filter["action"] != "search") {

            $this->SharedModel->layouts("approve/choose_exam/index", $data);
        } else {

            $this->load->view("approve/choose_exam/showdata", $data);
        }
    }

    public function get_template()
    {

        $rs = $this->ApproveModel->get_template_arr($_POST["occ_level_id"], $_POST["tool_type"]);

        print_r($rs);

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

    //เลือกชุดข้อสอบสำหรับจัดสอบ

    public function pickexam()
    {

        $rs = "";

        if (isset($_POST['action']) == "create") {

            $json = str_replace(array("\t", "\n"), "", $_POST["dt"]);

            $data = json_decode($json);

            $asm_tool = $this->MasterDataModel->tool_type_array();
            foreach ($asm_tool as $v) {
                if ($v['tool_type'] == $data->txt_tool_type) {
                    $menu_name = $v['name_eng'];
                }
            }
            $this->SharedModel->insert_user_log("pickexam", $menu_name, $data->template, '', $data->exam_schedule_id);

            $rs = $this->ApproveModel->insert_chooseexam($data->template, $data->exam_schedule_id);
        }

        echo $rs;
    }

    //ดึงข้อมูลรอบการสอบ สำหรับกำหนดเกณฑ์การประเมิน

    public function define_criteria()
    {

        $filter = array();

        $filter = $this->criteria();

        $menu = $_SESSION["user_type"] == "8" ? "1,10" : "10";

        $data["dataList"] = $this->ApproveModel->criteria_forapprove($filter);

        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb($menu);

        $active_title = "กำหนดเกณฑ์การผ่าน";

        $data["active_title"] = array("active_title" => $active_title);

        if ($filter["action"] != "search") {

            $this->SharedModel->layouts("approve/define_criteria/index", $data);
        } else {

            $this->load->view("approve/define_criteria/showdata", $data);
        }
    }

    //บันทึกเกณฑ์การผ่าน

    public function insert_criteriaforexam()
    {

        $rs = "";

        $data_arr = "";

        if (isset($_POST['action']) == "create") {

            $json = str_replace(array("\t", "\n"), "", $_POST["dt"]);

            $data = json_decode($json);

            $data_arr = [

                //"template_id" => $data->template_id,

                "exam_criteria_used" => $data->define_criteria_status,

                //"exam_full_score" => $data->full_score,

                //"exam_pass_score" => $data->pass_score,

                "exam_percent_score" => $data->percent_score,

                "exam_schedule_id" => $data->exam_schedule_id,

                "exam_created_date" => date('Y-m-d H:i:s'),

                "exam_created_by" => $_SESSION["user_id"],

                //"updated_date" => date('Y-m-d H:i:s')

                //"updated_by" =>

            ];

            $asm_tool = $this->MasterDataModel->tool_type_array();
            foreach ($asm_tool as $v) {
                if ($v['tool_type'] == $data->txt_tool_type) {
                    $menu_name = $v['name_eng'];
                }
            }
            $this->SharedModel->insert_user_log("definecriteria", $menu_name, '', '', $data->exam_schedule_id);

            $rs = $this->ApproveModel->insert_criteria_forexam($data_arr);
        }

        //echo $data_arr;

        echo $rs;
    }

    //ดึงข้อมูลรอบการสอบ สำหรับมาอนุมัติเกณฑ์การประเมิน

    /*public function criteria_forapprove()

    {

    $filter = array();

    $filter = $this->criteria();

    $menu = $_SESSION["user_type"] == "8" ? "1,10" : "10";

    $data["dataList"] = $this->ApproveModel->criteria_forapprove($filter);

    $data["breadcrumb"] = $this->MasterDataModel->breadcrumb($menu);

    $active_title = "อนุมัติเกณฑ์การประเมิน";

    $data["active_title"] = array("active_title"=> $active_title);

    if($filter["action"] != "search"){

    $this->SharedModel->layouts("approve/approve_criteria/index", $data);

    }else{

    $this->load->view("approve/approve_criteria/showdata",$data);

    }

    }

     */

    public function get_criteria()
    {
        $rs = $this->SharedModel->get_template($_POST['template_id']);
        echo json_encode($rs);
    }

    // ดึงข้อมูลสำหรับอนุมัติชุดข้อสอบ
    public function get_examforapprove()
    {
        $filter = array();
        $filter = $this->criteria();
        $menu = $_SESSION["user_type"] == "8" ? "1,11" : "11";
        $data["dataList"] = $this->ApproveModel->get_examforapprove($filter);
        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb("1,11");
        $active_title = "อนุมัติชุดข้อสอบ";
        $data["active_title"] = array("active_title" => $active_title);
        if ($filter["action"] != "search") {
            $this->SharedModel->layouts("approve/approve_exam/index", $data);
        } else {
            $this->load->view("approve/approve_exam/showdata", $data);
        }
    }

    //ดึงข้อมูลชุดข้อสอบของรอบสอบนั้นๆ

    public function get_template_forapprove()
    {
        $rs = $this->ApproveModel->get_template_forapprove($_POST["template_id"]);
        if ($rs != "" || $rs != null) {
            //$result = "<option value='0'>--ทั้งหมด--</option>";
            $idx = 0;
            $result = "";
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

    public function approve_exam()
    {
        $menu_name = $this->SharedModel->get_tool_type_name($_POST['txt_tool_type'])['name_eng'];
        $this->SharedModel->insert_user_log("approveexam", $menu_name, $_POST['template_id'], $_POST['status'], $_POST['exam_schedule_id']);
        $rs = $this->ApproveModel->approve_exam($_POST['status'], $_POST['template_id'], $_POST['exam_schedule_id'], $_POST['reason_disapproval']);
        echo json_encode($rs);
    }

    //ดึงเหตุผลที่ไม่อนุมัติ ข้อสอบ (ผู้ review)

    public function get_r_reason_disapprove()
    {
        $rs = $this->ApproveModel->get_r_reason_disapprove($_POST['template_id']);
        echo json_encode($rs);
    }
}