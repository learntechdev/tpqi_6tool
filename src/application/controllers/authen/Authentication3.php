<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('UTC');
class Authentication extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("authen/AuthenModel");
        $this->load->model("authen/AuthenModelV1");
        $this->load->model("api/TpqinetAuthenModel");
    }

    public function index()
    {
        if (isset($_GET['session_id'])) {
            if ($_GET['session_id'] != '') {
                $member_session = $this->TpqinetAuthenModel->member_session($_GET['session_id']);
                // echo "55" . $member_session . $_SESSION["role_id"];

                if ($member_session == 1) {
                    $p =  str_replace("'", "", $_SESSION["role_id"]);
                    $x = explode(',', $p);

                    if (in_array('67', $x)) {
                        //redirect('exam/ExamAssignment/fetchContract');
                        redirect('asmtools/ASMTools/index');
                    } else if (in_array('61', $x)) {
                        redirect('assessment/PersonAssessment/index');
                    } else {
                        redirect('exam/ExamAssignment/fetchContract');
                        //redirect('asmtools/ASMTools/index');
                    }
                } else {
                    $this->load->view("authen/index");
                }
            }
        } else {
            $this->load->view("authen/index");
        }
    }

    /*public function authen()
    {
        $username = $this->input->post("username");
        $password = $this->input->post("password");
        $result = $this->AuthenModel->authen($username, $password);
        echo json_encode($result);
    }*/

    //ทำไว้จัดการเฉพาะหน้า
    public function authen()
    {
        $username = $this->input->post("username");
        $password = $this->input->post("password");
        $result = $this->AuthenModelV1->isvalid_account($username, $password);

        if ($result == 1) {
            $p =  str_replace("'", "", $_SESSION["role_id"]);
            $x = explode(',', $p);

            if (in_array('67', $x)) {
                $user_type = "8";
            } else if (in_array('61', $x)) {
                $user_type = "1";
            } else if (in_array('57', $x)) {
                $user_type = "7";
            } else if (in_array('58', $x)) {
                $user_type = "8";
            }else if (in_array('56', $x)) {
                $user_type = "8";
            } else {
                $user_type = "9";
            }
            echo json_encode([
                "status" => 1,
                "user_type" => $user_type
            ]);
        }
    }

    public function logout()
    {
        foreach ($_SESSION as $key => $value) {
            unset($_SESSION[$key]);
        }
        echo json_encode(1);
    }
}