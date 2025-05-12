<?php
require_once __DIR__ . '../../../vendor/autoload.php';
defined('BASEPATH') or exit('No direct script access allowed');

class PortfolioTools extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("masterdata/MasterDataModel");
        $this->load->model("portfolio/PortfolioToolsModel");
        $this->load->model("interview/InterviewModel");
        $this->load->model("shared/SharedModel");
    }

    public function create()
    {
        $data["portfolio_type"] = $this->MasterDataModel->get_portfolio_type();
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

        $data["active_title"] = array("active_title" => "สร้างชุดข้อสอบ");
		$data["uoc"] = null;
        $data["eoc"] = null;
        $data["asm_tool_type"] = $_POST["asm_tool_type"];

        $this->SharedModel->layouts("portfolio/manage/form", $data);
    }

    public function fetch_uoc()
    {
        $data["uoc"] = $this->MasterDataModel->fetch_uoc($_POST["occ_level_id"]);
        $data["template"] = $_POST["template_id"];
        $this->load->view("std_list/uoc_chklist", $data);
    }

    public function fetch_mainsubtopic()
    {
        $data["template"] = $_POST["template_id"];
        $this->load->view("portfolio/manage/q_occ", $data);
    }

    //บันทึกข้อมูลเทมเพลตแบบ checklist ออกข้อสอบตามประเภท uoc
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
		$_SESSION["fileName"] = $_POST["fileName"];
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
		$formdata["fileName"] = $_POST["fileName"];
		
        $file_upload = $this->SharedModel->upload_file($formdata);
    }

    private function insert_tp($template_id, $data, $action)
    {
        $str_occ_level_id = $action == "copy" ? $data->txt_occ_level : $data->occ_level;
        $str_template_type = $action == "copy" ? $data->txt_template_type : $data->template_type;
        $str_exam_type = $action == "copy" ? $data->txt_exam_type : $data->exam_type;
		$str_criteria_used_byexamier = $data->criteria_used_byexamier1;
		$str_criteria_type_byexamier = $data->criteria_used_byexamier2;
//        $str_criteria_type_byexamier = $data->criteria_used_byexamier == 0 ? "" : $data->criteria_type_byexamier;

        $data_arr = [
            "contract_no" => $data->contract_no,
            "template_id" => $template_id,
            "occ_level_id" => $str_occ_level_id,
            "desc_for_examier" => $data->desc_for_examier,
            "des_for_applicant" => $data->desc_for_applicant,
            "template_type" => $str_template_type,
            "exam_type" => $str_exam_type,
            "criteria_used_byexamier" => $str_criteria_used_byexamier,
            "criteria_type_byexamier" => $str_criteria_type_byexamier,
            "created_date" => date('Y-m-d H:i:s'),
            "created_by" => $_SESSION["user_id"],
            "is_used" => '1',
            "tool_type" => '2',
        ];

        $rs = $this->SharedModel->insert_template($data_arr);

        if ($rs) {
            if ($str_exam_type == "1" && $str_template_type == "2") { //ตามคุณวุฒิ & หัวข้อหลัก-ย่อย
                $tp_maintopic = $this->PortfolioToolsModel->insert_tp_checklist_maintopic($template_id, $data->list);
            } else if ($str_exam_type == "2" && $str_template_type == "1") { //ตาม uoc & หัวข้อหลัก
                $rs_tp_detail = $this->SharedModel->insert_chklist_uoc_maintopic("2", $template_id, $data->uocchklist);
            }
        }

        $this->SharedModel->insert_user_log($action, "portfolio", $template_id, '', '');

        return 1;
    }

    //ปรับปรุงข้อมูล
    private function update_tp($template_id, $data, $action)
    {
        $str_criteria_type_byexamier = $data->criteria_used_byexamier == 0 ? "" : $data->criteria_type_byexamier;

        $str_occ_level_id = $action == "updated" ? $data->txt_occ_level : $data->occ_level;
        $str_template_type = $action == "updated" ? $data->txt_template_type : $data->template_type;
        $str_exam_type = $action == "updated" ? $data->txt_exam_type : $data->exam_type;

        $data_update = [
            "contract_no" => $data->contract_no,
            "occ_level_id" => $str_occ_level_id,
            "desc_for_examier" => $data->desc_for_examier,
            "des_for_applicant" => $data->desc_for_applicant,
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
            if ($str_exam_type == "1" && $str_template_type == "2") { //ตามคุณวุฒิ & หัวข้อหลัก-ย่อย
                $chkupdate = $this->PortfolioToolsModel->update_checklist_mainsubtopic($template_id);
                if ($chkupdate == '1') {
                    $tp_maintopic = $this->PortfolioToolsModel->insert_tp_checklist_maintopic($template_id, $data->list);
                }
            } else if ($str_exam_type == "2" && $str_template_type == "1") { //ตาม uoc & หัวข้อหลัก
                $chk_old_data = $this->SharedModel->isvalid_tpdetail_uoc($template_id);
                if ($chk_old_data == '1') {
                    $rs_tp_detail = $this->SharedModel->insert_chklist_uoc_maintopic("2", $template_id, $data->uocchklist);
                }
            }
        }

        $this->SharedModel->insert_user_log($action, "portfolio", $template_id, '', '');
        return 1;
    }

    public function sendtemplate_approve()
    {
        $rs = $this->InterviewModel->sendtemplate_approve($_POST['template_id']);
        echo json_decode($rs);
    }

    //แสดงตัวอย่างข้อสอบ
    public function exam_preview()
    {
        $data["result"] = $this->SharedModel->get_blueprint($_GET['template_id']);
        //print_r($data["result"][0]->template_type);

        $exam_type = $data["result"][0]->exam_type;
        $template_type = $data["result"][0]->template_type;

        if ($exam_type == "1" && $template_type == "2") { // ตามคุณวุฒิ มีหัวข้อหลักและหัวข้อย่อย
            $docFileName = "preview/checklist_mainsub_html";
            $data['rs_detail'] = $this->PortfolioToolsModel->get_checklist_mainsubtopic($_GET['template_id']);
        } else if ($exam_type == "2" && $template_type == "1") { // ตาม uoc มีหัวข้อหลัก
            $docFileName = "preview/uoc_checklist_maintopic_html";
            $data['tool_typename'] = "แฟ้มสะสมผลงาน";
            $data['rs_detail'] = $this->SharedModel->get_chklist_uoc_preview($_GET['template_id']);
        } else {
            $docFileName = "preview/checklist_mainsub_html";
            $data['rs_detail'] = $this->PortfolioToolsModel->get_checklist_mainsubtopic($_GET['template_id']);
        }

        //$mpdf = new mPDF('tha', 'A4', '0', 'THSaraban', 15, 15, 5, 0, 0, 0);
        $html = $this->load->view($docFileName, $data, true);

        $server_name = $_SERVER['SERVER_NAME'];
        if (filter_var($server_name, FILTER_VALIDATE_IP)) {
            $html = str_replace($server_name, 'localhost', $html);
        }

        //$mpdf->WriteHTML($html);
        //$mpdf->Output();
		print $html;
    }

    //ดึงข้อมูลเทมเพลต
    public function get_template()
    {
        $rs = $this->SharedModel->get_blueprint($_POST['template_id']);
        echo json_encode($rs);
    }

    public function assessment_create()
    {
        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb("1,4,5,6");
        $data["active_title"] = array("active_title" => "บันทึกผลการประเมิน (รายบุคคล)");
echo $_POST['template_id'];
        $data["template"] = $this->SharedModel->get_template($_POST['template_id']);
        $data["assessment_detail"] = $this->PortfolioToolsModel->get_assessment_detail($_POST['template_id'], $_POST['exam_schedule_id'], $_POST['app_id'], $data["template"]);
        $this->SharedModel->layouts("portfolio/assessment/form", $data);
    }

    public function insert_assessment_applicant()
    {
        $rs = "";
        $json = str_replace(array("\t", "\n"), "", $_POST["dt"]);
        $data = json_decode($json);

        if ($data->action == "create") {
            $app_id = $data->app_id;
            $exam_schedule_id = $data->exam_schedule_id;

            if (isset($data->assessment_status)) {
                $data->exam_result = $data->assessment_status;
            }

            $str_percent_score = 0.00;
            $str_total_score = 0;
            $str_full_score = 0;
            if ($data->criteria_used_byexamier != 0) {
                $str_percent_score = $data->exam_percent_score;
                $str_total_score = $data->total_score;
                $str_full_score = $data->full_score;
            }

            $assessment = [
                "exam_schedule_id" => $exam_schedule_id,
                "app_id" => $app_id,
                "tool_type" => "2",
                "full_score" => $str_full_score,
                "total_score" => $str_total_score,
                "exam_percent_score" => $str_percent_score,
                "exam_result" => $data->exam_result,
                "recomment" => $data->recomment,
                "assessment_date" => date('Y-m-d H:i:s'),
            ];

            $rs = $this->PortfolioToolsModel->insert_assessment($assessment, $data->detail, "2");
        }

        echo json_encode($rs);
    }

	public function file_manager()
    {
    //    $data["files"] = $this->MasterDataModel->fetch_files();
    //    $data["template_id"] = $_POST["template_id"];
    //   $data["asm_tool"] = $_POST["asm_tool"];
		$data["file_tier1"] = $this->MasterDataModel->get_occ_level_tiers("id", "tier1_title");
		$data["file_tier2"] = $this->MasterDataModel->get_occ_level_tiers("id", "tier2_title");
		$data["file_tier3"] = $this->MasterDataModel->get_occ_level_tiers("id", "tier3_title");
		$data["file_level"] = $this->MasterDataModel->get_occ_level_tiers("id", "level_name");
		$data["files_list"] = $this->MasterDataModel->fetch_files_data();
	//	echo "<prev>";
	//		var_dump($data["files_list"]);
	//	echo "</prev>";
	//	die();
    //    $data["breadcrumb"] = $this->MasterDataModel->breadcrumb("1,2,3");
    //    $data["active_title"] = array("active_title" => "ตัวจัดการไฟล์");
        $this->SharedModel->fmanagerlayout("portfolio/filemanager", $data);
		
    }
}