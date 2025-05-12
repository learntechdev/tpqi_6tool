<?php
class UserRoleModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("/BaseModel");
    }

    public function getUsers($filter = array())
    {
        $condition = '';

        if ($filter['keyword'] != '') {
            $condition .= " AND  username LIKE '%" . $filter['keyword'] . "%'
            OR name LIKE '%" . $filter['keyword'] . "%' ";
        }

        $condition .= "ORDER BY id DESC ";
        $sql = " SELECT * FROM user_login WHERE 1=1  " . $condition;

        //print_r($sql);
        return $this->BaseModel->get_all_pagination($sql, $filter["page_no"], $filter["per_page"]);
    }

    private function checkAccount($username)
    {
        $sql = " SELECT username FROM user_login
        WHERE username = '" . $username . "' AND flag != '0' ";
        $num_row = $this->BaseModel->get_num_rows($sql);
        if ($num_row > 0) {
            return  1;
        } else {
            return 0;
        }
    }

    //บันทึก
    public function insert($data)
    {
        $validAccount = $this->checkAccount($data["username"]);

        if ($validAccount == 0) {
            $result = $this->BaseModel->insert("user_login", $data);
            return $result;
        } else {
            return 2;
        }
    }

    public function cancelRole($username)
    {
        $data = ["flag" => '0',];

        $condition = ["username" => $username];

        return $this->BaseModel->update("user_login", $data, $condition);
    }

    private function checkAuthorizedExamround($tpqi_exam_no, $citizen_id)
    {
        $sql = " SELECT tpqi_exam_no FROM tpqinet_authorized_examround
        WHERE tpqi_exam_no = '" . $tpqi_exam_no . "'
        AND citizen_id = '" . $citizen_id . "'
        AND flag != '0' ";
        $num_row = $this->BaseModel->get_num_rows($sql);
        if ($num_row > 0) {
            return  1;
        } else {
            return 0;
        }
    }

    public function insert_authorized_examround($data)
    {
        $validAccount = $this->checkAuthorizedExamround($data["tpqi_exam_no"], $data["citizen_id"]);

        if ($validAccount == 0) {
            $result = $this->BaseModel->insert("tpqinet_authorized_examround", $data);
            return $result;
        } else {
            return 2;
        }
    }

    public function getAuthorizedExamround($filter = array())
    {
        $sql = " SELECT * FROM tpqinet_authorized_examround WHERE citizen_id='" . $filter['username'] . "'
        AND flag = '1' ORDER BY created_date DESC ";
        return $this->BaseModel->get_all_pagination($sql, $filter["page_no"], $filter["per_page"]);
    }

    public function cancelAuthorizedExamround($username, $id)
    {
        $data = ["flag" => '0',];
        $condition = ["citizen_id" => $username, "id" => $id];
        return $this->BaseModel->update("tpqinet_authorized_examround", $data, $condition);
    }

    private function checkAuthorizedOcc($username, $occ_level_id)
    {
        $sql = " SELECT occ_level_id FROM user_access_occlevel
        WHERE username = '" . $username . "'
        AND occ_level_id = '" . $occ_level_id . "'
        AND status != '0' ";
        $num_row = $this->BaseModel->get_num_rows($sql);
        if ($num_row > 0) {
            return  1;
        } else {
            return 0;
        }
    }

    public function insertAuthorizedOcc($data)
    {
        $validAccount = $this->checkAuthorizedOcc($data["username"], $data["occ_level_id"]);
        if ($validAccount == 0) {
            $result = $this->BaseModel->insert("user_access_occlevel", $data);
            return $result;
        } else {
            return 2;
        }
    }

    public function getAuthorizedOcc($filter = array())
    {
        $sql = " SELECT * FROM user_access_occlevel WHERE username = '" . $filter['username'] . "'
        AND status = '1' ORDER BY created_date DESC ";
        return $this->BaseModel->get_all_pagination($sql, $filter["page_no"], $filter["per_page"]);
    }

    public function cancelAocc($username, $occ_level_id)
    {
        $data = ["status" => '0',];
        $condition = ["username" => $username, "occ_level_id" => $occ_level_id];
        return $this->BaseModel->update("user_access_occlevel", $data, $condition);
    }
}