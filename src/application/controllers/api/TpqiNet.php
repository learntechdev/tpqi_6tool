<?php

defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('UTC');
class TpqiNet extends CI_Controller
{

    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        parent::__construct();

        $this->load->model("api/TpqiNetModel");

    }

    public function member_session()
    {
        $session_id = "CnElVq5koxM9VM4XICFIlhMoXH0wj6jZdaNLaZua";
        $result = $this->TpqiNetModel->member_session($session_id);
        echo json_encode($result);
    }

    public function member_role()
    {
        $citizenID = "5757471408027";
        $result = $this->TpqiNetModel->member_role($citizenID);
        echo json_encode($result);
    }

    public function member_login()
    {
        $email = "manager@ramintrasoft.com";
        $password = "12345678";
        $result = $this->TpqiNetModel->member_login($email, $password);
        echo json_encode($result);
    }

}
