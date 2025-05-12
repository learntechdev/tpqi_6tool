<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ASMTools extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("masterdata/MasterDataModel");
        $this->load->model("exam_library/ExamlibraryModel");
    }

    public function index()
    {
		$user_type = $_SESSION["user_type"];
        //$data["menu_asmtool"] = $this->MasterDataModel->asmtools_array();
        $data["dataList"] = $this->ExamlibraryModel->get_examblueprint();
		if($user_type == 1){
			$data["menu_asmtool"] = $this->MasterDataModel->getAdminMenu();
		}else{
			$data["menu_asmtool"] = $this->MasterDataModel->getMenu();
		}
        $this->UIModel->header();
        $this->load->view("asmtools/index", $data);
        $this->UIModel->footer();
    }
}