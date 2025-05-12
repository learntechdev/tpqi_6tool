<?php

defined('BASEPATH') or exit('No direct script access allowed');

require __DIR__ . '../../../vendor/autoload.php';

class Authentication extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->objOfJwt = new CreatorJwt();
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        $this->load->model("api/AuthenModel");
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username =  $this->input->post("username");
            $password =  $this->input->post("password");

            if ($username != "" && $password != "") {
                $result = $this->AuthenModel->login($username, $password);
                $this->output
                    ->set_content_type("application/json")
                    ->set_output(json_encode($result));
            } else {
                echo json_encode([
                    "status" => 0,
                    "message" => "กรุณากรอกข้อมูลให้ครบถ้วน!!!",
                ]);
            }
        } else {
            echo json_encode([
                "status" => false,
                "message" => "รูปแบบการส่งพารามิเตอร์ไม่ถูกต้อง",
            ]);
        }
    }

    public function login1()
    {
        //$obj = file_get_contents('php://input');
        //$data = json_decode($obj);
        $json = str_replace(array("\t", "\n"), "", $_POST["dt"]);
        $data = json_decode($json);

        if (isset($data->username) && isset($data->password)) {
            $username = $data->username;
            $password = $data->password;
            $result = $this->AuthenModel->login($username, $password);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode($result));
        } else {
            $res["res"] = array([
                "status_code" => "0",
                "message" => "Invalid Input",
                "token" => '',
            ]);
            echo json_encode($res["res"][0]);
        }
    }

    public function login_document()
    {
        $result = $this->AuthenModel->login($_POST['username'], $_POST['password']);
        if ($result['status_code']) {
            // $this->ApiMasterDataModel->saveLog($result['res'][0]['token'], 'Authentication/login_document');

            $jwtData = $this->objOfJwt->DecodeToken($result['token']);
            $_SESSION['id'] = $jwtData['id'];
            $_SESSION['username'] = $jwtData['username'];
            $_SESSION['app_id'] = $jwtData['app_id'];
            $_SESSION['user_type'] = $jwtData['user_type'];
            $_SESSION['timeStamp'] = $jwtData['timeStamp'];
            $_SESSION['expire'] = $jwtData['expire'];
            echo true;
        } else {
            echo false;
        }
    }

    public function logout_document()
    {
        session_destroy();
        echo true;
    }
}