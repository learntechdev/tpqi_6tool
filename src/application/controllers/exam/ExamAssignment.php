<?php
require_once __DIR__ . '../../../vendor/autoload.php';
//require_once __DIR__ . '../../../../vendor/autoload.php';
defined('BASEPATH') or exit('No direct script access allowed');
class ExamAssignment extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("masterdata/MasterDataModel");
        $this->load->model("shared/SharedModel");
        $this->load->model("exam/ExamAssignmentModel");
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
        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb("1,2,3");
        $data["active_title"] = array("active_title" => "สร้างข้อสอบ");

        $filter = array();
        $filter = $this->criteria();
        $data["dataList"] = $this->ExamAssignmentModel->get_all($filter);

        $this->SharedModel->layouts("exam_assignment/index", $data);
    }

    public function create()
    {
        $data["occ_level"] = $this->MasterDataModel->get_occ_level();
        $data["user_exam_assign"] = $this->MasterDataModel->getUsers();
        $data["user_assessor"] = $this->MasterDataModel->getUsers();

        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb("1,2,3");
        $data["active_title"] = array("active_title" => "สร้างงานออกข้อสอบ");
        $data["uoc"] = null;
        $data["eoc"] = null;

        $this->SharedModel->layouts("exam_assignment/form", $data);
    }

    //บันทึก การสร้างงานออกข้อสอบ
    public function insert()
    {
        $rs = "";
        $json = str_replace(array("\t", "\n"), "", $_POST["dt"]);
        $data = json_decode($json);
		$occ_level_id = implode(', ', $_POST["occ_level_id1"]);
		$occ_id = array_map('intval', explode(', ', $occ_level_id));
		
		
		
        $exam_assign_id = "";
        if (isset($_POST["exam_assign_id"])) {
            $exam_assign_id = $_POST["exam_assign_id"];
        }

        $dataArr = [
//            "occ_level_id" => $data->occ_level_id,
            "contract_no" => $data->contract_no,
            "start_date" => $this->BaseModel->dateToSQL($data->start_date),
            "end_date" => $this->BaseModel->dateToSQL($data->end_date),
            "project_name" => $data->project_name,
			"occ_level_id" => implode(', ', $_POST["occ_level_id1"]),
            "user_exam_assign" => implode(', ', $_POST["user_exam_assign1"]),
            "user_assessor" => implode(', ', $_POST["user_assessor1"]),
            "created_date" => date('Y-m-d H:i:s'),
            "created_by" => $_SESSION["user_id"],
            "is_used" => '1'
        ];
		
			 
				$_SESSION["occ_level_id"] = $occ_id;
				
			
		
		
        if ($data->action == "create") {
		  for($i=0; $i<count($occ_id); $i++){
			$dataArr["occ_level_id"] = $occ_id[$i];
			$rs = $this->ExamAssignmentModel->insert($dataArr);
			 
		  }
		  return $rs;
        } else { // for edit
            $rs = $this->ExamAssignmentModel->update($exam_assign_id, $dataArr);
            return $rs;
        }
    }

    //ลบงานสร้างข้อสอบ
    public function delete()
    {
        $rs = $this->ExamAssignmentModel->delete($_POST['exam_assign_id']);
        echo json_encode($rs);
    }

    public function search()
    {
        $filter = array();
        $filter = $this->criteria();
        $data["dataList"] =  $this->ExamAssignmentModel->get_all($filter);
        $this->load->view("exam_assignment/showdata", $data);
    }

    // ดึงข้อมูลผู้ออกข้อสอบ/ผู้ตรวจข้อสอบ
    public function getUsers()
    {
        $rs = $this->ExamAssignmentModel->getUsers($_POST['term']);
        echo json_encode($rs);

        //echo json_decode($_POST['term']);
    }

    //ดึงข้อมูลสร้างงานออกข้อสอบ สำหรับผู้ใช้งาน 
    public function fetchContract()
    {
		$user_type = $_SESSION["user_type"];
        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb("1,2,3");
        $data["active_title"] = array("active_title" => "ข้อมูลงานออกข้อสอบ");

        $filter = array();
        $filter = $this->criteria();
		if($user_type == 1){
			$data["menu_asmtool"] = $this->MasterDataModel->getAdminMenu();
		}else{
			$data["menu_asmtool"] = $this->MasterDataModel->getMenu();
		}
//        $data["menu_asmtool"] = $this->MasterDataModel->getMenu();
        $data["dataList"] = $this->ExamAssignmentModel->get_all($filter);

        $this->SharedModel->layouts("exam_assignment/users/index", $data);
    }
	
	  public function searchFetchContract()
    {
		
        $filter = array();
        $filter = $this->criteria();
        $data["menu_asmtool"] = $this->MasterDataModel->getMenu();
        $data["dataList"] =  $this->ExamAssignmentModel->get_all($filter);
        $this->load->view("exam_assignment/users/showdata", $data);
    }
}