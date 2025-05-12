<?php
require_once __DIR__ . '../../../vendor/autoload.php';
//require_once __DIR__ . '../../../../vendor/autoload.php';
defined('BASEPATH') or exit('No direct script access allowed');
class InterviewTool extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("masterdata/MasterDataModel");
        $this->load->model("interview/InterviewModel");
        $this->load->model("shared/SharedModel");
        $this->load->model("templates/TemplatesModel");
        $this->load->model("assessment/AssessmentResultModel");
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

    public function get_uoc()
    {
        $data["uoc"] = $this->MasterDataModel->fetch_uoc($_POST["occ_level_id"]);
        $data["template"] = $_POST["template_id"];
        $data["asm_tool"] = $_POST["asm_tool"];
		if($_POST["template_type"] == 3){
			$this->load->view("std_list/uoc", $data);
		}else if($_POST["template_type"] == 1){
			$this->load->view("std_list/uoc_chklist", $data);
		}else{
	//		$this->load->view("portfolio/manage/q_occ", $data);
		}
    }

    public function get_eoc()
    {
        $data["uoc"] = $this->MasterDataModel->fetch_uoc($_POST["occ_level_id"]);
        $data["template"] = $_POST["template_id"];
        $data["asm_tool"] = $_POST["asm_tool"];
        $this->load->view("std_list/eoc", $data);
    }
	
	public function get_uoc_grp()
    {
        $data["uoc"] = $this->MasterDataModel->fetch_uoc($_POST["occ_level_id"]);
        $data["template"] = $_POST["template_id"];
        $data["asm_tool"] = $_POST["asm_tool"];
        $this->load->view("std_list/uoc_grp", $data);
    }


    //ดึงข้อมูลเทมเพลต
    public function get_template()
    {
        $rs = $this->SharedModel->get_blueprint($_POST['template_id']);
        echo json_encode($rs);
    }

    public function create()
    {
        unset($_SESSION["template_id"]);
		$data["occ_level"] = $this->MasterDataModel->get_occ_level();
        $data["occ_level2"] = $this->MasterDataModel->get_occ_level_seperate();  

        if (isset($_POST['action'])) {
            if ($_POST['action'] == 'update') {
                $data["breadcrumb"] = $this->MasterDataModel->breadcrumb("1,2,14");
            } else {
                $data["breadcrumb"] = $this->MasterDataModel->breadcrumb("1,2,15");
            }
        } else {
            $data["breadcrumb"] = $this->MasterDataModel->breadcrumb("1,2,3");
        }
        $data["active_title"] = array("active_title" => "สร้างข้อสอบ");
        $data["uoc"] = null;
        $data["eoc"] = null;
        $data["asm_tool_type"] = $_POST["asm_tool_type"];

        $this->SharedModel->layouts("interview/form", $data);
    }

    //บันทึกข้อมูล การสร้างชุดข้อสอบแบบสัมภาษณ์
    public function insert()
    {
        $rs = "";
        $template_id = "";
        $json = str_replace(array("\t", "\n"), "", $_POST["dt"]);
        $data = json_decode($json);

        if ($data->action == "create") {
            if ($data->template_id == "") {
                $template_id = $this->MasterDataModel->gen_asm_template($_POST["tool_type"]);
                $rs = $this->insert_tp($template_id, $data, "created");
                if ($rs == 1) {
                    echo $template_id;
                }
            } else { // for edit
                $template_id = $data->template_id;
                $isvalid_template = $this->SharedModel->isvalid_exam_blueprint($template_id);

                if ($isvalid_template > 0) {
                    $str_update = $this->update_tp($template_id, $data, "created");
                    if ($str_update == "1") {
                        echo $template_id;
                    }
                }
            }
        } else if ($data->action == "copy") {
            if ($data->copy_tp_id == "") {
                $template_id = $this->MasterDataModel->gen_asm_template($_POST["tool_type"]);
                $rs = $this->insert_tp($template_id, $data, "copy");
                if ($rs == 1) {
                    echo $template_id;
                }
            } else { // for edit same template_id
                $template_id = $data->copy_tp_id;
                $isvalid_template = $this->SharedModel->isvalid_exam_blueprint($template_id);

                if ($isvalid_template > 0) {
                    $str_update = $this->update_tp($template_id, $data, "copy_updated");
                    if ($str_update == "1") {
                        echo $template_id;
                    }
                }
            }
        } else { // for edit
            $template_id = $data->template_id;
            $isvalid_template = $this->SharedModel->isvalid_exam_blueprint($template_id);

            if ($isvalid_template > 0) {
                $str_update = $this->update_tp($template_id, $data, "updated");
                if ($str_update == "1") {
                    echo $template_id;
                }
            }
        }
    }
	
	public function insert2()
    {
        $rs = "";
        $template_id = "";
    //    $json = str_replace(array("\t", "\n"), "", $_POST["dt"]);
    //    $formdata = json_decode($json);
		$formdata["qualification2"] = $_POST["qualification"];
		$formdata["branch2"] = $_POST["branch"];
		$formdata["occupation2"] = $_POST["occupation"];
		$formdata["level2"] = $_POST["level"];
		$formdata["interview"] = $_POST["interview"];
		$formdata["show"] = $_POST["show"];
		$formdata["file"] = $_POST["file"];
		$formdata["evaluate"] = $_POST["evaluate"];
		$formdata["mock"] = $_POST["mock"];
		$formdata["observe"] = $_POST["observe"];
		$formdata["resk"] = $_POST["resk"];
		$formdata["fileName"] = "Something";
		
        $file_upload = $this->SharedModel->upload_file($formdata);
		
    }

    private function insert_tp($template_id, $data, $action)
    {
        $str_occ_level_id = $action == "copy" ? $data->txt_occ_level : $data->occ_level_id;
        $str_template_type = $action == "copy" ? $data->txt_template_type : $data->template_type;
        $str_exam_type = $action == "copy" ? $data->txt_exam_type : $data->exam_type;
        $str_criteria_type_byexamier = $data->criteria_used_byexamier == 0 ? "" : $data->criteria_type_byexamier;

        $data_arr = [
            "contract_no" => $data->contract_no,
            "template_id" => $template_id,
            "occ_level_id" => $str_occ_level_id,
            "desc_for_examier" => $data->desc_for_examier,
            "des_for_applicant" => $data->desc_for_applicant,
            "case_study" => $data->case_study,
            "template_type" => $str_template_type,
            "exam_type" => $str_exam_type,
            "criteria_used_byexamier" => $data->criteria_used_byexamier,
            "criteria_type_byexamier" => $str_criteria_type_byexamier,
            "created_date" => date('Y-m-d H:i:s'),
            "created_by" => $_SESSION["user_id"],
            "is_used" => '1',
            "tool_type" => '3',
        ];

        $rs = $this->SharedModel->insert_template($data_arr);
        if ($rs) {
            $rs_qa_detail = $this->InterviewModel->insert_qans_detail($template_id, $data->list);
        }

        $this->SharedModel->insert_user_log($action, "interview", $template_id, '', '', '');
        return 1;
    }

    //ปรับปรุงข้อมูล
    private function update_tp($template_id, $data, $action)
    {
        $str_criteria_type_byexamier = $data->criteria_used_byexamier == 0 ? "" : $data->criteria_type_byexamier;
        
        $str_occ_level_id = "";
        $str_template_type = "";
        $str_template_type = "";

        if ($action == "updated" || $action == "copy_updated") {
            $str_occ_level_id = $data->txt_occ_level;
        } else {
            $str_occ_level_id = $data->occ_level_id;
        }

        if ($action == "updated" || $action == "copy_updated") {
            $str_template_type = $data->txt_template_type;
        } else {
            $str_template_type = $data->template_type;
        }

        if ($action == "updated" || $action == "copy_updated") {
            $str_exam_type = $data->txt_exam_type;
        } else {
            $str_exam_type = $data->exam_type;
        }

        $data_update = [
            "contract_no" => $data->contract_no,
            "occ_level_id" => $str_occ_level_id,
            "desc_for_examier" => $data->desc_for_examier,
            "des_for_applicant" => $data->desc_for_applicant,
            "case_study" => $data->case_study,
            "template_type" => $str_template_type,
            "exam_type" => $str_exam_type,
            "criteria_used_byexamier" => $data->criteria_used_byexamier,
            "criteria_type_byexamier" => $str_criteria_type_byexamier,
            "last_modified_date" => date('Y-m-d H:i:s'),
            "last_modified_by" => $_SESSION["user_id"],
            "is_used" => '1',
        ];

        $update = $this->SharedModel->update_template($template_id, $data_update);
        if ($update) {
            $chk_old_data = $this->InterviewModel->isvalid_detail($template_id);
            if ($chk_old_data == '1') {
                $rs_tp_detail = $this->InterviewModel->insert_qans_detail($template_id, $data->list);
            }
        }

        $this->SharedModel->insert_user_log($action, "interview", $template_id, '', '', '');
        return 1;
    }

    public function preview()
    {
        $doc_filename = "";
        $html = "";
        //ตรวจสอบว่าสร้างชุดข้อสอบประเภทใด
        $tp_type = $this->SharedModel->get_blueprint($_GET['template_id']);

        if ($tp_type[0]->exam_type == "2") {
            $doc_filename = "preview/qans_uoc_html";
        } else {
            $doc_filename = "preview/qans_eoc_html";
        }

	if( $tp_type != null && $tp_type != "" ) {
        $data['result'] = $this->InterviewModel->get_tp_preview($_GET['template_id']);
        $data['rs_detail'] = $this->InterviewModel->get_tp_detail($_GET['template_id']);
        $data['tool_typename'] = "สัมภาษณ์";
		
		//echo json_encode($data);
		
        //$mpdf = new mPDF('tha', 'A4', '0', 'THSaraban', 15, 15, 5, 0, 0, 0);
		//$mPdf->shrink_tables_to_fit = 1;
        $html = $this->load->view($doc_filename, $data, true);
        $server_name = $_SERVER['SERVER_NAME'];
        if (filter_var($server_name, FILTER_VALIDATE_IP)) {
            $html = str_replace($server_name, 'localhost', $html);
        }
	}else{
		$html = "Template Error";
	}
        //$mpdf->WriteHTML($html);
        //$mpdf->Output();
		print $html;
		
    }

    public function sendtemplate_approve()
    {
        $rs = $this->InterviewModel->sendtemplate_approve($_POST['template_id']);
        echo json_decode($rs);
    }

    public function assessment_create()
    {
        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb("1,4,12,13");
        $data["active_title"] = array("active_title" => "บันทึกผลการประเมิน (รายบุคคล)");
        $data["template"] = $this->SharedModel->get_template_forass($_POST['exam_schedule_id'], $_POST["tool_type"], $_POST['occ_level_id']);
        $data["template_detail"] = $this->TemplatesModel->get_tp_detail($_POST['template_id']);

        $this->SharedModel->layouts("interview/assessment/form", $data);
    }

    // บันทึกการประเมิน (เจ้าหน้าที่สอบ)
    public function insert_assessment_applicant()
    {
        $rs = "";
        $json = str_replace(array("\t", "\n"), "", $_POST["dt"]);
        $data = json_decode($json);

        if ($data->action == "create") {
            $app_id = $data->app_id;
            $exam_schedule_id = $data->exam_schedule_id;
            $tool_type = "3";

            $assessment = [
                "exam_schedule_id" => $exam_schedule_id,
                "app_id" => $app_id,
                "tool_type" => $tool_type,
                "total_score" => $data->total_score,
                "full_score" => $data->full_score,
                "exam_percent_score" => $data->exam_percent_score,
                "exam_result" => $data->exam_result,
                "recomment" => $data->recomment,
                "assessment_date" => date('Y-m-d H:i:s'),
            ];

            //เช็คว่ามีข้อมูลอยู่ใน db หรือยัง ถ้ามีให้ลบออกก่อน
            $chk_old_data = $this->InterviewModel->is_valid_assessment($exam_schedule_id, $app_id, $tool_type);
            if ($chk_old_data != "0") {
                $rs = $this->InterviewModel->insert_assessment($assessment, $data->list);
            }
        }

        echo $rs;

        //  echo json_encode($data);

    }
	
	public function file_manager()
    {
        $data["files"] = $this->MasterDataModel->fetch_files();
		$tp_id = $_POST["template_id"];
        $data["template_id"] = $_POST["template_id"];
    //   $data["asm_tool"] = $_POST["asm_tool"];
		$data["file_tier1"] = $this->MasterDataModel->get_occ_level_tiers("id", "tier1_title");
		$data["file_tier2"] = $this->MasterDataModel->get_occ_level_tiers("id", "tier2_title");
		$data["file_tier3"] = $this->MasterDataModel->get_occ_level_tiers("id", "tier3_title");
		$data["file_level"] = $this->MasterDataModel->get_occ_level_tiers("id", "level_name");
		
        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb("1,2,3");
        $data["active_title"] = array("active_title" => "ตัวจัดการไฟล์");
        $this->SharedModel->fmanagerlayout("interview/filemanager", $data);
		
    }
	
	public function file_manager2()
    {

        $filter = array();

        $filter = $this->criteria();

        $menu = $_SESSION["user_type"] == "8" ? "1,9" : "9";

    //    $data["dataList"] = $this->ApproveModel->get_define_exam($filter);
		$data["files"] = $this->MasterDataModel->fetch_files($filter);
        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb("1,2,3");
        $data["active_title"] = array("active_title" => "ตัวจัดการไฟล์");

        if ($filter["action"] != "search") {

            $this->SharedModel->layouts("approve/choose_exam/index", $data);
        } else {

            $this->load->view("approve/choose_exam/showdata", $data);
        }
    }
}