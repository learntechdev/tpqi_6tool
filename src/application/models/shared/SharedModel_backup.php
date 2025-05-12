<?php
class SharedModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("/BaseModel");
    }

    public function layouts($view, $data)
    {
        $this->UIModel->header();
        $this->load->view($view, $data);
        $this->UIModel->footer();
    }

    public function get_tool_type_name($tool_type)
    {
        $arr_data = $this->MasterDataModel->tool_type_array();
        $arr = [
            "id" => $arr_data[$tool_type]["tool_type"],
            "name" => $arr_data[$tool_type]["name"],
            "name_eng" => $arr_data[$tool_type]["name_eng"],
        ];
        return $arr;
    }

    public function get_pstd_uocname($uoc_code)
    {
        $sql = " SELECT * FROM v_pstd_uoc WHERE stdID = '" . $uoc_code . "' ";
        return $this->BaseModel->get_one_field($sql);
    }

    public function get_template_type($template_type)
    {
        $sql = " SELECT * FROM settings_template_type
                    WHERE id = '" . $template_type . "' ";
        return $this->BaseModel->get_one_field($sql);
    }

    public function get_exam_type($exam_type)
    {
        $sql = " SELECT * FROM settings_exam_type
                    WHERE id = '" . $exam_type . "' ";
        return $this->BaseModel->get_one_field($sql);
    }

    public function get_occlevelname($occ_level_id)
    {
        $sql = " SELECT id, concat(tier1_title,' ', tier2_title,' ', tier3_title,' ', level_name) as levelName
        FROM standard_qualification
        WHERE id = '" . $occ_level_id . "' ";
        return $this->BaseModel->get_one_field($sql);
    }

    public function insert_template($data)
    {
        $result = $this->BaseModel->insert("exam_blueprint", $data);
        return $result;
    }

    public function insert_criteria_examier($data)
    {
        $result = $this->BaseModel->insert("exam_template_criteria_advise", $data);
        return $result;
    }

    public function delete_template($tp_id)
    {
        $data = [
            "is_used" => '0',
        ];

        $condition = [
            "template_id" => $tp_id,
        ];

        return $this->BaseModel->update("exam_blueprint", $data, $condition);
    }

    //ตรวจสอบว่ามีชุดข้อสอบอยู่ในฐานข้อมูลหรือยัง
    public function isvalid_exam_blueprint($template_id)
    {
        $sql = " SELECT * FROM exam_blueprint
                    WHERE template_id = '" . $template_id . "' ";

        $num_row = $this->BaseModel->get_num_rows($sql);
        return $num_row;
    }

    /* public function sendtemplate_approve($template_id)
    {
    $data = [
    "send_approve" => '1',
    ];

    $condition = [
    "template_id" => $template_id,
    ];

    return $this->BaseModel->update("exam_blueprint", $data, $condition);
    }*/

    public function update_template($template_id, $data)
    {
        $condition = [
            "template_id" => $template_id,
        ];

        return $this->BaseModel->update("exam_blueprint", $data, $condition);
    }

    public function update_criteria_examier($template_id, $data)
    {
        $condition = [
            "template_id" => $template_id,
        ];

        return $this->BaseModel->update("exam_template_criteria_advise", $data, $condition);
    }

    // ดึงข้อมูลเทมเพลต
    public function get_blueprint($template_id)
    {
        $sql = " SELECT * FROM exam_blueprint
                    WHERE template_id = '" . $template_id . "' ";
        return $this->BaseModel->get_all($sql);
    }

    public function get_template_preview($template_id)
    {
        $sql = " SELECT blueprint.* , advise.* FROM exam_blueprint blueprint
                LEFT JOIN exam_template_criteria_advise advise
                ON blueprint.template_id = advise.template_id
                WHERE blueprint.template_id = '" . $template_id . "' ";

        return $this->BaseModel->get_all($sql);
    }

    public function get_template($template_id)
    {
        $sql = "  SELECT exam_sch.*,
        tp.desc_for_examier, tp.des_for_applicant,tp.case_study,tp.criteria_used_byexamier, tp.criteria_type_byexamier,
        tp.exam_time,tp.exam_type,tp.template_type,
        exam_cri.exam_percent_score,
        setting_ct.title, setting_ct.description,
        setting_ct.min_score, setting_ct.max_score
         FROM exam_schedule exam_sch
                    LEFT JOIN exam_blueprint tp
                    ON exam_sch.exam_template_id = tp.template_id
                    LEFT JOIN exam_criteria exam_cri
                    ON exam_sch.exam_schedule_id = exam_cri.exam_schedule_id
                    LEFT JOIN settings_criteria_advise_type setting_ct
                    ON setting_ct.criteria_type_id = tp.criteria_used_byexamier
                WHERE tp.template_id = '" . $template_id . "' ";

        // print_r($sql);
        return $this->BaseModel->get_all($sql);
    }

    // ป้องกันกรณี หลายรอบสอบใช้ เทมเพลตตัวเดียวกัน
    public function get_template_new($template_id, $tpqi_exam_no)
    {
        $sql = "  SELECT exam_sch.*,
        tp.desc_for_examier, tp.des_for_applicant,tp.case_study,tp.criteria_used_byexamier, tp.criteria_type_byexamier,
        tp.exam_time,tp.exam_type,tp.template_type,
        exam_cri.exam_percent_score,
        setting_ct.title, setting_ct.description,
        setting_ct.min_score, setting_ct.max_score
         FROM exam_schedule exam_sch
                    LEFT JOIN exam_blueprint tp
                    ON exam_sch.exam_template_id = tp.template_id
                    LEFT JOIN exam_criteria exam_cri
                    ON exam_sch.exam_schedule_id = exam_cri.exam_schedule_id
                    LEFT JOIN settings_criteria_advise_type setting_ct
                    ON setting_ct.criteria_type_id = tp.criteria_used_byexamier
                WHERE tp.template_id = '" . $template_id . "'
                AND exam_sch.tpqi_exam_no = '" . $tpqi_exam_no . "' ";

        // print_r($sql);
        return $this->BaseModel->get_all($sql);
    }

    public function get_template_forexam($template_id, $exam_sch_id)
    {
        $sql = "  SELECT * FROM exam_schedule exam_sch
                    LEFT JOIN exam_blueprint tp
                    ON exam_sch.exam_template_id = tp.template_id
                    LEFT JOIN exam_criteria exam_cri
                    ON  exam_sch.exam_schedule_id = exam_cri.exam_schedule_id

                    LEFT JOIN settings_criteria_advise_type setting_ct
                    ON setting_ct.criteria_type_id = tp.criteria_used_byexamier
                WHERE tp.template_id = '" . $template_id . "'
                AND exam_sch.exam_schedule_id = '" . $exam_sch_id . "' ";

        // print_r($sql);
        return $this->BaseModel->get_all($sql);
    }

    public function get_template_forass($exam_sch, $tool_type, $occ_level_id)
    {
        /*$sql = "  SELECT * FROM exam_schedule exam_sch
        LEFT JOIN exam_blueprint tp
        ON exam_sch.exam_template_id = tp.template_id
        LEFT JOIN exam_criteria c_exam
        ON exam_sch.exam_schedule_id = c_exam.exam_schedule_id
        LEFT JOIN settings_criteria_advise_type setting_ct
        ON setting_ct.criteria_type_id = tp.criteria_used_byexamier
        WHERE exam_sch.status = '7'
        AND exam_sch.tpqi_exam_no = '" . $exam_sch . "'
        AND exam_sch.asm_tool_type = '" . $tool_type . "' ";
         */
        $sql = " SELECT exam_sch.*,
        tp.desc_for_examier, tp.des_for_applicant,tp.case_study,tp.criteria_used_byexamier, tp.criteria_type_byexamier,
        tp.exam_time,tp.exam_type,tp.template_type,
        exam_cri.exam_percent_score,
        setting_ct.title, setting_ct.description,
        setting_ct.min_score, setting_ct.max_score
         FROM exam_schedule exam_sch
                    LEFT JOIN exam_blueprint tp
                    ON exam_sch.exam_template_id = tp.template_id
                    LEFT JOIN exam_criteria exam_cri
                    ON exam_sch.exam_schedule_id = exam_cri.exam_schedule_id
                    LEFT JOIN settings_criteria_advise_type setting_ct
                    ON setting_ct.criteria_type_id = tp.criteria_type_byexamier
        WHERE exam_sch.status = '7'
        AND exam_sch.tpqi_exam_no = '" . $exam_sch . "'
        AND exam_sch.occ_level_id = '" . $occ_level_id . "'
        AND exam_sch.asm_tool_type = '" . $tool_type . "' ";

        //print_r($sql);
        return $this->BaseModel->get_all($sql);
    }

    public function get_uocname($uoc_code)
    {
        $sql = " SELECT * FROM standard_uoc WHERE uoc_id = '" . $uoc_code . "' limit 0,1 ";
        return $this->BaseModel->get_one_field($sql);
    }

    public function get_eocname($eoc_code)
    {
        $sql = " SELECT * FROM standard_eoc WHERE eoc_id = '" . $eoc_code . "' ";
        return $this->BaseModel->get_one_field($sql);
    }

    public function confirm_applicant_assessment($exam_schedule_id, $app_id)
    {
        $data = [
            "confirm_ass_status" => '1',
        ];

        $condition = [
            "exam_schedule_id" => $exam_schedule_id,
            "app_id" => $app_id,
        ];

        return $this->BaseModel->update("assessment_applicant", $data, $condition);
    }

    //ดึงข้อมูลประเภทการกำหนดเกณฑ์สำหรับการประเมิน
    public function get_criteria_advise_type($criteria_type_id)
    {
        $sql = " SELECT * FROM settings_criteria_advise_type WHERE criteria_type_id = '" . $criteria_type_id . "' ";
        return $this->BaseModel->get_one_field($sql);
    }

    //เช็คว่ามี uoc ของเทมเพลตนั้นๆ ในตารางหรือไม่
    public function ck_template_uoc($template_id, $uoc_code, $eoc_code, $asm_tool)
    {
        /* if ($asm_tool == '5') {
        $table = 'exam_demonstration_detail';
        } else if ($asm_tool == "3" || $asm_tool == "4" || $asm_tool == "6") {
        $table = 'tp_qans';
        }*/

        if ($asm_tool == '5') {
            $table = 'exam_demonstration_detail';
        } else {
            $table = 'tp_qans';
        }

        $condition = "";
        if (!empty($eoc_code)) {
            $condition = "  AND eoc_code = '" . $eoc_code . "' ";
        }

        $sql = " SELECT * FROM $table
                     WHERE uoc_code = '" . $uoc_code . "'
                     AND template_id = '" . $template_id . "' " . $condition;

        $num_row = $this->BaseModel->get_num_rows($sql);
        if ($num_row > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    // ดึงข้อมูลเกณฑ์ที่ผู้ออกข้อสอบแนะนำ
    public function get_criteria_advise($template_id)
    {
        $sql = " SELECT *
                 FROM exam_blueprint b
                LEFT JOIN  settings_criteria_advise_type t
                ON b.criteria_type_byexamier  = t.criteria_type_id
                WHERE b.template_id = '" . $template_id . "' ";

        $num_row = $this->BaseModel->get_num_rows($sql);

        if ($num_row > 0) {
            return $this->BaseModel->get_all($sql);
        } else {
            return 0;
        }

        // return $this->BaseModel->get_all_rowarr($sql);
    }
    // ดึงข้อมูลรายละเอียดเกณฑ์การประเมินนที่ผู้ออกข้อสอบแนะนำ
    public function get_criteria_detail($criteria_type_id)
    {
        $sql = " SELECT * FROM settings_criteria_advise_type
                    WHERE criteria_type_id = '" . $criteria_type_id . "' ";
        return $this->BaseModel->get_all($sql);
    }

    //บันทึก log การใช้งานระบบ
    public function insert_user_log($action, $menu_name, $template_id, $status, $exam_schedule_id)
    {
        $user_log = [
            "action_by" => $_SESSION["user_id"],
            "action" => $action,
            "date_action" => date('Y-m-d H:i:s'),
            "menu_name" => $menu_name,
            "template_id" => $template_id,
            "status" => $status,
            "exam_schedule_id" => $exam_schedule_id,
        ];

        return $this->BaseModel->insert("user_log", $user_log);
    }

    //บันทึกคำถามแบบ checklist ที่มีเฉพาะหัวข้อหลัก ตาม uoc
    public function insert_chklist_uoc_maintopic($tool_type, $template_id, $json_q_detail)
    {
		$result = 0;
        foreach ($json_q_detail as $uoc) {
            foreach ($uoc as $item) {
                if ($item->topic != "") {
                    $arr_list = [
                        "tool_type" => $tool_type,
                        "uoc_code" => $item->uoc_code,
                        "main_topic" => $item->topic,
                        "question_status" => $item->question_status,
                        "blueprint_id" => $template_id,
                        "created_date" => date('Y-m-d H:i:s'),
                        "created_by" => $_SESSION["user_id"],
                    ];

                    $result = $this->BaseModel->insert("tp_checklist", $arr_list);
                    if ($result) {
                        $result = 1;
                    } else {
                        $result = 0;
                    }
                }
            }
        }
        return $result;
    }

    public function chk_template_uoc($template_id, $uoc_code)
    {

        $sql = " SELECT * FROM tp_checklist
        WHERE uoc_code = '" . $uoc_code . "'
        AND blueprint_id = '" . $template_id . "' ";
        $num_row = $this->BaseModel->get_num_rows($sql);
        if ($num_row > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    //เช็คเทมเพลตแบบถาม-ตอบ
    public function chk_tp_uoc_qans($template_id, $uoc_id)
    {

        $sql = " SELECT * FROM tp_qans
        WHERE uoc_code = '" . $uoc_id . "'
        AND template_id = '" . $template_id . "' ";
        $num_row = $this->BaseModel->get_num_rows($sql);
        if ($num_row > 0) {
            return 1;
        } else {
            return 0;
        }
        // print_r($sql);
    }

    //ตรวจสอบในฐานข้อมูลว่ามีชุดข้อสอบนี้อยู่หรือไม่ ถ้ามีให้ลบออก
    public function isvalid_tpdetail_uoc($template_id)
    {
        $sql = " SELECT * FROM tp_checklist
                    WHERE blueprint_id	 = '" . $template_id . "' ";

        $num_row = $this->BaseModel->get_num_rows($sql);
        if ($num_row > 0) {
            $condition = ["blueprint_id	" => $template_id];
            $rs = $this->BaseModel->delete("tp_checklist", $condition);
            return 1;
        } else {
            return 0;
        }
    }

    //ดึงข้อมูลไปแสดงเพื่อแก้ไข (checklist ตาม UOC)
    public function get_tpdetail_foredit($template_id, $uoc_code)
    {
        $sql = " SELECT * FROM tp_checklist
                WHERE blueprint_id = '" . $template_id . "'
                AND uoc_code = '" . $uoc_code . "' ";
        return $this->BaseModel->get_all($sql);
    }

    //ดึงข้อมูลคำถามแบบ checklist ตาม uoc
    public function get_chklist_uoc($template_id)
    {
        $sql = " SELECT * FROM tp_checklist
                WHERE blueprint_id = '" . $template_id . "'
                AND question_status = '1' ";
        return $this->BaseModel->get_all($sql);
    }

    //ดึงข้อมูลคำถามแบบ checklist ตาม uoc สำหรับ preview
    public function get_chklist_uoc_preview($template_id)
    {
        $sql = " SELECT * FROM tp_checklist
                WHERE blueprint_id = '" . $template_id . "' ";
        return $this->BaseModel->get_all($sql);
    }

    //บันทึกข้อมูลคำถาม-แนวทางคำตอบ  (ตาม uoc)
    public function insert_qans_detail($template_id, $json_q_detail)
    {
        $result = "";
        foreach ($json_q_detail as $uoc) {
            foreach ($uoc as $item) {
                if ($item->question != "") {
                    $arr_list = [
                        "template_id" => $template_id,
                        "uoc_code" => $item->uoc_code,
                        "question" => $item->question,
                        "guide_answer" => $item->answer,
                        "question_status" => $item->question_status,
                    ];

                    $result = $this->BaseModel->insert("tp_qans", $arr_list);
                    if ($result) {
                        $result = 1;
                    } else {
                        $result = 0;
                    }
                }
            }
        }
        return $result;
    }

    //ตรวจสอบในฐานข้อมูลว่ามีชุดข้อสอบนี้อยู่หรือไม่ ถ้ามีให้ลบออก
    public function isvalid_qans_uoc($template_id)
    {
        $sql = " SELECT * FROM tp_qans
                    WHERE template_id	 = '" . $template_id . "' ";

        $num_row = $this->BaseModel->get_num_rows($sql);
        if ($num_row > 0) {
            $condition = ["template_id	" => $template_id];
            $rs = $this->BaseModel->delete("tp_qans", $condition);
            return 1;
        } else {
            return 0;
        }
    }

    public function get_tp_detail_foredit($template_id, $uoc_code, $eoc_code, $asm_tool)
    {
        if ($asm_tool == '3' || $asm_tool == '4' || $asm_tool == '5' || $asm_tool == "6") {
            $table = "tp_qans";
        }

        $sql = " SELECT * FROM tp_qans
                WHERE template_id = '" . $template_id . "'
                AND uoc_code = '" . $uoc_code . "'
                AND eoc_code = '" . $eoc_code . "' ";
        return $this->BaseModel->get_all($sql);
    }

    //ดึงข้อมูลคำถามแบบ question-ans ตาม uoc
    public function get_qans($template_id)
    {
        $sql = " SELECT * FROM tp_qans
                WHERE template_id = '" . $template_id . "'
                AND question_status = '1' ";
        return $this->BaseModel->get_all($sql);
    }

    //ดึงข้อมูลคำถามแบบ question-ans ตาม uoc สำหรับ preview (ดึงทุกสถานะ)
    public function get_qans_preview($template_id)
    {
        $sql = " SELECT * FROM tp_qans
                WHERE template_id = '" . $template_id . "' ";
        return $this->BaseModel->get_all($sql);
    }

    public function sendtemplate_approve($template_id)
    {
        $data = [
            "send_approve" => '1',
            "exam_status" => "",
        ];

        $condition = [
            "template_id" => $template_id,
        ];

        return $this->BaseModel->update("exam_blueprint", $data, $condition);
    }

    //บันทึกไฟลืเพิ่มเติมสำหรับใช้สอบ
    public function insert_docs_forexam($template_id, $filename)
    {
        $chk_files = $this->isvalid_files($template_id, $filename);

        $data = [
            "created_date" => date('Y-m-d H:i:s'),
            "docs_filename" => $filename,
            "template_id" => $template_id,
        ];

        return $this->BaseModel->insert("docs_forexam", $data);
    }

    public function isvalid_files($template_id, $filename)
    {
        $sql = " SELECT * FROM docs_forexam
        WHERE template_id	 = '" . $template_id . "'
        AND docs_filename = '" . $filename . "' ";

        $num_row = $this->BaseModel->get_num_rows($sql);
        if ($num_row > 0) {
            $condition = ["template_id	" => $template_id];
            $rs = $this->BaseModel->delete("docs_forexam", $condition);
            return 1;
        } else {
            return 0;
        }
    }

    // ดึงไฟล์เอกสารเพิ่มเติมสำหรับการสอบ
    public function getDocsFiles($template_id)
    {
        $sql = " SELECT * FROM docs_forexam
        WHERE template_id	 = '" . $template_id . "' ";

        $num_row = $this->BaseModel->get_num_rows($sql);

        if ($num_row > 0) {
            return $this->BaseModel->get_all($sql);
        } else {
            return 0;
        }
    }
}