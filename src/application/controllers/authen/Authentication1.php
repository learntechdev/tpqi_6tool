<?php

defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('UTC');

class Authentication extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();

        $this->load->model("authen/AuthenModel");
        $this->load->model("api/TpqinetAuthenModel");
    }

    public function test()
    {
        $this->load->view("test/index");
    }

    public function index()
    {
        $this->load->view("authen/index");
        //echo $_GET['session_id'];

        // redirect('asmtools/ASMTools/index');

        /* if (isset($_GET['session_id'])) {
            if ($_GET['session_id'] != '') {
                //  $member_session = $this->TpqinetAuthenModel->member_session($_GET['session_id']);

                /* $_SESSION["username"] = $_GET['session_id'];
                $_SESSION["user_id"] = $_GET['session_id'];
                $_SESSION["user_type"] = '8';
                $_SESSION["name"] = "คุณธนัท ทองอุทัยศรี";
                redirect('asmtools/ASMTools/index');
                */
        /*     redirect('asmtools/ASMTools/index');
            }
            redirect('asmtools/ASMTools/index');
        } else {
            $this->load->view("authen/index");
        }*/
    }

    public function authen()
    {

        $username = $this->input->post("username");

        $password = $this->input->post("password");

        $result = $this->AuthenModel->authen($username, $password);

        echo json_encode($result);
    }

    public function logout()
    {

        foreach ($_SESSION as $key => $value) {

            unset($_SESSION[$key]);
        }

        echo json_encode(1);
    }
}