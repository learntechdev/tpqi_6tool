<?php
class InterviewModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("/BaseModel");
    }

    public function get_tp_preview($template_id)
    {
        $sql = " SELECT * FROM exam_blueprint
                    WHERE template_id = '" . $template_id . "' ";
        return $this->BaseModel->get_all($sql);
    }

    public function get_tp_detail($template_id)
    {
        $sql = " SELECT * FROM tp_qans
                    WHERE 	template_id = '" . $template_id . "' ";
        return $this->BaseModel->get_all($sql);
    }

    public function get_pstd_uocname($uoc_code)
    {
        $sql = " SELECT * FROM standard_uoc WHERE uoc_id = '" . $uoc_code . "'";
        return $this->BaseModel->get_one_field($sql);
    }

    public function insert($data)
    {
        $result = $this->BaseModel->insert("exam_blueprint", $data);
        return $result;
    }

    public function insert_criteria_examier($data)
    {
        $result = $this->BaseModel->insert("exam_template_criteria_advise", $data);
        return $result;
    }

    public function insert_qans_detail($template_id, $json_q_detail)
    {
        $result = "";
		
        foreach ($json_q_detail as $uoc) {
            foreach ($uoc as $eoc) {
                foreach ($eoc as $item) {
                    if ($item->question != "") {
                        $arr_list = [
                            "template_id" => $template_id,
                            "uoc_code" => $item->uoc_code,
                            "eoc_code" => ($item->eoc_code == NULL || $item->eoc_code == "") ? "" : $item->eoc_code,
                            "question" => $item->question,
                            "guide_answer" => $item->answer,
                            "question_status" => $item->question_status,
						//	"scoretype" => $item->scoretype,
						//	"marks_for_q" => $item->marks_for_q,
						//	"uoc_selected" => $item->uoc_selected
                        ];

                        $result = $this->BaseModel->insert("tp_qans", $arr_list);
                        if ($result) {
                            $result = 1;
                        } else {
                            $result = 0;
                        }
                    }
					if($item->grpquestion != "") {
                        $arr_list = [
                            "template_id" => $template_id,
                            "uoc_code" => $item->uoc_code,
                            "eoc_code" => ($item->eoc_code == NULL || $item->eoc_code == "") ? "" : $item->eoc_code,
							"main_question_status" => $item->main_question_status,
							"grpquestion" => $item->grpquestion,
                            "question" => $item->g_question,
                            "guide_answer" => $item->g_answer,
                            "question_status" => $item->g_question_status,
							"scoretype" => $item->g_scoretype,
							"marks_for_q" => $item->g_marks_for_q,
							"uoc_selected" => $item->g_uoc_selected
                        ];

                        $result = $this->BaseModel->insert("tp_g_qans", $arr_list);
                        if ($result) {
                            $result = 1;
                        } else {
                            $result = 0;
                        }
                    }
                }
            }
        }
        return $result;
    }

    //ตรวจสอบในฐานข้อมูลว่ามีชุดข้อสอบนี้อยู่หรือไม่ ถ้ามีให้ลบออก
    public function isvalid_detail($template_id)
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

    //ดึงข้อมูลไปแสดงเพื่อแก้ไข (ถาม-ตอบ ตาม UOC)
    /*public function get_tp_detail_foredit($template_id, $uoc_code, $eoc_code, $asm_tool)
    {
        if ($asm_tool == '2') {
            $table = 'exam_demonstration_detail';
        } else if ($asm_tool == '3') {
            $table = 'exam_interview_detail';
        }

        $sql = " SELECT * FROM $table
                WHERE template_id = '" . $template_id . "'
                AND uoc_code = '" . $uoc_code . "'
                AND eoc_code = '" . $eoc_code . "'  ";
        return $this->BaseModel->get_all($sql);
    }*/


    //ดึงข้อมูลเทมเพลต
    public function get_template($template_id)
    {
        $sql = " SELECT * FROM exam_blueprint tp
                LEFT JOIN  exam_template_criteria_advise cri
                ON tp.template_id = cri.template_id
                WHERE tp.template_id = '" . $template_id . "' ";
        return $this->BaseModel->get_all($sql);
    }

    //ดึงข้อมูล pc และตรวจสอบว่ามีการบันทึกข้อมูลหรือยัง ถ้ามีแล้วให้ดึงมาแสดง
    public function fetch_pc($eoc_id, $template_id)
    {
        $sql = "";
        $sql_pc = " SELECT '' as template_detail_id, elementID, performanceDetailID,
                    performanceCriteria, '' as question, '' as guide_answer
                    FROM settings_performance_detail
                    WHERE elementID ='" . $eoc_id . "'";
        if ($template_id != "") {
            $ck_template_detail = " SELECT template_detail_id, eoc_code as elementID,pc_code as performanceDetailID,
            pc_detail as performanceCriteria,question,guide_answer  FROM exam_template_detail
                                        WHERE eoc_code = '" . $eoc_id . "'
                                        AND template_id = '" . $template_id . "' ";
            $num_row = $this->BaseModel->get_num_rows($ck_template_detail);
            if ($num_row > 0) {
                $sql = $ck_template_detail;
            } else {
                $sql = $sql_pc;
            }
        } else {
            $sql = $sql_pc;
        }
        //print_r($sql);
        return $this->BaseModel->get_all($sql);
    }

    //เช็คว่ามี uoc ของเทมเพลตนั้นๆ ในตารางหรือไม่
    public function ck_template_uoc($template_id, $uoc_code, $eoc_code, $asm_tool)
    {
        if ($asm_tool == '5') {
            $table = 'exam_demonstration_detail';
        } else if ($asm_tool == '3') {
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

    public function sendtemplate_approve($template_id)
    {
        $data = [
            "send_approve" => '1',
            "exam_status" => ""
        ];

        $condition = [
            "template_id" => $template_id,
        ];

        return $this->BaseModel->update("exam_blueprint", $data, $condition);
    }



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

    /* public function update_template_detail($data = [], $json_q_detail)
    {
        $str_template_id = $data["template_id"];
        $str_uoc_code = $data["uoc_code"];
        $result = "";

        foreach ($json_q_detail as $eoc) {
            foreach ($eoc as $item) {
                $condition = [
                    "template_detail_id" => $item->template_detail_id,
                ];
                $arr_list = [
                    "question" => $item->q,
                    "guide_answer" => $item->ans,
                ];

                if ($item->template_detail_id != "") { //มีข้อมูลให้ update
                    $result = $this->BaseModel->update("exam_template_detail", $arr_list, $condition);
                } else { //ยังไม่มีให้ insert
                    $arr_list = [
                        "template_id" => $str_template_id,
                        "uoc_code" => $str_uoc_code,
                        "eoc_code" => $item->eoccode,
                        "pc_code" => $item->pccode,
                        "pc_detail" => $item->pcdetail,
                        "question" => $item->q,
                        "guide_answer" => $item->ans,
                    ];
                    $result = $this->BaseModel->insert("exam_template_detail", $arr_list);

                }

                if ($result) {
                    $result = 1;
                } else {
                    $result = 0;
                }
            }
        }
    }*/

    // ดึงข้อมูลรายละเอียดข้อสอบแบบสัมภาษณ์
    public function get_template_detail($template_id)
    {
        $sql = " SELECT * FROM exam_interview_detail
                WHERE template_id = '" . $template_id . "' ";
        return $this->BaseModel->get_all($sql);
    }

    //--------------------- ประเมินผล --------------------
    public function is_valid_assessment($exam_schedule_id, $app_id, $tool_type)
    {
        $sql = " SELECT * FROM assessment
                WHERE exam_schedule_id	 = '" . $exam_schedule_id . "'
                AND app_id = '" . $app_id . "'
                AND tool_type = '" . $tool_type . "' ";
        $str_assessment_id = $this->BaseModel->get_one_field($sql);
        $num_row = $this->BaseModel->get_num_rows($sql);
        if ($num_row > 0) {
            $condition = [
                "exam_schedule_id" => $exam_schedule_id,
                "app_id" => $app_id,
                "tool_type" => $tool_type,
            ];
            $rs = $this->BaseModel->delete("assessment", $condition);
            if ($rs) {
                $rs1 = $this->BaseModel->delete("assessment_detail_interview", ["assessment_id" => $str_assessment_id["assessment_id"]]);
                return 1;
            } else {
                return 0;
            }
        } else {
            return 1;
        }
    }

    public function insert_assessment($assessment, $json_ass_detail)
    {
        $assessment_id = "";
        $this->db->trans_begin();
        $this->db->insert('assessment', $assessment);
        $assessment_id = $this->db->insert_id();
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return (0);
        } else {
            $this->db->trans_commit();
        }

        if ($assessment_id != "") {
            foreach ($json_ass_detail as $uoc) {
                foreach ($uoc as $item) {
                    $arr_list = [
                        "app_id" => $assessment["app_id"],
                        "uoc_code" => $item->uoc_code,
                        "order_line" => $item->order_line,
                        "score" => $item->score,
                        "answer" => $item->answer,
                        "assessment_id" => $assessment_id,
                    ];
                    $rs = $this->BaseModel->insert("assessment_detail_interview", $arr_list);
                }
            }

            if ($rs) {
                $rs = $this->update_assessment_applicant(
                    $assessment["app_id"],
                    $assessment["exam_schedule_id"]
                );
                return 1;
            } else {
                return 0;
            }
        }
    }

    //ปรับปรุงสถานะการประเมินของบุคคลนั้นๆ
    public function update_assessment_applicant($app_id, $exam_schedule_id)
    {
        $data = [
            "assessment_status" => '1',
            "confirm_ass_status" => '1'
        ];

        $condition = [
            "app_id" => $app_id,
            "exam_schedule_id" => $exam_schedule_id,
        ];
        return $this->BaseModel->update("assessment_applicant", $data, $condition);
    }
}