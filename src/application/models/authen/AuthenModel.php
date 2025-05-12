<?php
class AuthenModel extends CI_model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function authen($username, $password)
    {
        $sql = " SELECT * FROM user_login
                    WHERE username = '" . $username . "'
                    AND password = '" . $password . "' ";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        $rows = count($query->result());

        if ($rows > 0) {
            foreach ($result as $row) {
                $_SESSION["personID"] = $row["username"];
                $_SESSION["username"] = $row["username"];
                $_SESSION["user_id"] = $row["id"];
                $_SESSION["name"] = $row["name"];
                $_SESSION["user_type"] = $row["user_type"];
                $_SESSION["app_id"] = $row["app_id"];
                $_SESSION["citizen_id"] = $row["citizen_id"];
                if ($row["user_type"] == 1) {
                    $_SESSION["role_id"] = "61";
                } else {
                    $_SESSION["role_id"] = "57";
                }

                $this->session->set_userdata('logged_in', true);

                /*  $sql_access = " SELECT * FROM user_access_tools
                WHERE user_id = '" . $row['id'] . "'  ";
                $query = $this->db->query($sql_access);
                $result_access = $query->result_array();
                $rows_access = count($query->result());
                if ($rows_access > 0) {
                    $_SESSION["access_tools"] = $result_access;
                }*/
            }
            $status = 1;

            $rs = array(
                "status" => $status,
                "user_type" => $_SESSION["user_type"],
            );
        } else {
            $status = 0;

            $rs = array(
                "status" => $status,
                "user_type" => '',
            );
        }

        return $rs;
    }
}