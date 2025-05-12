<?php
class TemplatesModel extends CI_Model
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
        $sql = " SELECT * FROM tp_qans
                    WHERE 	template_id = '" . $template_id . "'
                    AND question_status = '1' ";
        return $this->BaseModel->get_all($sql);
    }

    //สำหรับ preview exam ตอนสร้าง
    public function get_tp_detail_create_preview($template_id)
    {
        $sql = " SELECT * FROM tp_qans
                    WHERE 	template_id = '" . $template_id . "' ";
        return $this->BaseModel->get_all($sql);
    }

    public function isvalid_detail($template_id)
    {
        $sql = " SELECT * FROM tp_qans
                    WHERE template_id	 = '" . $template_id . "' ";
        $num_row = $this->BaseModel->get_num_rows($sql);
        if ($num_row > 0) {
            $condition = ["template_id	" => $template_id];
            $rs = $this->BaseModel->delete("tp_qans", $condition);
            return 1;
        } else {
            return 0;
        }
    }

    public function insert_qans_detail($template_id, $json_q_detail)
    {
        $result = "";
        foreach ($json_q_detail as $uoc) {
            foreach ($uoc as $eoc) {
                foreach ($eoc as $item) {
                    if ($item->question != "") {
                        $arr_list = [
                            "template_id" => $template_id,
                            "uoc_code" => ($item->uoc_code == NULL || $item->uoc_code == "") ? "" : $item->uoc_code,
                            "eoc_code" => ($item->eoc_code == NULL || $item->eoc_code == "") ? "" : $item->eoc_code,
                            "question" => ($item->question == NULL || $item->question == "") ? "" : $item->question,
                            "guide_answer" => ($item->answer == NULL || $item->answer == "") ? "" : $item->answer,
                            "question_status" => ($item->question_status == NULL || $item->question_status == "") ? "" : $item->question_status
                        ];

                        $result = $this->BaseModel->insert("tp_qans", $arr_list);
                        if ($result) {
                            $result = 1;
                        } else {
                            $result = 0;
                        }
                    }
                }
            }
        }
        return $result;
    }
}