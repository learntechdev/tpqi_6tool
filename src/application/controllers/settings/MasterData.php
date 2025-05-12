<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MasterData extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("masterdata/MasterDataModel");
    }

    // ดึงข้อมูล ประเภทเทมเพลต
    public function get_template_type()
    {
        $rs = $this->MasterDataModel->template_type($_POST['asm_tool'], $_POST['exam_type']);
        echo json_encode($rs);
    }

}