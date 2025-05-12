<?php
class PersonAssessmentModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("/BaseModel");
    }

    //ดึงข้อมูลรายการประเมินของ user
    public function get_all($filter = array())
    {
        $condition = "";
        if ($filter["keyword"] != "") {
            $condition .= " AND (org.orgName LIKE '%" . $filter["keyword"] . "%'
                            OR a.occ_level_name LIKE '%" . $filter["keyword"] . "%'
                            OR b.exam_template_id LIKE '%" . $filter["keyword"] . "%') ";
        }

        if ($filter["ass_status"] != "") {
            if ($filter["ass_status"] == "0") {
                $condition_status = " = '0' ";
            } else {
                $condition_status = " > '0' ";
            }
            $condition .= "AND  (SELECT COUNT(*) FROM exam_person_portfolio WHERE app_id = a.app_id AND exam_schedule_id = b.tpqi_exam_no AND assessment_status ='1' ) " . $condition_status;
        }

        $sql = " SELECT a.*,b.asm_tool_type,b.exam_template_id, b.org_name,b.exam_schedule_id,b.tpqi_exam_no,
        b.start_date,b.end_date,
        (SELECT COUNT(*) FROM exam_person_portfolio WHERE app_id = a.app_id AND exam_schedule_id = b.tpqi_exam_no) as chk_upload,
        (SELECT COUNT(*) FROM exam_person_portfolio WHERE app_id = a.app_id AND exam_schedule_id = b.tpqi_exam_no AND assessment_status ='1' ) as chk_assessment
        FROM assessment_applicant as a
        LEFT JOIN exam_schedule as b ON  a.exam_schedule_id = b.tpqi_exam_no AND a.asm_tool_type = b.asm_tool_type
        WHERE a.citizen_id = '" . $_SESSION['citizen_id'] . "'
        AND b.asm_tool_type = '2' AND exam_template_id != ''  " . $condition;

        //print_r($sql);
        return $this->BaseModel->get_all_pagination($sql, $filter["page_no"], $filter["per_page"]);
    }
}