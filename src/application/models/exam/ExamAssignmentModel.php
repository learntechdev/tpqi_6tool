<?php
class ExamAssignmentModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("/BaseModel");
    }

    //บันทึก สร้างงานออกข้อสอบ
    public function insert($data)
    {
        $result = $this->BaseModel->insert("exam_assignment", $data);
        return $result;
    }

    public function delete($exam_assign_id)
    {
        $data = ["is_used" => '0',];
        $condition = ["exam_assign_id" => $exam_assign_id,];
        return $this->BaseModel->update("exam_assignment", $data, $condition);
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

    public function get_all($filter = array())
    {
        $sql = " SELECT * FROM exam_assignment ";
		$condition = " WHERE is_used = '1' ";

        //print_r($sql);
		if (isset($filter) && isset($filter["keyword"])  && $filter["keyword"] != "") {
            $condition .= " AND contract_no LIKE '%" . $filter["keyword"] . "%'
                            OR project_name LIKE '%" . $filter["keyword"] . "%' ";
        }
		  $sql = "  SELECT * FROM exam_assignment" . $condition .
            " ORDER BY created_date DESC";

        return $this->BaseModel->get_all_pagination($sql, $filter["page_no"], $filter["per_page"]);
    }

    //ดึงข้อมูลขึ้นมาแก้ไข
    public function get_foredit($exam_assign_id)
    {
        $sql = " SELECT * FROM exam_assignment
        WHERE exam_assign_id = '" . $exam_assign_id . "' ";

        $num_row = $this->BaseModel->get_num_rows($sql);
        if ($num_row > 0) {
            return  $this->BaseModel->get_all_rowarr($sql);
        } else {
            return null;
        }
    }

    //ปรับปรุงข้อมูล
    public function update($exam_assign_id, $data)
    {
        $condition = ["exam_assign_id" => $exam_assign_id,];
        return $this->BaseModel->update("exam_assignment", $data, $condition);
    }
}