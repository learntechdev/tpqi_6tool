<?php
class AuthenModel extends CI_model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("/BaseModel");
    }

    public function login($user, $pass)
    {
        $data["res"] = array();
        $sql = " SELECT * FROM user_login WHERE username ='" . $user . "' AND password = '" . $pass . "'  ";
        $result = $this->BaseModel->get_all($sql);

        if ($result != '') {
            $token = $this->ApiMasterDataModel->GenToken($result[0]->id, $result[0]->username, $result[0]->app_id, $result[0]->user_type);
            array_push($data["res"], [
                "status_code" => "1",
                "message" => "success",
                "token" => $token,
            ]);
        } else {
            array_push($data["res"], [
                "status_code" => "0",
                "message" => "data not found.",
                "token" => "",
            ]);
        }

        return $data["res"][0];
    }

}
