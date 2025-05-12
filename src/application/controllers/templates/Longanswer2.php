<?php
require_once __DIR__ . '../../../vendor/autoload.php'; //mpdf 6.4
//require_once __DIR__ . '../../../../vendor/autoload.php'; //mpdf 8.0.10
//require_once dirname(__FILE__) . '../../../../vendor/autoload.php';
//use Dompdf\Dompdf;
defined('BASEPATH') or exit('No direct script access allowed');
//header('Content-Type: text/plain; charset=utf-8');

class Longanswer extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("masterdata/MasterDataModel");
        $this->load->model("shared/SharedModel");
        $this->load->model("templates/TemplatesModel");
    }

    public function insert()
    {
        $rs = "";
        $template_id = "";
        $json = str_replace(array("\t", "\n"), "", $_POST["dt"]);
        $data = json_decode($json);

        if ($data->action == "create") {
            if ($data->template_id == "") {
                $template_id = $this->MasterDataModel->gen_asm_template($_POST["tool_type"]);

                $rs = $this->insert_tp($template_id, $data, "created", $_POST["tool_type"]);
                if ($rs == 1) {
                    echo $template_id;
                }
            } else { // for edit
                $template_id = $data->template_id;
                $isvalid_template = $this->SharedModel->isvalid_exam_blueprint($template_id);

                if ($isvalid_template > 0) {
                    $str_update = $this->update_tp($template_id, $data, "created", $_POST["tool_type"]);
                    if ($str_update == "1") {
                        echo $template_id;
                    }
                }
            }
        } else if ($data->action == "copy") {
            if ($data->copy_tp_id == "") {
                $template_id = $this->MasterDataModel->gen_asm_template($_POST["tool_type"]);

                $rs = $this->insert_tp($template_id, $data, "copy", $_POST["tool_type"]);
                if ($rs == 1) {
                    echo $template_id;
                }
            } else { // for edit same template_id
                $template_id = $data->copy_tp_id;
                $isvalid_template = $this->SharedModel->isvalid_exam_blueprint($template_id);

                if ($isvalid_template > 0) {
                    $str_update = $this->update_tp($template_id, $data, "copy_updated", $_POST["tool_type"]);
                    if ($str_update == "1") {
                        echo $template_id;
                    }
                }
            }
        } else { // for edit
            $template_id = $data->template_id;
            $isvalid_template = $this->SharedModel->isvalid_exam_blueprint($template_id);

            if ($isvalid_template > 0) {
                $str_update = $this->update_tp($template_id, $data, "updated", $_POST["tool_type"]);
                if ($str_update == "1") {
                    echo $template_id;
                }
            }
        }
    }

    private function insert_tp($template_id, $data, $action, $tool_type)
    {
        $str_occ_level_id = $action == "copy" ? $data->txt_occ_level : $data->occ_level_id;
        $str_template_type = $action == "copy" ? $data->txt_template_type : $data->template_type;
        $str_exam_type = $action == "copy" ? $data->txt_exam_type : $data->exam_type;
        $str_criteria_type_byexamier = $data->criteria_used_byexamier == 0 ? "" : $data->criteria_type_byexamier;

        if ($tool_type == "3" || $tool_type == "4") {
            $case_study = $data->case_study;
        } else {
            $case_study = "";
        }

        $data_arr = [
            "contract_no" => $data->contract_no,
            "template_id" => $template_id,
            "occ_level_id" => $str_occ_level_id,
            "desc_for_examier" => $data->desc_for_examier,
            "des_for_applicant" => $data->desc_for_applicant,
            "case_study" => $case_study,
            "template_type" => $str_template_type,
            "exam_type" => $str_exam_type,
            "criteria_used_byexamier" => $data->criteria_used_byexamier,
            "criteria_type_byexamier" => $str_criteria_type_byexamier,
            "created_date" => date('Y-m-d H:i:s'),
            "created_by" => $_SESSION["user_id"],
            "is_used" => '1',
            "tool_type" => $tool_type,
        ];

        $rs = $this->SharedModel->insert_template($data_arr);
        if ($rs) {
            $rs_qa_detail = $this->TemplatesModel->insert_qans_detail($template_id, $data->list);
        }

        $this->SharedModel->insert_user_log($action, $tool_type, $template_id, '', '');
        return 1;
    }

    //ปรับปรุงข้อมูล
    private function update_tp($template_id, $data, $action, $tool_type)
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

        if ($tool_type == "3" || $tool_type == "4") {
            $case_study = $data->case_study;
        } else {
            $case_study = "";
        }

        $data_update = [
            "contract_no" => $data->contract_no,
            "occ_level_id" => $str_occ_level_id,
            "desc_for_examier" => $data->desc_for_examier,
            "des_for_applicant" => $data->desc_for_applicant,
            "case_study" => $case_study,
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
            $chk_old_data = $this->TemplatesModel->isvalid_detail($template_id);
            if ($chk_old_data == '1') {
                $rs_tp_detail = $this->TemplatesModel->insert_qans_detail($template_id, $data->list);
            }
        }

        $this->SharedModel->insert_user_log($action, $tool_type, $template_id, '', '');
        return 1;
    }

    //ดูข้อสอบตัวใหม่ ที่ปรับแก้ให้เหมือนกับการนำข้อสอบไปใช้งาน
    public function new_preview()
    {
        $doc_filename = "";
        $tp_type = $this->SharedModel->get_blueprint($_GET['template_id']);
        $tool_type = $_GET['tool_type'];
        $doc_type = $_GET['doc_type'];

        $doc_filename = "";

        if ($tool_type == '3' || $tool_type == '4' || $tool_type == '5') {
            if ($doc_type == '1') { //1 คือ สำหรับผู้เข้ารับการประเมิน
                $doc_filename = "exam_used/longanswer/eoc";
            } else {
                $doc_filename = "exam_used/longanswer/eoc_assessor";
            }
        } else {
        }

        $this->preview_exam1($_GET['template_id'], $doc_filename, $_GET["tool_type"], $tp_type[0]->occ_level_id);
    }
    //ดูข้อสอบ
    public function preview()
    {
        $doc_filename = "";
        $tp_type = $this->SharedModel->get_blueprint($_GET['template_id']);

        if ($tp_type[0]->exam_type == "2" && $tp_type[0]->template_type == "3") {
            $doc_filename = "preview/qans_uoc";
        } else if ($tp_type[0]->exam_type == "3" && $tp_type[0]->template_type == "3") {
            $doc_filename = "preview/qans_eoc";
        } else {
        }

        $this->preview_exam($_GET['template_id'], $doc_filename, $_GET["tool_type"], $tp_type[0]->occ_level_id, '1');
    }

    public function exam_preview()
    {
        $doc_filename = "";
        $tp_type = $this->SharedModel->get_blueprint($_GET['template_id']);

        $doc_filename = "";
        if ($tp_type[0]->exam_type == "2" && $tp_type[0]->template_type == "3") {
            $doc_filename = "preview/print_html/qans_uoc";
        } else if ($tp_type[0]->exam_type == "3" && $tp_type[0]->template_type == "3") {
            $doc_filename = "preview/print_html/qans_eoc";
        }

        $this->print_html($_GET['template_id'], $doc_filename, $_GET["tool_type"], $tp_type[0]->occ_level_id);
    }

	public function exam_preview_html()
    {
        $doc_filename = "";
        $tp_type = $this->SharedModel->get_blueprint($_GET['template_id']);

        $doc_filename = "";
        if ($tp_type[0]->exam_type == "2" && $tp_type[0]->template_type == "3") {
            $doc_filename = "preview_html/qans_uoc";
        } else if ($tp_type[0]->exam_type == "3" && $tp_type[0]->template_type == "3") {
            $doc_filename = "preview_html/qans_eoc";
        }

        $this->print_html($_GET['template_id'], $doc_filename, $_GET["tool_type"], $tp_type[0]->occ_level_id);
    }
    //นำข้อสอบไปใช้งาน สำหรับผู้เข้ารับการประเมิน
    public function exam_used_new()
    {
        $doc_filename = "";
        $tp_type = $this->SharedModel->get_blueprint($_GET['template_id']);
        $tool_type = $_GET['tool_type'];
        $doc_type = $_GET['doc_type'];

        $doc_filename = "";

        if ($tool_type == '3' || $tool_type == '4' || $tool_type == '5') {
            if ($doc_type == '1') { //1 คือ สำหรับผู้เข้ารับการประเมิน
                $doc_filename = "exam_used/longanswer/eoc";
            } else {
                $doc_filename = "exam_used/longanswer/eoc_assessor";
            }
        } else {
        }

        $this->preview_exam1($_GET['template_id'], $doc_filename, $_GET["tool_type"], $tp_type[0]->occ_level_id);
    }

    private function preview_exam1($template_id, $doc_filename, $tool_type, $occ_level_id)
    {
        $data['result'] = $this->TemplatesModel->get_tp_preview($template_id);
        $data['rs_detail'] = $this->TemplatesModel->get_tp_detail_create_preview($template_id);
        $data['tool_typename'] = $this->SharedModel->get_tool_type_name($tool_type)['name'];
        $data['occ_levelname'] =  $this->SharedModel->get_occlevelname($occ_level_id)['levelName'];

        $mpdf = new mPDF('UTF-8', 'A4', '2', 'THSaraban', 15, 15, 5, 0, 0, 0);
		$mPdf->shrink_tables_to_fit = 1;

        $html =   $this->load->view("exam_used/explanation", $data, true);
        $server_name = $_SERVER['SERVER_NAME'];
        if (filter_var($server_name, FILTER_VALIDATE_IP)) {
            $html = str_replace($server_name, 'localhost', $html);
        }

        $explanation = $this->load->view($doc_filename, $data, true);

        /*if ($type == '2') {
            $mpdf->WriteHTML($html);
        }*/

        $mpdf->WriteHTML($explanation);
        $mpdf->Output();
        exit();
    }

    public function exam_used()
    {
        $doc_filename = "";
        $tp_type = $this->SharedModel->get_blueprint($_GET['template_id']);

        $doc_filename = "";
        if ($tp_type[0]->exam_type == "2" && $tp_type[0]->template_type == "3") {
            if ($_GET['tool_type'] == '6') {
                $doc_filename = "exam_used/observation/ob_qans_eoc";
            } else {
                $doc_filename = "exam_used/print_html/qans_uoc";

                //$doc_filename = "exam_used/qans_uoc";
            }
        } else if ($tp_type[0]->exam_type == "3" && $tp_type[0]->template_type == "3") {
            if ($_GET['tool_type'] == '6') {
                $doc_filename = "exam_used/observation/ob_qans_eoc";
            } else {
                $doc_filename = "exam_used/print_html/qans_eoc";
                // $doc_filename = "exam_used/qans_eoc";
            }
        }

        // $this->preview_exam($_GET['template_id'], $doc_filename, $_GET["tool_type"], $tp_type[0]->occ_level_id, '2');
        $this->print_html($_GET['template_id'], $doc_filename, $_GET["tool_type"], $tp_type[0]->occ_level_id);
    }

    //สำหรับผู้ประเมิน
    public function assessor_print()
    {
        $doc_filename = "";
        $tp_type = $this->SharedModel->get_blueprint($_GET['template_id']);

        $doc_filename = "";
        if ($tp_type[0]->exam_type == "2" && $tp_type[0]->template_type == "3") {
            if ($_GET['tool_type'] == '6') {
                $doc_filename = "exam_used/observation/ob_qans_eoc";
            } else {
                $doc_filename = "exam_used/print_html/qans_uoc_assessor";

                //$doc_filename = "exam_used/qans_uoc";
            }
        } else if ($tp_type[0]->exam_type == "3" && $tp_type[0]->template_type == "3") {
            if ($_GET['tool_type'] == '6') {
                $doc_filename = "exam_used/observation/ob_qans_eoc";
            } else {
                $doc_filename = "exam_used/print_html/qans_eoc_assessor";
                // $doc_filename = "exam_used/qans_eoc";
            }
        }

        // $this->preview_exam($_GET['template_id'], $doc_filename, $_GET["tool_type"], $tp_type[0]->occ_level_id, '2');
        $this->print_html($_GET['template_id'], $doc_filename, $_GET["tool_type"], $tp_type[0]->occ_level_id);
    }

    public function print_html($template_id, $doc_filename, $tool_type, $occ_level_id)
    {
        $data['result'] = $this->TemplatesModel->get_tp_preview($template_id);
        $data['rs_detail'] = $this->TemplatesModel->get_tp_detail($template_id);
        $data['tool_typename'] = $this->SharedModel->get_tool_type_name($tool_type)['name'];
        $data['occ_levelname'] =  $this->SharedModel->get_occlevelname($occ_level_id)['levelName'];
        $this->load->view($doc_filename, $data);
    }

    private function preview_exam($template_id, $doc_filename, $tool_type, $occ_level_id, $type)
    {
        $data['result'] = $this->TemplatesModel->get_tp_preview($template_id);
        $data['rs_detail'] = $this->TemplatesModel->get_tp_detail_create_preview($template_id);
        $data['tool_typename'] = $this->SharedModel->get_tool_type_name($tool_type)['name'];
        $data['occ_levelname'] =  $this->SharedModel->get_occlevelname($occ_level_id)['levelName'];

        //$mpdf = new mPDF('', 'legal', 20, 'Times', 15, 15, 16, 16);
        $mpdf = new mPDF('UTF-8', 'A4', '2', 'THSaraban', 15, 15, 5, 0, 0, 0);
        //$mpdf = new \Mpdf\Mpdf();
        //$this->load->view($doc_filename, $data, true);

        //  $stylesheet = file_get_contents('../../../../../assets/tp_new/css/bootstrap-grid.css');
        // $mpdf->WriteHTML($stylesheet, 1);

        $html =   $this->load->view("exam_used/explanation", $data, true);
        $server_name = $_SERVER['SERVER_NAME'];
        if (filter_var($server_name, FILTER_VALIDATE_IP)) {
            $html = str_replace($server_name, 'localhost', $html);
        }

        $explanation = $this->load->view($doc_filename, $data, true);

        if ($type == '2') {
            $mpdf->WriteHTML($html);
        }

        // $doc = new DOMDocument();
        // $doc->loadHTML(mb_convert_encoding($explanation, 'HTML-ENTITIES', 'UTF-8'));
        // $explanation = $this->checkLargeTables($doc);


        //$this->shrink_tables_to_fit = 1;
        // $this->useFixedNormalLineHeight = true;
        // $this->useFixedTextBaseline = true;
        // $this->normalLineheight = 1.33;
        // $mpdf->autoPageBreak = false;
        $mpdf->WriteHTML($explanation);


        // $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
        // $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
        $mpdf->Output();
        exit();
    }
}