<?php

defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('UTC');

class Examresult extends CI_Controller

{

    public function __construct()

    {

        header("Access-Control-Allow-Origin: *");

        header("Content-Type: application/json; charset=UTF-8");

        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

        header("Access-Control-Allow-Max-Age: 3600");

        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



        parent::__construct();



        $this->load->model("exam/ExamResultModel");

    }



    public function all_examresult()

    {

        $token = $this->ApiMasterDataModel->checkToken();

        if (isset($token)) {

            $result = $this->ExamResultModel->get_examresult("");

            echo json_encode($result);

        }

    }



    public function round_examresult()

    {

        $token = $this->ApiMasterDataModel->checkToken();

        if (isset($token)) {

            $obj = file_get_contents('php://input');

            $data = json_decode($obj);

            $result = "";

            if (isset($_GET["tpqi_exam_no"]) && $_GET["tpqi_exam_no"] != "") {

                $keyword = $_GET["tpqi_exam_no"];

                $result = $this->ExamResultModel->get_examresult($keyword);

            } else {

                $result = [

                    "status" => "0",

                    "msg" => "ต้องระบุรอบสอบ!!!",

                ];

            }

            echo json_encode($result);

        }

    }



    public function confirm_get_examresult()

    {

        $token = $this->ApiMasterDataModel->checkToken();

        if (isset($token)) {

            $obj = file_get_contents('php://input');

            $data = json_decode($obj);

            $result = $this->ExamResultModel->confirm_get_examresult($data);

            echo json_encode($result);

        }

    }



}