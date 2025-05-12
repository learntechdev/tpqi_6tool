<?php
class PortfolioExamModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("/BaseModel");
    }

    public function insert($data)
    {
        $result = $this->BaseModel->insert("exam_person_portfolio", $data);
        return $result;
    }

    public function getTemplateDetail($filter)
    {
        $blueprint_id = $filter['template'];
        $exam_schedule_id = $filter['exam_schedule_id'];
        $app_id = $filter['app_id'];
        $action = $filter['action'];
        $result_array = "";
        /* echo $action;
        echo "=>";
        echo $filter['template_type'];*/
        if ($filter['template_type'] == '1') { //ตาม uoc & เฉพาะหัวข้อหลัก
            $sql = "";
            if ($action == "create") {
                $sql = " SELECT * FROM tp_checklist
                            WHERE blueprint_id = '" . $blueprint_id . "'
                            AND question_status = '1'
                            ORDER BY uoc_code ASC ";
            } else {
                $sql = " SELECT tp.* ,epp.file,epp.app_id
                FROM tp_checklist as tp
                LEFT JOIN exam_person_portfolio as epp
                ON tp.blueprint_id = epp.blueprint_id
                AND tp.id = epp.tp_checklist_id
                WHERE tp.blueprint_id = '" . $blueprint_id . "'
                AND epp.app_id = '" . $app_id . "'
                AND epp.exam_schedule_id = '" . $exam_schedule_id . "'
                GROUP BY epp.id ";
            }
            $result = $this->db->query($sql);
            $result_array = $result->result();

            //print_r($sql);
        } else if ($filter['template_type'] == '2') { //ตามคุณวุฒิ & หัวข้อหลัก-ย่อย
            if ($action == 'create') {
                $sql = "SELECT *,tp_checklist_subtopic.id as subtopic_id FROM tp_checklist_maintopic
                LEFT JOIN tp_checklist_subtopic
                ON tp_checklist_subtopic.maintopic_id =tp_checklist_maintopic.id
                WHERE blueprint_id ='" . $blueprint_id . "' ";
            } else {
                $sql = "SELECT epp.app_id,epp.tp_order_line as order_line,tcm.maintopic,tcs.subtopic,epp.blueprint_id,epp.id,epp.maintopic_id,epp.subtopic_id,epp.file
                FROM exam_person_portfolio  as epp
                LEFT JOIN tp_checklist_maintopic as tcm
                ON tcm.id = epp.maintopic_id
                LEFT JOIN tp_checklist_subtopic as tcs
                ON tcs.id = epp.subtopic_id
                WHERE epp.blueprint_id = '" . $blueprint_id . "'
                AND epp.exam_schedule_id = '" . $exam_schedule_id . "'
                AND epp.app_id ='" . $app_id . "' ";
            }
            // print_r($sql);
            $result = $this->db->query($sql);
            $result_array = $result->result();
        }


        return $result_array;
    }

    public function insertPersonAssessmentFile($data)
    {
        $result = $this->BaseModel->insert("exam_person_portfolio", $data);
        return $result;
    }

    public function deletePersonAssessmentFile($condition)
    {

        $result = $this->BaseModel->delete("exam_person_portfolio", $condition);
        return $result;
    }

    public function updatePersonAssessmentFile($data, $condition)
    {
        $result = $this->BaseModel->update("exam_person_portfolio", $data, $condition);
        return $result;
    }
}