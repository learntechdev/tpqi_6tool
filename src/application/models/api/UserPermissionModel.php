<?php
class UserPermissionModel extends CI_MODEL
{
    public function __construct()
    {
        parent::__construct();

    }

    public function role_permission_save($role_id, $permission_id, $active)
    {
        $message = array();
        if ($active == '') {
            $active = 0;
        }
        $sql = "SELECT * FROM acc_user_role_permission WHERE role_id = '" . $role_id . "' AND permission_id = '" . $permission_id . "' ";
        $query = $this->db->query($sql);
        $rows = count($query->result_array());

        if ($rows > 0) {
            $sql = "UPDATE acc_user_role_permission SET active = '" . $active . "'
            WHERE role_id = '" . $role_id . "' AND permission_id = '" . $permission_id . "' ";
            $query = $this->db->query($sql);
        } else {
            $sql = "INSERT INTO acc_user_role_permission (id, role_id, permission_id, active)
            VALUES (NULL, '" . $role_id . "', '" . $permission_id . "', '" . $active . "'); ";
            $query = $this->db->query($sql);
        }
        array_push($message, [
            "status" => '1',
            "message" => "success",
        ]);
        return $message[0];
    }

    public function acc_user_role_save($user_id, $role_id, $active)
    {
        $message = array();
        if ($active == '') {
            $active = 0;
        }
        $sql = "SELECT * FROM acc_user_role WHERE user_id = '" . $user_id . "'  ";
        $query = $this->db->query($sql);
        $rows = count($query->result_array());

        if ($rows > 0) {
            $sql = "SELECT * FROM acc_user_role_permission WHERE role_id = '" . $role_id . "'  ";
            $query = $this->db->query($sql);
            $rows = count($query->result_array());
            if ($rows > 0) {
                $sql = "UPDATE acc_user_role SET role_id = '" . $role_id . "',active = '" . $active . "'
            WHERE user_id = '" . $user_id . "'  ";
                $query = $this->db->query($sql);
                array_push($message, [
                    "status" => '1',
                    "message" => "success",
                ]);
            } else {
                array_push($message, [
                    "status" => '0',
                    "message" => "role_id not found!!",
                ]);
            }
        } else {
            $sql = "SELECT * FROM acc_user_role_permission WHERE role_id = '" . $role_id . "'  ";
            $query = $this->db->query($sql);
            $rows = count($query->result_array());
            if ($rows > 0) {
                $sql = "INSERT INTO acc_user_role (id, user_id, role_id, active)
                VALUES (NULL, '" . $user_id . "', '" . $role_id . "', '" . $active . "'); ";
                $query = $this->db->query($sql);
                array_push($message, [
                    "status" => '1',
                    "message" => "success",
                ]);
            } else {
                array_push($message, [
                    "status" => '0',
                    "message" => "role_id not found!!",
                ]);
            }
        }
        return $message[0];
    }

    public function user_permission_save($user_id, $role_id, $permission, $active)
    {
        $message = array();
        if ($active == '') {
            $active = 0;
        }
        for ($i = 0; $i < COUNT($permission); $i++) {
            $this->role_permission_save($role_id, $permission[$i]->permission_id, $active);
        }
        $message = $this->acc_user_role_save($user_id, $role_id, $active);
        return $message;
    }

    public function permission_profession_save($user_id, $user_role, $permiss)
    {

        $message = array();
        $date = date("Y-m-d H:i:s");

        $sql = "DELETE FROM acc_user_role
        WHERE user_id = '" . $user_id . "'    ";
        $query = $this->db->query($sql);
        for ($i = 0; $i < COUNT($user_role); $i++) {
            $sql = "INSERT INTO acc_user_role (id, user_id, role_id, role_desc,active,update_date)
                VALUES (NULL, '" . $user_id . "', '" . $user_role[$i]->roleid . "', '" . $user_role[$i]->role_desc . "','1','" . $date . "'); ";
            $query = $this->db->query($sql);
        }

        $sql = "DELETE FROM acc_user_permission_profession
        WHERE user_id = '" . $user_id . "'    ";
        $query = $this->db->query($sql);
        for ($i = 0; $i < COUNT($permiss); $i++) {
            $sql = "INSERT INTO acc_user_permission_profession (id, user_id, profession_code, branch_code,update_date)
                VALUES (NULL, '" . $user_id . "', '" . $permiss[$i]->profession_code . "', '" . $permiss[$i]->branch_code . "','" . $date . "'); ";
            $query = $this->db->query($sql);

        }
        array_push($message, [
            "status" => '1',
            "message" => "success",
        ]);
        return $message[0];
    }

}
