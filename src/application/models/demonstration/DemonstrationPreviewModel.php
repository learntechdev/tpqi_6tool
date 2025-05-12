<?php
class DemonstrationPreviewModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("/BaseModel");
    }

    public function get_tp_preview($template_id)
    {

        $sql = " SELECT * FROM exam_blueprint
                    WHERE template_id = '" . $template_id . "' ";

        return $this->BaseModel->get_all($sql);
    }

    public function get_tp_detail($template_id)
    {
        $sql = " SELECT * FROM exam_demonstration_detail
                    WHERE 	template_id = '" . $template_id . "' ";
        return $this->BaseModel->get_all($sql);
    }

    public function get_pstd_uocname($uoc_code)
    {
        $sql = " SELECT * FROM v_pstd_uoc WHERE stdID = '" . $uoc_code . "' ";
        return $this->BaseModel->get_one_field($sql);
    }

    public function get_pstd_eocname($eoc_code)
    {
        $sql = " SELECT * FROM v_pstd_eoc WHERE stdID = '" . $eoc_code . "' ";
        return $this->BaseModel->get_one_field($sql);

    }

}