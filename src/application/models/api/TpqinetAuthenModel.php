<?php
class TpqinetAuthenModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("/BaseModel");
    }

    // authen api of tpqi-net
    private function tpqi_authen()
    {
        $data = array(
            'ClientID' => '5fe8a60e76970',
            'ClientSecret' => 'c1fd0ce9c7d24f480fadeada8eb10d22'
        );

        $data_string = json_encode($data);
        $curl = curl_init('https://tpqinet-api.tpqi.go.th/web_api/v1/auth');

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            )
        );

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $result = curl_exec($curl);
        curl_close($curl);
        // print_r($result);
        $data = (array) json_decode($result, true);
        $token = $data["token"];
        return $token;
        // print_r($result);
    }

    public function member_session($session_id)
    {
        $token = $this->tpqi_authen();
        //  print_r($token);
        //return $token;
        /*$post = array(
            "session_id" => $session_id,
            "user_agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:84.0) Gecko/20100101 Firefox/84.0",
        );*/

        /* $post = array(
            "session_id" => $session_id,
            "user_agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36",
        );*/
        $post = array(
            "session_id" => $session_id,
            "user_agent" => $_SERVER['HTTP_USER_AGENT'],
        );

        $ch = curl_init('https://tpqinet-api.tpqi.go.th/web_api/v1/member_session');
        $post = json_encode($post);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'token: ' . $token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        // return json_decode($result);
		
		//print_r($result);
		//die("Unable to connect to ");
        $data = (array) json_decode($result, true);
		 //get all  role list from json data then insert into menu_authorized feild at user_login table.
		
		$result = $data["result"];
        if ($data["status"] == 000) {
            $result = $data["result"];
            $chkdata = $this->isvalid_account($result);
            if ($chkdata == 0) {
                $rs = $this->insert_userrole($result, $session_id);
                if ($rs == 1) {
                    $chkdata = $this->isvalid_account($result);
					 
                    return $chkdata;
                }
            } else {
  
                return 1;
            }
        } else {
            return 'ดึงข้อมูลจาก API ของ tpqinet ไม่ได้';
        }
		
    }

    // เช็คว่ามี account ใน db หรือยัง
    private function isvalid_account($result)
    {
		$this->updateMemberSession($result);
        $sql = " SELECT * FROM user_login
                WHERE citizen_id = '" . $result["citizen_id"] . "'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $rows = count($query->result());
        // return $result;
        if ($rows > 0) {
            foreach ($result as $row) {
                $_SESSION["personID"] = $row["citizen_id"]; //$row["username"];
                $_SESSION["username"] = $row["citizen_id"]; //$row["username"];
                $_SESSION["user_id"] = $row["id"];
                $_SESSION["name"] = $row["prefix"] . $row["first_name"] . " " . $row["last_name"];
                $_SESSION["user_type"] = $row["user_type"];
                $_SESSION["app_id"] = $row["app_id"];
                $_SESSION["citizen_id"] = $row["citizen_id"];
				$_SESSION["menu_authorized"] = $row["menu_authorized"];


                /* $sql_access = " SELECT * FROM user_access_tools
                WHERE user_id = '" . $row['id'] . "'  ";
                $query = $this->db->query($sql_access);
                $result_access = $query->result_array();
                $rows_access = count($query->result());
                if ($rows_access > 0) {
                    $_SESSION["access_tools"] = $result_access;
                }*/

                $sql_role = " SELECT GROUP_CONCAT(CONCAT('\'', role_id, '\'')) role_id FROM tpqinet_user_role 
                                WHERE citizen_id = '" . $row["citizen_id"] . "'";
                $rs_role = $this->BaseModel->get_one_field($sql_role);
                $role_rows = $this->BaseModel->get_num_rows($sql_role);
                if ($role_rows > 0) {
                    $_SESSION["role_id"]  = $rs_role["role_id"];
                } else {
                    $_SESSION["role_id"] = "";
                }
            }

            $this->session->set_userdata('logged_in', true);
            return 1;
        } else {
            return 0;
        }
    }

    private function insert_userrole($data, $session_id)
    {
        $data_row = [
            "session_id" => $session_id,
            "citizen_id" => $data["citizen_id"],
            "prefix" => $data["prefix"],
            "first_name" => $data["first_name"] == NULL ? "" : $data["first_name"],
            "last_name" => $data["last_name"] == NULL ? "" : $data["last_name"],
            "prefix_en" => $data["prefix_en"] == NULL ? "" : $data["prefix_en"],
            "first_name_en" => $data["first_name_en"] == NULL ? "" : $data["first_name_en"],
            "last_name_en" => $data["last_name_en"] == NULL ? "" : $data["last_name_en"],
            "picture_url" => $data["picture_url"] == NULL ? "" : $data["picture_url"],
            "email" => $data["email"] == NULL ? "" : $data["email"],
            "phone_number" => $data["phone_number"] == NULL ? "" : $data["phone_number"]
        ];

        $insert_data = $this->BaseModel->insert("user_login", $data_row);

        if ($insert_data) {
            $role_list = $data["role_list"];
            $org_list = $data["org_list"];

            $insert_role = '';
            foreach ($role_list as $item) {
                $role_row = [
                    "citizen_id" => $data["citizen_id"],
                    "role_id" => $item["id"],
                    "name" => $item["name"]
                ];
                $insert_role = $this->BaseModel->insert("tpqinet_user_role", $role_row);
            }

            if ($insert_role) {
                foreach ($org_list as $org) {
                    $org_row = [
                        "citizen_id" => $data["citizen_id"],
                        "org_code" => $org["org_code"],
                        "org_name" => $org["org_name"],
                        "staff_type_id" => $org["staff_type_id"],
                        "staff_type_name" => $org["staff_type_name"]
                    ];

                    $insert_org = $this->BaseModel->insert("tpqinet_user_org", $org_row);
                }
            }
            return 1;
        }
    }
	
	
	
	
	private function updateMemberSession($result)
    {
		$tmpapi=((json_encode($result, JSON_UNESCAPED_UNICODE)))."";
		$tmpMemberSessionJson = array();
		$tmpMemberSession = array();
		if (!empty($result)) {
			 if (!empty($result["role_list"])) {
				$role_list = $result["role_list"];
				foreach ($role_list as $item) {
					 if (!empty($item["id"])) {
						 if(!in_array( $item["id"], $tmpMemberSessionJson, true)){ 
							array_push($tmpMemberSessionJson, $item["id"]);
						} 
						// array_push($tmpMemberSessionJson, $item["id"]);
					 }
					
				}
			}
		}
		if(count($tmpMemberSessionJson)>0){
			$arr_keyword = implode(',', $tmpMemberSessionJson);
			$sql = " SELECT * FROM `user_menu` WHERE `user_menu`.`role_id` in ($arr_keyword)";
			$raw_data =$this->BaseModel->get_all($sql); 
			$num_datas= count($raw_data);
			 
			if($num_datas>0){
				for ($i = 0; $i < ($num_datas  ); $i++)
				{
					 $tmprole=$raw_data[$i];
					 if ( is_object( $tmprole ) ){
						 $d = get_object_vars( $tmprole );
						 array_push($tmpMemberSession, $d['menu_id']);
					 } 
				}
				$tmpMemberSession = array_unique($tmpMemberSession);
				$arr_keyword = implode(',', $tmpMemberSession);
				$data = array(
					'menu_authorized' => $arr_keyword ,
					'api_json' => $tmpapi
					 
				);
				$condition = array(
					'citizen_id' => $result["citizen_id"]
				);
				 
				$result = $this->BaseModel->update("user_login", $data, $condition);
				// die(print_r($data));
			}
		}
        // return $result;
				
    }
}
