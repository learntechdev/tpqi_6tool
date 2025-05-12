<?php
// require_once __DIR__ . '../../../vendor/autoload.php';
defined('BASEPATH') or exit('No direct script access allowed');

class PhDropDown extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('phtools/PhDropDownModel');
    }

    public function getTier2()
    {
        $tier1_code = $this->input->post('tier1_code');
        $data = $this->PhDropDownModel->getTier2($tier1_code);
        echo json_encode($data);
    }

    public function getTier3()
    {
        $tier1_code = $this->input->post('tier1_code');
        $tier2_code = $this->input->post('tier2_code');
        $data = $this->PhDropDownModel->getTier3($tier1_code, $tier2_code);
        echo json_encode($data);
    }

    public function getLevel()
    {
        $tier1_code = $this->input->post('tier1_code');
        $tier2_code = $this->input->post('tier2_code');
        $tier3_id = $this->input->post('tier3_id');
        $data = $this->PhDropDownModel->getLevel($tier1_code, $tier2_code, $tier3_id);
        echo json_encode($data);
    }

    public function getStandardQualification()
    {
        $tier1_code = $this->input->post('tier1_code');
        $tier2_code = $this->input->post('tier2_code');
        $tier3_id = $this->input->post('tier3_id');
        $level_code = $this->input->post('level_code');
        $data = $this->PhDropDownModel->getStandardQualification($tier1_code, $tier2_code, $tier3_id, $level_code);
        echo json_encode($data);
    }
}
