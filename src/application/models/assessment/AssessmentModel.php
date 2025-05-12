<?php
class AssessmentModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("/BaseModel");
    }

    //ดึงข้อมูลรายชื่อองค์กรที่จะประเมินผล โดยสถานะต้องผ่านการอนุมัติข้อสอบก่อน
    public function get_all($filter = array())
    {
        $condition = "";
        $status = "";
        // if($_SESSION["user_type"] == '3'){
        $filter['status'] = '7'; //อนุมัติข้อสอบแล้ว
        $condition = " WHERE e_sch.status = '" . $filter["status"] . "' ";
        //}
        if ($filter["keyword"] != "") {
            $condition .= " AND org_name LIKE '%" . $filter["keyword"] . "%'
                            OR e_sch.occ_level_name LIKE '%" . $filter["keyword"] . "%' ";
        }

        if ($filter["ass_status"] != "") {
            $condition .= " AND e_sch.assessment_status = '" . $filter["ass_status"] . "' ";
        }
        $sql = " SELECT *
                FROM exam_schedule e_sch " . $condition .
            " ORDER BY exam_schedule_id DESC";
        return $this->BaseModel->get_all_pagination($sql, $filter["page_no"], $filter["per_page"]);
    }

    public function get_applicant_assessment($filter = array())
    {
        $condition = "";
        if ($filter["keyword"] != "") {
            $condition .= "  AND  (concat(name,'',lastname) LIKE '%" . $filter["keyword"] . "%'
                            OR citizen_id LIKE '%" . $filter["keyword"] . "%' ) ";
        }

        if ($filter["assessment_status"] != "") {
            $condition .= " AND  assessment_applicant.assessment_status =  '" . $filter["assessment_status"] . "' ";
        }

        $sql = " SELECT * FROM assessment_applicant WHERE assessment_applicant.exam_schedule_id = '" . $filter["exam_schedule_id"] . "' 
        AND occ_level_id = '" . $filter["occ_level_id"] . "'
        AND asm_tool_type ='" . $filter["tool_type"] . "'" . $condition;

        //print_r($sql);
        return $this->BaseModel->get_all_pagination($sql, $filter["page_no"], $filter["per_page"]);
    }

    public function is_uploadevident($tpqi_exam_no, $app_id)
    {
        $sql = " SELECT * FROM exam_person_portfolio
                    WHERE exam_schedule_id = '" . $tpqi_exam_no . "'
                    AND app_id = '" . $app_id . "' ";
        $num_row = $this->BaseModel->get_num_rows($sql);
        return $num_row;
    }
}