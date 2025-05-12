<?php
require_once __DIR__ . '../../../vendor/autoload.php';
//require_once __DIR__ . '../../../../vendor/autoload.php';
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);
class UserRole extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("masterdata/MasterDataModel");
        $this->load->model("shared/SharedModel");
        $this->load->model("settings/UserRoleModel");
    }

    private function criteria()
    {
        $filter = array();
        if (isset($_GET["page_no"])) {
            if (trim($_GET["page_no"]) != "") {
                $filter["page_no"] = $_GET["page_no"];
            }
        } else {
            $filter["page_no"] = 1;
        }

        if (isset($_GET["per_page"])) {
            if (trim($_GET["per_page"]) != "") {
                $filter["per_page"] = $_GET["per_page"];
            }
        } else {
            $filter["per_page"] = 10;
        }

        if (isset($_GET["keyword"])) {
            if (trim($_GET["keyword"]) != "") {
                $filter["keyword"] = $_GET["keyword"];
            }
        } else {
            $filter["keyword"] = "";
        }

        return $filter;
    }

    public function index()
    {
        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb("1,16");
        $data["active_title"] = array("active_title" => "ข้อมูลผู้ใช้งาน");

        $filter = array();
        $filter = $this->criteria();
        $data["dataList"] = $this->UserRoleModel->getUsers($filter);

        $this->SharedModel->layouts("settings/user_role/index", $data);
    }

    public function search()
    {
        $filter = array();
        $filter = $this->criteria();
        $data["dataList"] = $this->UserRoleModel->getUsers($filter);
        $this->load->view("settings/user_role/showdata", $data);
    }

    public function create()
    {
        $data["all_menu"] = $this->MasterDataModel->getAllMenu();
        //$data["org"] = $this->MasterDataModel->getOrg();

        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb("1,16,17");
        $data["active_title"] = array("active_title" => "ข้อมูลผู้ใช้งาน");
        $data["uoc"] = null;
        $data["eoc"] = null;

        $this->SharedModel->layouts("settings/user_role/form", $data);
    }

    //บันทึก
    public function insert()
    {
        $rs = "";
        $dataArr = [
            "username" => $_POST["username"],
            "password" => $_POST["password"],
            "name" => $_POST["name"],
            "user_type" => "99",
            "citizen_id" =>  $_POST["username"],
            "flag" =>  $_POST["flag"],
            "menu_authorized" => $_POST["menu_authorized"],
            "created_date" => date('Y-m-d H:i:s')
        ];


        if ($_POST["action"] == "create") {
            $rs = $this->UserRoleModel->insert($dataArr);
            echo $rs;
        } else { // for edit
            // $rs = $this->ExamAssignmentModel->update($exam_assign_id, $dataArr);
            // return $rs;
        }
    }

    public function cancelRole()
    {
        $rs = $this->UserRoleModel->cancelRole($_POST['username']);
        echo json_decode($rs);
    }

    private function criteriaAER()
    {
        $filter = array();
        if (isset($_GET["page_no"])) {
            if (trim($_GET["page_no"]) != "") {
                $filter["page_no"] = $_GET["page_no"];
            }
        } else {
            $filter["page_no"] = 1;
        }

        if (isset($_GET["per_page"])) {
            if (trim($_GET["per_page"]) != "") {
                $filter["per_page"] = $_GET["per_page"];
            }
        } else {
            $filter["per_page"] = 10;
        }

        if (isset($_POST["username"])) {
            if (trim($_POST["username"]) != "") {
                $filter["username"] = $_POST["username"];
            }
        } else {
            $filter["username"] = "";
        }

        if (isset($_POST["user_id"])) {
            if (trim($_POST["user_id"]) != "") {
                $filter["user_id"] = $_POST["user_id"];
            }
        } else {
            $filter["user_id"] = "";
        }
    }

    public function AERIndex()
    {
        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb("1,16,18");
        $data["active_title"] = array("active_title" => "กำหนดสิทธิ์ในการเห็นรอบสอบ");

        $filter = array();
        $filter["username"] = $_POST["username"];
        $filter["user_id"] = $_POST["user_id"];
        $data["dataListExamRound"] =  $this->UserRoleModel->getAuthorizedExamround($filter);
        $data["name"] = $_POST["username"];
        $this->SharedModel->layouts("settings/user_role/form_authorized_examround", $data);
    }

    public function insert_authorized_examround()
    {
        $rs = "";
        $dataArr = [
            "tpqi_exam_no" => $_POST["examround"],
            "citizen_id" =>  $_POST["username"],
            "flag" =>  '1',
            "created_date" => date('Y-m-d H:i:s')
        ];

        $rs = $this->UserRoleModel->insert_authorized_examround($dataArr);
        echo $rs;
    }

    public function getAuthorizedExamround()
    {
        $filter = array();
        if (isset($_GET["page_no"])) {
            if (trim($_GET["page_no"]) != "") {
                $filter["page_no"] = $_GET["page_no"];
            }
        } else {
            $filter["page_no"] = 1;
        }

        if (isset($_GET["per_page"])) {
            if (trim($_GET["per_page"]) != "") {
                $filter["per_page"] = $_GET["per_page"];
            }
        } else {
            $filter["per_page"] = 10;
        }

        if (isset($_GET["username"])) {
            if (trim($_GET["username"]) != "") {
                $filter["username"] = $_GET["username"];
            }
        } else {
            $filter["username"] = "";
        }

        $data["dataListExamRound"] = $this->UserRoleModel->getAuthorizedExamround($filter);
        $this->load->view("settings/user_role/show_authorized_examround", $data);
    }

    public function cancelAuthorizedExamround()
    {
        $rs = $this->UserRoleModel->cancelAuthorizedExamround($_POST['username'], $_POST['id']);
        echo json_decode($rs);
    }

    public function insertAuthorizedOcc()
    {
        $rs = "";
        $dataArr = [
            "occ_level_id" => $_POST["occ_level_id"],
            "username" =>  $_POST["username"],
            "status" =>  '1',
            "created_date" => date('Y-m-d H:i:s'),
            "created_by" => $_SESSION['username']
        ];

        $rs = $this->UserRoleModel->insertAuthorizedOcc($dataArr);
        echo $rs;
    }

    public function AoccIndex()
    {
        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb("1,16,19");
        $data["active_title"] = array("active_title" => "กำหนดสิทธิ์ในการเห็นคุณวุฒิวิชาชีพ");

        $filter = array();
        $filter["username"] = $_POST["username"];
        $filter["user_id"] = $_POST["user_id"];
        $filter["page_no"] = 1;
        $filter["per_page"] = 10;
        $data["dataListAocc"] =  $this->UserRoleModel->getAuthorizedOcc($filter);
        $data["name"] = $_POST["username"];
        $this->SharedModel->layouts("settings/user_role/form_authorized_occ", $data);
    }

    public function cancelAocc()
    {
        $rs = $this->UserRoleModel->cancelAocc($_POST['username'], $_POST['occ_level_id']);
        echo json_decode($rs);
    }

    public function searchAocc()
    {
        $filter = array();
        if (isset($_GET["page_no"])) {
            if (trim($_GET["page_no"]) != "") {
                $filter["page_no"] = $_GET["page_no"];
            }
        } else {
            $filter["page_no"] = 1;
        }

        if (isset($_GET["per_page"])) {
            if (trim($_GET["per_page"]) != "") {
                $filter["per_page"] = $_GET["per_page"];
            }
        } else {
            $filter["per_page"] = 10;
        }

        if (isset($_GET["username"])) {
            if (trim($_GET["username"]) != "") {
                $filter["username"] = $_GET["username"];
            }
        } else {
            $filter["username"] = "";
        }
        $data["dataListAocc"] = $this->UserRoleModel->getAuthorizedOcc($filter);
        $this->load->view("settings/user_role/show_authorized_occ", $data);
    }
}