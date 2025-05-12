<?php
class ApproveModel extends CI_Model
{
    public function __construct()

    {

        parent::__construct();

        $this->load->model("/BaseModel");

        $this->load->model("masterdata/MasterDataModel");
    }



    //ดึงข้อมูลสำหรับทบทวนชุดข้อสอบ

    public function get_review_exam($filter = array())

    {

        $condition = "";

        if ($filter["occ_level_id"] != "") {

            $condition = " AND occ_level_id = '" . $filter["occ_level_id"] . "' ";
        }



        if ($filter["tool_type"] != 0) {

            $condition .= " AND tool_type = '" . $filter["tool_type"] . "' ";
        }



        if ($filter["status"] != 0) {

            $condition .= " AND exam_status = '" . $filter["status"] . "' ";
        }



        $sql = " SELECT * FROM exam_blueprint 

                    WHERE (send_approve = '1'

                    OR exam_status = '2')  " . $condition .

            " ORDER BY created_date DESC";

        //print_r($sql);

        return $this->BaseModel->get_all_pagination($sql, $filter["page_no"], $filter["per_page"]);
    }



    //อนุมัติการทบทวนข้อสอบ

    public function approve_review_exam($status, $template_id, $reason_disapprove)

    {



        $send_approve = $status == 1 ? "1" : "";



        $data = ["exam_status" => $status, "send_approve" => $send_approve];

        $condition = ["template_id" => $template_id];



        $exam_status = $this->BaseModel->update("exam_blueprint", $data, $condition);



        if ($exam_status) {

            $rs  = $this->log_exam_status($status, $template_id, $reason_disapprove, "");

            return $rs;
        } else {

            return 0;
        }
    }



    // ดึงข้อมูลเพื่อใช้สำหรับกำหนดชุดข้อสอบ

    public function get_define_exam($filter = array())

    {

        $condition = "";

        $status = "";



        if ($filter["status"] != 0) {

            $status = $filter["status"];
        } else {

            $status = '1,3';
        }



        $condition = " WHERE status in (" . $status . ") ";



        if ($filter["tool_type"] != "0" && $filter["tool_type"] != "") {

            $condition .= " AND   asm_tool_type = '" . $filter["tool_type"] . "' ";
        }



        if ($filter["occ_level_id"] != "") {

            //$str_occ_level_id = explode(":", $filter["occ_level_id"]);

            $str_occ_level_id = $filter["occ_level_id"];

            $condition .= " AND  occ_level_id = '" . $str_occ_level_id . "'";
        }

        if ($_SESSION['user_type'] != '8') {
            if ($_SESSION["citizen_id"] != "") {
                $sql_user_permiss = " SELECT GROUP_CONCAT(CONCAT('\'', branch_code, '\''))  tier2_code
                    FROM acc_user_permission_profession
                    WHERE user_id = '" . $_SESSION["citizen_id"] . "'";
                $rs_user_permiss = $this->BaseModel->get_one_field($sql_user_permiss);
                if ($rs_user_permiss['tier2_code'] != null) {
                    $rs = $rs_user_permiss['tier2_code'];

                    $sql_occ_level_id = " SELECT GROUP_CONCAT(CONCAT('\'', id, '\'')) occ_level_id FROM standard_qualification WHERE tier2_code in ($rs)";
                    $rs_occ_level_id = $this->BaseModel->get_one_field($sql_occ_level_id);
                    $rs_occ = $rs_occ_level_id['occ_level_id'];
                    $condition .= " AND  occ_level_id  in($rs_occ) ";
                }
            }
        }


        $sql = " SELECT * FROM exam_schedule " . $condition .
            "ORDER BY exam_schedule_id DESC";

        return $this->BaseModel->get_all_pagination($sql, $filter["page_no"], $filter["per_page"]);
    }



    // ดึงชุดข้อสอบที่ผ่านการทบทวนแล้วมาแสดง

    public function get_template_arr($occ_level_id, $tool_type)

    {

        $sql = " SELECT * FROM exam_blueprint

                WHERE occ_level_id = '" . $occ_level_id . "'

                AND tool_type = '" . $tool_type . "'

                AND is_used = '1'

                AND exam_status = '1' ";

        print_r($sql);

        return $this->BaseModel->get_all_arr($sql);
    }



    //กำหนดชุดข้อสอบ

    public function insert_chooseexam($template_id, $exam_schedule_id)

    {

        $status = "3";

        $data_sch = [

            "exam_template_id" => $template_id,

            "status" => $status,

        ];



        $condition = [

            "exam_schedule_id" => $exam_schedule_id,

        ];



        $update = $this->BaseModel->update("exam_schedule", $data_sch, $condition);

        if ($update) {

            $rs  = $this->log_exam_status($status, $template_id, "", $exam_schedule_id);

            return $rs;
        } else {

            return 0;
        }
    }



    // ดึงข้อมูลเพื่อใช้สำหรับ อนุมัติเกณฑ์การประเมิน
    public function criteria_forapprove($filter = array())
    {
        $condition = "";
        if ($filter["status"] == 5) {
            $condition = " WHERE e_sch.status = '" . $filter["status"] . "'";
        } else if ($filter["status"] == 6) {
            $condition = " WHERE e_sch.status = '1' AND exam_template_id !='' ";
        } else {
            $condition = " WHERE e_sch.status in ('1','3','5') AND exam_template_id !=''  ";
        }

        if ($filter["tool_type"] != "0" && $filter["tool_type"] != "") {
            $condition .= " AND  e_sch.asm_tool_type = '" . $filter["tool_type"] . "' ";
        }

        if ($filter["occ_level_id"] != "") {
            $str_occ_level_id = $filter["occ_level_id"];
            $condition .= " AND e_sch.occ_level_id = '" . $str_occ_level_id . "'";
        }

        $sql = " SELECT *
                 FROM exam_schedule e_sch" . $condition .
            " ORDER BY exam_schedule_id DESC ";
        return $this->BaseModel->get_all_pagination($sql, $filter["page_no"], $filter["per_page"]);
    }



