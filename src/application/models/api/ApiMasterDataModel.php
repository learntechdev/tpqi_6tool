<?php
require APPPATH . '/libraries/CreatorJwt.php';

class ApiMasterDataModel extends CI_MODEL
{
    public function __construct()
    {
        parent::__construct();
        $this->objOfJwt = new CreatorJwt();
        $this->db = $this->load->database('default', true);
    }

    public function GenToken($id, $username, $app_id, $user_type)
    {
        $tokenData['id'] = $id;
        $tokenData['username'] = $username;
        $tokenData['app_id'] = $app_id;
        $tokenData['user_type'] = $user_type;
        $tokenData['timeStamp'] = Date('Y-m-d H:i:s');
        $tokenData['expire'] = date("Y-m-d H:i:s", strtotime('+30 minutes'));
        $jwtToken = $this->objOfJwt->GenerateToken($tokenData);
        //echo json_encode(array('Token'=>$jwtToken));
        return $jwtToken;
    }

    public function GetTokenData()
    {
        $data["res"] = array();

        if (isset($_SERVER['HTTP_AUTHORIZATION']) && !empty($_SERVER['HTTP_AUTHORIZATION'])) {
            if (preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
                // alternately '/Bearer\s((.*)\.(.*)\.(.*))/' to separate each JWT string
                $received_Token['Token'] = $matches[1];
            }
            try
            {
                //check token expired
                $jwtData = $this->objOfJwt->DecodeToken($received_Token['Token']);
                $date1 = date_create($jwtData['expire']);
                $date2 = date_create(date('Y-m-d H:i:s'));
                $diff = date_diff($date2, $date1);
                /* array_push($jwtData, [
                "date2" => $diff->format("%R%a days %h:%i:%s")
                ]);

                echo json_encode($jwtData);*/

                if ($diff->format("%R") == "+") {
                    array_push($data["res"], [
                        "status_code" => "1",
                        "message" => "success",
                        "token" => $received_Token['Token'],
                    ]);
                } else {
                    array_push($data["res"], [
                        "status_code" => "0",
                        "message" => "The token expire",
                        // "token" => $received_Token['Token']
                    ]);
                }

            } catch (Exception $e) {
                //http_response_code('401');
                //echo json_encode(array("status_code" => "0", "message" => "Token not correct"));exit;

                array_push($data["res"], [
                    "status_code" => "0",
                    "message" => "The token is not correct",
                ]);
            }
        } else {
            //echo json_encode(array("status_code" => "0", "message" => "Token not found"));exit;
            array_push($data["res"], [
                "status_code" => "0",
                "message" => "The token field is required",
            ]);
        }
        return $data["res"][0];
    }

    public function checkToken()
    {
        $chk_token = $this->ApiMasterDataModel->GetTokenData();
        if ($chk_token['status_code']) {
            return $chk_token['token'];
        } else {
            echo json_encode($chk_token);
        }

    }

}
