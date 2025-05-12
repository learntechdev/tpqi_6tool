<?php
class ExamModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("/BaseModel");
    }

    //แสดงข้อมูลข้อสอบที่จะนำไปใช้งาน
    public function get_examforexaminee($filter = array())
    {
        $condition = "";
        $condition = " WHERE status = '7' "; //status='7' อนุมัติข้อสอบ
        if ($filter["keyword"] != "") {
            $condition .= " AND org_name LIKE '%" . $filter["keyword"] . "%'
                            OR occ_level_name LIKE '%" . $filter["keyword"] . "%' ";
        }

        if ($filter["tool_type"] != "0" && $filter["tool_type"] != "") {
            $condition .= " AND  asm_tool_type = '" . $filter["tool_type"] . "' ";
        }

        if ($filter["exam_used"] != "") {
            $condition .= " AND exam_used = '" . $filter["exam_used"] . "' ";
        }

		
        $sql = " SELECT * FROM exam_schedule" . $condition .
            " ORDER BY exam_schedule_id DESC ";
			
			
        return $this->BaseModel->get_all_pagination($sql, $filter["page_no"], $filter["per_page"]);
    }

    //เมื่อกด print ให้อัพเดตสถานะของข้อสอบว่าถูกใช้งานแล้ว
    public function update_exam_status($template_id, $exam_schedule_id)
    {
        $data = ["exam_used" => '1'];
        $condition = [
            "exam_template_id" => $template_id,
            "exam_schedule_id" => $exam_schedule_id
        ];

        return $this->BaseModel->update("exam_schedule", $data, $condition);
    }
}