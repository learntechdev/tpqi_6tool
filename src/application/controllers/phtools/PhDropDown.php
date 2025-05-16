<?php
// require_once __DIR__ . '../../../vendor/autoload.php';
defined('BASEPATH') or exit('No direct script access allowed');

class PhDropDown extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('phtools/StandardQualificationModel');
    }
    // เปลี่ยนชื่อ method ให้เป็น snake_case
    public function get_tier2()
    {
        $tier1_code = $this->input->post('tier1_code');
        $data = $this->StandardQualificationModel->get_all_tier2_dropdown($tier1_code);
        echo json_encode($data);
    }

    public function get_tier3()
    {
        $tier1_code = $this->input->post('tier1_code');
        $tier2_code = $this->input->post('tier2_code');
        $data = $this->StandardQualificationModel->get_all_tier3_dropdown($tier1_code, $tier2_code);
        echo json_encode($data);
    }

    public function get_level()
    {
        $tier1_code = $this->input->post('tier1_code');
        $tier2_code = $this->input->post('tier2_code');
        $tier3_id = $this->input->post('tier3_id');
        $data = $this->StandardQualificationModel->get_all_level_dropdown($tier1_code, $tier2_code, $tier3_id);
        echo json_encode($data);
    }

    public function get_standard_qualification()
    {
        $tier1_code = $this->input->post('tier1_code');
        $tier2_code = $this->input->post('tier2_code');
        $tier3_id = $this->input->post('tier3_id');
        $level_code = $this->input->post('level_code');
        $data = $this->StandardQualificationModel->get_ids_by_tier_and_level($tier1_code, $tier2_code, $tier3_id, $level_code);
        echo json_encode($data);
    }
}
