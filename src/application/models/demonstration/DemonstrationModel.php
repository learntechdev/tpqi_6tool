<?php
class DemonstrationModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("/BaseModel");
    }

    //บันทึกข้อมูลไฟล์ของการประเมินครั้งนั้นๆ
    public function save_assessment_detail_file($data, $assessment_detail_id)
    {
        $data = [
            "file_detail" => $data,
        ];

        $condition = [
            "assessment_detail_id" => $assessment_detail_id,
        ];

        $rs = $this->BaseModel->update("assessment_detail_demonstration", $data, $condition);

        if ($rs) {
            $message = [
                "status" => '1',
                "message" => 'success',
            ];
        } else {
            $message = [
                "status" => '0',
                "message" => 'error',
            ];
        }

        return $message;

    }

}