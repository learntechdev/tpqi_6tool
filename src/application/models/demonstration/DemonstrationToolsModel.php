<?php

class DemonstrationToolsModel extends CI_Model

{



    public function __construct()

    {

        parent::__construct();

        $this->load->model("/BaseModel");
    }



    //////////////////////////////

    public function insert_qans_detail($template_id, $json_q_detail)

    {

        $result = "";

        foreach ($json_q_detail as $uoc) {

            foreach ($uoc as $item) {

                if ($item->question != "") {

                    $arr_list = [

                        "template_id" => $template_id,

                        "uoc_code" => $item->uoc_code,

                        "eoc_code" => $item->eoc_code != null ? $item->eoc_code : '',

                        "order_line" => $item->order_line,

                        "question" => $item->question,

                        "guide_answer" => $item->answer,

                    ];



                    $result = $this->BaseModel->insert("exam_demonstration_detail", $arr_list);

                    if ($result) {

                        $result = 1;
                    } else {

                        $result = 0;
                    }
                }
            }
        }

        return $result;
    }



    public function sendtemplate_approve($template_id)

    {

        $data = [

            "send_approve" => '1',

        ];



        $condition = [

            "template_id" => $template_id,

        ];



        return $this->BaseModel->update("exam_blueprint", $data, $condition);
    }



    public function save_assessment_detail_file($data, $assessment_id)
    {
        for ($i = 0; $i < COUNT($data); $i++) {
            $arr_list = [
                "name_file" => $data[$i]['name'],
                "path_file" => $data[$i]['file'],
                "create_date" => date('Y-m-d h:i:s'),
                "assessment_id" => $assessment_id,
            ];
            $rs = $this->BaseModel->insert("assessment_detail_demonstration_file", $arr_list);
        }

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





    //--------------------- ประเมินผล --------------------



    public function is_valid_assessment($exam_schedule_id, $app_id, $tool_type)

    {

        $sql = " SELECT * FROM assessment

                WHERE exam_schedule_id	 = '" . $exam_schedule_id . "'

                AND app_id = '" . $app_id . "'

                AND tool_type = '" . $tool_type . "' ";



        $str_assessment_id = $this->BaseModel->get_one_field($sql);

        $num_row = $this->BaseModel->get_num_rows($sql);



        if ($num_row > 0) {

            $condition = [

                "exam_schedule_id" => $exam_schedule_id,

                "app_id" => $app_id,

                "tool_type" => $tool_type,

            ];



            $rs = $this->BaseModel->delete("assessment", $condition);

            if ($rs) {

                $rs1 = $this->BaseModel->delete("assessment_detail_demonstration", ["assessment_id" => $str_assessment_id["assessment_id"]]);

                return 1;
            } else {

                return 0;
            }
        } else {

            return 1;
        }
    }



    public function insert_assessment($assessment, $json_ass_detail)

    {

        $assessment_id = "";

        $this->db->trans_begin();

        $this->db->insert('assessment', $assessment);



        $assessment_id = $this->db->insert_id();



        if ($this->db->trans_status() === false) {

            $this->db->trans_rollback();

            return (0);
        } else {

            $this->db->trans_commit();
        }



        if ($assessment_id != "") {

            foreach ($json_ass_detail as $uoc) {

                foreach ($uoc as $item) {

                    $arr_list = [

                        "app_id" => $assessment["app_id"],

                        "uoc_code" => $item->uoc_code,

                        "order_line" => $item->order_line,

                        "score" => $item->score,

                        "assessment_id" => $assessment_id,

                    ];



                    $rs = $this->BaseModel->insert("assessment_detail_demonstration", $arr_list);
                }
            }



            if ($rs) {
                $rs = $this->update_assessment_applicant(
                    $assessment["app_id"],
                    $assessment["exam_schedule_id"]
                );
                $arr_rs = [
                    "assessment_id" => $assessment_id,
                    "status" => 1,
                ];
                return $arr_rs;
            } else {
                $arr_rs = [
                    "assessment_id" => '',
                    "status" => 0,
                ];
                return $arr_rs;
            }
        }
    }







    //ปรับปรุงสถานะการประเมินของบุคคลนั้นๆ

    public function update_assessment_applicant($app_id, $exam_schedule_id)

    {

        $data = [

            "assessment_status" => '1',

        ];



        $condition = [

            "app_id" => $app_id,

            "exam_schedule_id" => $exam_schedule_id,

        ];



        return $this->BaseModel->update("assessment_applicant", $data, $condition);
    }

    //ตรวจสอบในฐานข้อมูลว่ามีชุดข้อสอบนี้อยู่หรือไม่ ถ้ามีให้ลบออก

    public function isvalid_detail_uoc($template_id)

    {

        $sql = " SELECT * FROM exam_demonstration_detail

                       WHERE template_id	 = '" . $template_id . "' ";



        $num_row = $this->BaseModel->get_num_rows($sql);

        if ($num_row > 0) {

            $condition = ["template_id	" => $template_id];

            $rs = $this->BaseModel->delete("exam_demonstration_detail", $condition);

            return 1;
        } else {

            return 0;
        }
    }
}