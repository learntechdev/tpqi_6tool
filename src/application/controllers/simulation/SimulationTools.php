<?php
require_once __DIR__ . '../../../vendor/autoload.php';
defined('BASEPATH') or exit('No direct script access allowed');

class SimulationTools extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model("masterdata/MasterDataModel");
        $this->load->model("simulation/SimulationToolsModel");
        $this->load->model("interview/InterviewModel");
        $this->load->model("shared/SharedModel");

    }

    public function create()
    {
        unset($_SESSION["template_id"]);
        $data["occ_level"] = $this->MasterDataModel->get_occ_level();
		//$data["occ_level2"] = $this->MasterDataModel->get_occ_level_seperate();
        $data["occ_level"] = $this->MasterDataModel->get_occ_level();
        $data["tier1"] = $this->MasterDataModel->get_occ_tier1_dropdown();


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
        $data["asm_tool_type"] = null;
        if (isset($_POST["asm_tool_type"])) {
            $data["asm_tool_type"] = $_POST["asm_tool_type"];
        }


        $this->SharedModel->layouts("simulation/form", $data);
    }

    public function fetch_uoc()
    {
        $data["uoc"] = $this->MasterDataModel->fetch_uoc($_POST["occ_level_id"]);
        // print_r($data["uoc"]);
        $data["template"] = $_POST["template_id"];
        $data["asm_tool"] = "4";
        $this->load->view("std_list/uoc_qans", $data);
    }

    public function insert()
    {
        $rs = "";
        $template_id = "";
        $json = str_replace(array("\t", "\n"), "", $_POST["dt"]);
        $data = json_decode($json);

        if ($data->action == "create") {
            if ($data->txt_template_id == "") {
                $template_id = $this->MasterDataModel->gen_asm_template($_POST["tool_type"]);

                $rs = $this->insert_tp($template_id, $data, "created");
                if ($rs == 1) {
                    echo $template_id;
                }
            } else { // for edit same template_id
                $template_id = $data->txt_template_id;
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
        } else { //updated
            $template_id = $data->txt_template_id;
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
        $str_occ_level_id = $action == "copy" ? $data->txt_occ_level : $data->occ_level_id;
        $str_template_type = $action == "copy" ? $data->txt_template_type : $data->template_type;
        $str_exam_type = $action == "copy" ? $data->txt_exam_type : $data->exam_type;
		$str_criteria_used_byexamier = $data->criteria_used_byexamier1;
		$str_criteria_type_byexamier = $data->criteria_used_byexamier2;
//        $str_criteria_type_byexamier = $data->criteria_used_byexamier == 0 ? "" : $data->criteria_type_byexamier;

        $data_arr = [

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
            "tool_type" => '4',
        ];

        $rs = $this->SharedModel->insert_template($data_arr);

        if ($rs) {
            $rs_qa_detail = $this->SharedModel->insert_qans_detail($template_id, $data->list);
        }

        $this->SharedModel->insert_user_log($action, "simulation", $template_id, '', '');
        return 1;
    }

    //ปรับปรุงข้อมูล
    private function update_tp($template_id, $data, $action)
    {
        $str_criteria_type_byexamier = $data->criteria_used_byexamier == 0 ? "" : $data->criteria_type_byexamier;

        $str_occ_level_id = $action == "updated" ? $data->txt_occ_level : $data->occ_level_id;
        $str_template_type = $action == "updated" ? $data->txt_template_type : $data->template_type;
        $str_exam_type = $action == "updated" ? $data->txt_exam_type : $data->exam_type;

        $data_update = [
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
            $chk_old_data = $this->SharedModel->isvalid_qans_uoc($template_id);
            if ($chk_old_data == '1') {
                $rs_tp_detail = $this->SharedModel->insert_qans_detail($template_id, $data->list);
            }
        }

        $this->SharedModel->insert_user_log($action, "simulation", $template_id, '', '');
        return 1;
    }

    //ดึงข้อมูลเทมเพลต
    public function get_template()
    {
        $rs = $this->SharedModel->get_blueprint($_POST['template_id']);
        echo json_encode($rs);
    }

    //preview ข้อสอบ
    public function exam_preview()
    {
        $doc_filename = "";

        $data["result"] = $this->SharedModel->get_blueprint($_GET['template_id']);

        $exam_type = $data["result"][0]->exam_type;
        $template_type = $data["result"][0]->template_type;
		$isredirect=false;
        //ถาม-ตอบ (uoc)
        if ($exam_type == "2" && $template_type == "3") {
            $doc_filename = "preview/uoc_qans_html";
            $data['tool_typename'] = "จำลองสถานการณ์";
            $data['rs_detail'] = $this->SharedModel->get_qans_preview($_GET['template_id']);
        } else {
            // $doc_filename = "interview/preview/index";
			 $doc_filename = "preview/uoc_qans_html";
            $data['tool_typename'] = "จำลองสถานการณ์";
            $data['rs_detail'] = $this->SharedModel->get_qans_preview($_GET['template_id']);
        }

        //$mpdf = new mPDF('tha', 'A4', '0', 'THSaraban', 15, 15, 5, 0, 0, 0);
        $html = $this->load->view($doc_filename, $data, true);

        $server_name = $_SERVER['SERVER_NAME'];
        if (filter_var($server_name, FILTER_VALIDATE_IP)) {
            $html = str_replace($server_name, 'localhost', $html);
        }

       // $mpdf->WriteHTML($html);
        //$mpdf->Output();
		
		
			print  $html ;
		
    }

    public function sendtemplate_approve()
    {
        $rs = $this->SharedModel->sendtemplate_approve($_POST['template_id']);
        echo json_decode($rs);
    }

    public function assessment_create()
    {
        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb("1,4,12,13");
        $data["active_title"] = array("active_title" => "บันทึกผลการประเมิน (รายบุคคล)");
        $data["template"] = $this->SharedModel->get_template_forass($_POST['exam_schedule_id'], $_POST["tool_type"], $_POST['occ_level_id']);
        $data["template_detail"] = $this->SimulationToolsModel->get_template_detail($_POST['template_id']);

        $this->SharedModel->layouts("simulation/assessment/form", $data);
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
            $tool_type = $_POST['tool_type'];
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
            $chk_old_data = $this->SimulationToolsModel->is_valid_assessment($exam_schedule_id, $app_id, $tool_type);
            if ($chk_old_data != "0") {
                $rs = $this->SimulationToolsModel->insert_assessment($assessment, $data->list, $tool_type);
            }
        } else {
        }

        //  echo $rs;

        echo json_encode($rs);
    }

    public function saveFileAssessment()
    {
        //เช็คโฟลเดอร์ที่เก็บไฟล์ ถ้าไม่มีให้สร้างใหม่
        if (!@mkdir('simulation_assessment_flie/' . $_POST['app_id'], 0, true)) {

            echo "มีโฟเดอร์อยู่แล้ว";
        } else {
            echo "สร้างโฟเดอร์ใหม่แล้ว";
        }

        $path = "simulation_assessment_flie/" . $_POST['app_id'] . "/";
        chmod($path, 0777);

        //บันทึกไฟล์
        if (isset($_POST['name_flie'])) {
            echo $_POST['name_flie'];
        }
        if (isset($_FILES['upload_file'])) {
            if (move_uploaded_file($_FILES['upload_file']['tmp_name'], $path . $_POST['name_flie'])) {
                echo $_POST['name_flie'] . " OK";
            } else {
                echo $_POST['name_flie'] . " KO";
            }
            exit;
        } else {
            echo "No files uploaded ...";
        }
    }

    public function saveDetailFile()
    {
        //บันทึกข้อมูลไฟล์ของการประเมินครั้งนั้นๆ
        $rs = $this->SimulationToolsModel->save_assessment_detail_file($_POST['data'], $_POST['assessment_id']);
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
        $this->SharedModel->fmanagerlayout("simulation/filemanager", $data);
		
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

	public function get_uoc_grp()
    {
        $data["uoc"] = $this->MasterDataModel->fetch_uoc($_POST["occ_level_id"]);
        $data["template"] = $_POST["template_id"];
        $data["asm_tool"] = $_POST["asm_tool"];
        $this->load->view("std_list/uoc_grp", $data);
    }

	public function get_eoc()
    {
        $data["uoc"] = $this->MasterDataModel->fetch_uoc($_POST["occ_level_id"]);
        $data["template"] = $_POST["template_id"];
        $data["asm_tool"] = $_POST["asm_tool"];
        $this->load->view("std_list/eoc", $data);
    }
    /* private function layouts($view, $data)
{
$this->UIModel->header();
$this->load->view($view, $data);
$this->UIModel->footer();
}
 */
}