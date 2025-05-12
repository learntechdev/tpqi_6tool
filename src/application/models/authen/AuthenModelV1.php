<?php
class AuthenModelV1 extends CI_model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("/BaseModel");
    }

    public function isvalid_account($username, $password)
    {
        $sql = " SELECT * FROM user_login
                WHERE username = '" . $username . "'
                AND password = '" . $password . "' ";
        $query = $this->db->query($sql);
	 
        $result = $query->result_array();
		//print_r($result);
        //$rows = count($query->result());
		$query2 = $this->db->query($sql);   
		$rows = $query2->num_rows();
		 
        if ($rows > 0) {
			
            foreach ($result as $row) {
				
				//print( $row["id"]  );
				
				//$tmpname =  $row["name"] != "" ? $row["name"] : $row["prefix"] . $row["first_name"] . " " . $row["last_name"];
				//print( $tmpname." 22" );
				
                $_SESSION["personID"] = $row["citizen_id"];
                $_SESSION["username"] = $row["citizen_id"];
                $_SESSION["user_id"] = $row["id"];
				$_SESSION["name"] =  $row["name"] != "" ? $row["name"] : $row["prefix"] . $row["first_name"] . " " . $row["last_name"];
                //$_SESSION["name"] = $row["prefix"] . $row["first_name"] . " " . $row["last_name"];
                $_SESSION["user_type"] = $row["user_type"];
                $_SESSION["app_id"] = $row["app_id"];
                $_SESSION["menu_authorized"] = $row["menu_authorized"];
                $_SESSION["occ_authorized"] = $row["occ_authorized"];
				
				 
				

                  $sql_role = " SELECT GROUP_CONCAT(CONCAT('\'', role_id, '\'')) role_id FROM tpqinet_user_role 
                                WHERE citizen_id = '" . $row["citizen_id"] . "'";
                $rs_role = $this->BaseModel->get_one_field($sql_role);
                $role_rows = $this->BaseModel->get_num_rows($sql_role);
                if ($role_rows > 0) {
                    $_SESSION["menu_authorized"]  = $rs_role["role_id"];
                } else {
                    $_SESSION["menu_authorized"] = "";
                }
				
                
            }
			

           // $this->session->set_userdata('logged_in', true);
            return 1;
        } else {
            return 0;
        }
    }
}