    //บันทึกข้อมูล การกำหนดเกณฑ์การผ่านประเมิน

    public function insert_criteria_forexam($data)

    {

        $rs = $this->BaseModel->insert("exam_criteria", $data);

        // $data_arr = (array)$data;

        $str_exam_schedule_id = $data["exam_schedule_id"];



        if ($rs) {



            $data = ["status" => 5];

            $condition = ["exam_schedule_id" => $str_exam_schedule_id];

            $exam_sch = $this->BaseModel->update("exam_schedule", $data, $condition);



            $log_exam_status  = $this->log_exam_status(5, "", "", $str_exam_schedule_id);

            return $log_exam_status;
        }
    }



    // ดึงข้อมูลเพื่อใช้สำหรับ อนุมัติชุดข้อสอบ

    public function get_examforapprove($filter = array())

    {

        $condition = "";



        if ($filter["status"] == 7) {

            $condition = " WHERE e_sch.status = '" . $filter["status"] . "'";
        } else if ($filter["status"] == 8) {

            $condition = " WHERE e_sch.status = '3' AND exam_template_id !='' ";
        } else {

            $condition = " WHERE e_sch.status in ('3','5','7') AND exam_template_id !=''  ";
        }



        if ($filter["tool_type"] != "0" && $filter["tool_type"] != "") {

            $condition .= " AND  e_sch.asm_tool_type = '" . $filter["tool_type"] . "' ";
        }



        if ($filter["occ_level_id"] != "") {

            //$str_occ_level_id = explode(":", $filter["occ_level_id"]);

            $str_occ_level_id = $filter["occ_level_id"];

            $condition .= " AND e_sch.occ_level_id = '" . $str_occ_level_id . "'";
        }



        $sql = " SELECT e_sch.*, org.orgName

                 FROM exam_schedule e_sch

                 LEFT JOIN settings_organization org

                 ON e_sch.org_id = org.orgID" . $condition .

            " ORDER BY exam_schedule_id DESC ";



        return $this->BaseModel->get_all_pagination($sql, $filter["page_no"], $filter["per_page"]);
    }



    //ดึงข้อมูลชุดข้อสอบที่ใช้สอบรอบนั้นๆ

    public function get_template_forapprove($template_id)

    {

        $sql = " SELECT * FROM exam_blueprint

                 WHERE template_id = '" . $template_id . "'

                 ";

        return $this->BaseModel->get_all_arr($sql);
    }



    public function approve_exam($status, $template_id, $exam_schedule_id, $reason_disapprove)

    {

        $tmp_status = "";

        if ($status == 8) {

            $tmp_status = 3; // ถ้าไม่อนุมัติให้ย้อนสถานะไปอยู่ในขั้นตอน กำหนดเกณฑ์การประเมิน ซึ่งจะมีสถานะเป็น 3 (กำหนดชุดข้อสอบแล้ว)

        } else {

            $tmp_status = $status;
        }

        $data = ["status" => $tmp_status, "reason_disapproval" => $reason_disapprove];

        $condition = ["exam_schedule_id" => $exam_schedule_id];



        $exam_status = $this->BaseModel->update("exam_schedule", $data, $condition);



        if ($exam_status) {



            $rs  = $this->log_exam_status($status, $template_id, $reason_disapprove, $exam_schedule_id);

            return $rs;
        } else {

            return 0;
        }
    }



    public function get_r_reason_disapprove($template_id)

    {

        $sql = " SELECT reason_disapprove FROM exam_status

                WHERE template_id = '" . $template_id . "'

                AND status = '2'

                ORDER by id DESC limit 0,1 ";

        return $this->BaseModel->get_one_field($sql);
    }





    private function log_exam_status($status, $template_id, $reason_disapprove, $exam_schedule_id)

    {

        $data = [

            "template_id" => $template_id,

            "exam_schedule_id" => $exam_schedule_id,

            "status" => $status,

            "reason_disapprove" => $reason_disapprove,

            "created_date" => date('Y-m-d H:i:s'),

            "created_by" => $_SESSION["user_id"],

        ];



        return  $this->BaseModel->insert("exam_status", $data);
    }





    /** Flow เดิม */

    /*public function approve_criteria($status, $template_id, $exam_schedule_id, $reason_disapprove)

    {

        $tmp_status = "";

        if($status == 6){

            $tmp_status = 1; // ถ้าไม่อนุมัติให้ย้อนสถานะไปอยู่ในขั้นตอน กำหนดชุดข้อสอบ

        }else{

            $tmp_status = $status;

        }

        $data = [ "status" => $tmp_status,"reason_disapproval" => $reason_disapprove];

        $condition = ["exam_schedule_id" => $exam_schedule_id];

        

        $exam_status = $this->BaseModel->update("exam_schedule", $data, $condition);



        if($exam_status){

           

            $rs  = $this->log_exam_status($status, $template_id, $reason_disapprove, $exam_schedule_id);

            return $rs;

        }else{

            return 0;

        }

    }

*/
}