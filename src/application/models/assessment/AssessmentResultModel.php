<?php
class AssessmentResultModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("/BaseModel");
    }

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
                $rs1 = $this->BaseModel->delete("assessment_detail", ["assessment_id" => $str_assessment_id["assessment_id"]]);
                return 1;
            } else {
                return 0;
            }
        } else {
            return 1;
        }
    }

    public function insert_ass_result($assessment, $json_ass_detail, $tool_type)
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
                foreach ($uoc as $eoc) {
                    foreach ($eoc as $item) {
                        $str_ans = '';
                        if ($tool_type == '5') {
                            $str_ans = '';
                        } else {
                            $str_ans = $item->answer;
                        }

                        $arr_list = [
                            "app_id" => $assessment["app_id"],
                            "uoc_code" => $item->uoc_code,
                            "eoc_code" => ($item->eoc_code == NULL || $item->eoc_code == "") ? "" : $item->eoc_code,
                            // "order_line" => $item->order_line,
                            "score" => $item->score,
                            "answer" => $str_ans,
                            "assessment_id" => $assessment_id,
                            "template_detail_id" => $item->template_detail_id
                        ];

                        $rs = $this->BaseModel->insert("assessment_detail", $arr_list);
                    }
                }
            }

            $arr_rs = [];
            if ($rs) {
                $rs = $this->update_assessment_applicant(
                    $assessment["app_id"],
                    $assessment["exam_schedule_id"],
                    $tool_type
                );
                $arr_rs = [
                    "assessment_id" => $assessment_id,
                    "status" => 1,
                ];
            } else {
                $arr_rs = [
                    "assessment_id" => '',
                    "status" => 0,
                ];
            }
            return $arr_rs;
        }
    }

    //ปรับปรุงสถานะการประเมินของบุคคลนั้นๆ
    public function update_assessment_applicant($app_id, $exam_schedule_id, $tool_type)
    {
        $data = [
            "assessment_status" => '1',
            "confirm_ass_status" => '1'
        ];

        $condition = [
            "app_id" => $app_id,
            "exam_schedule_id" => $exam_schedule_id,
            "asm_tool_type" => $tool_type
        ];
        return $this->BaseModel->update("assessment_applicant", $data, $condition);
    }

    public function getAssResultDetail($tpqi_exam_no, $tool_type, $app_id, $template_id)
    {
        $sql = " SELECT * FROM assessment 
                    WHERE exam_schedule_id = '" . $tpqi_exam_no . "'
                 AND tool_type = '" . $tool_type . "'
                 AND app_id = '" . $app_id . "' ";

        /*  $sql = " SELECT ass.*, sch.exam_template_id 
                FROM assessment ass 
                LEFT JOIN exam_schedule sch 
                ON (ass.exam_schedule_id = sch.tpqi_exam_no AND ass.tool_type = sch.asm_tool_type) 
                WHERE ass.app_id = '" . $app_id . "' 
                AND ass.exam_schedule_id = '" . $tpqi_exam_no . "' 
                AND ass.tool_type = '" . $tool_type . "' ";
                */

        //print_r($sql);
        $assResult = $this->BaseModel->get_all_rowarr($sql);
        $num_row = $this->BaseModel->get_num_rows($sql);

        $rs = [];
        if ($num_row > 0) {
            $strDetail = "";
            $strEvident = "";
            if ($tool_type == '3') {
                $strDetail = $this->getAssByQAInterview($assResult["assessment_id"]);
                $strEvident = null;
            } else {
                $strDetail = $this->getAssByQALongAns($assResult["assessment_id"]);
                $strEvident = $this->getEvident($assResult["assessment_id"], $tool_type);
            }

            $rs = [
                "result" => $assResult,
                "resultDetail" =>  $strDetail,
                "evident" =>  $strEvident
            ];
        } else {
            $rs = [
                "result" => null,
                "resultDetail" => null,
                "evident" => null
            ];
        }

        return $rs;
    }

    private function getAssByQALongAns($assID)
    {
        $sql = " SELECT ass_dt.*, q.question, q.guide_answer,q.template_detail_id
         FROM assessment_detail ass_dt
            LEFT JOIN tp_qans q 
                ON ass_dt.template_detail_id = q.template_detail_id
            WHERE assessment_id = '" . $assID . "'
            ORDER BY ass_dt.uoc_code ASC";

        $qa = $this->BaseModel->get_all($sql);
        $num_row = $this->BaseModel->get_num_rows($sql);
        if ($num_row > 0) {
            return $qa;
        } else {
            return null;
        }
    }

    private function getEvident($assID, $toolType)
    {
        $tbName = "";
        if ($toolType == '5') {
            $tbName = " assessment_detail_demonstration_file ";
        } else if ($toolType == '4') {
            $tbName = " assessment_detail_simulation_file ";
        }

        $sql = " SELECT * FROM $tbName WHERE assessment_id = '" . $assID . "' ";

        $rs = $this->BaseModel->get_all($sql);
        $num_row = $this->BaseModel->get_num_rows($sql);
        if ($num_row > 0) {
            return $rs;
        } else {
            return null;
        }
    }

    public function getAssByQAInterview($assID)
    {
        $sql = " SELECT ass_dt.*, q.question, q.guide_answer,q.template_detail_id,
        evd.filename
         FROM assessment_detail ass_dt
            LEFT JOIN tp_qans q 
                ON ass_dt.template_detail_id = q.template_detail_id
            LEFT JOIN assessment_upload_files evd
                ON (ass_dt.template_detail_id = evd.template_detail_id 
                    AND evd.app_id = ass_dt.app_id)
            WHERE assessment_id = '" . $assID . "'
            ORDER BY ass_dt.uoc_code ASC";

        $qa = $this->BaseModel->get_all($sql);
        $num_row = $this->BaseModel->get_num_rows($sql);
        if ($num_row > 0) {
            return $qa;
        } else {
            return null;
        }
    }
}