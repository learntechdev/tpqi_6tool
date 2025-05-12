<?php

class SimulationToolsModel extends CI_Model

{



    public function __construct()

    {

        parent::__construct();

        $this->load->model("/BaseModel");
    }



    public function insert_tp_detail($data)

    {

        $result = $this->BaseModel->insert("exam_template_detail_simulation", $data);

        return $result;
    }



    public function update_tp_detail($template_id, $json_q_detail)

    {

        $condition = ["template_id" => $template_id];



        $delete = $this->BaseModel->delete("exam_template_detail_simulation", $condition);



        for ($i = 1; $i <= COUNT((array) $json_q_detail); $i++) {

            $tp_detail = [

                "template_id" => $template_id,

                "q_no" => $i,

                "question" => $json_q_detail->$i->question,

                "answer" => $json_q_detail->$i->answer,

            ];



            $rs = $this->BaseModel->insert("exam_template_detail_simulation", $tp_detail);
        }



        if ($rs) {

            return 1;
        } else {

            return 0;
        }
    }



    /*public function get_template_detail($template_id)

    {

        $sql = " SELECT * FROM exam_template_detail_simulation tp_detail

                LEFT JOIN exam_blueprint bp

                ON tp_detail.template_id = bp.template_id

                WHERE tp_detail.template_id = '" . $template_id . "' ";

        return $this->BaseModel->get_all($sql);

    }*/





    //ปรับปรุงสถานะการประเมินของบุคคลนั้นๆ

    public function update_assessment_applicant($app_id, $exam_schedule_id, $tool_type)

    {

        $data = [

            "assessment_status" => '1',

        ];



        $condition = [
            "app_id" => $app_id,
            "exam_schedule_id" => $exam_schedule_id,
            "asm_tool_type" => $tool_type
        ];

        return $this->BaseModel->update("assessment_applicant", $data, $condition);
    }





    // ดึงข้อมูลรายละเอียดข้อสอบ

    public function get_template_detail($template_id)

    {

        $sql = " SELECT * FROM tp_qans

                WHERE template_id = '" . $template_id . "' ";

        return $this->BaseModel->get_all($sql);
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

                $rs1 = $this->BaseModel->delete("assessment_detail_simulation", ["assessment_id" => $str_assessment_id["assessment_id"]]);

                return 1;
            } else {

                return 0;
            }
        } else {

            return 1;
        }
    }



    public function insert_assessment($assessment, $json_ass_detail, $tool_type)

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

                        // "answer" => $item->answer,

                        "assessment_id" => $assessment_id,

                    ];



                    $rs = $this->BaseModel->insert("assessment_detail_simulation", $arr_list);
                }
            }



            if ($rs) {

                $rs = $this->update_assessment_applicant(

                    $assessment["app_id"],

                    $assessment["exam_schedule_id"],
                    $tool_type
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





    public function save_assessment_detail_file($data, $assessment_id)

    {



        for ($i = 0; $i < COUNT($data); $i++) {

            $arr_list = [

                "name_file" => $data[$i]['name'],

                "path_file" => $data[$i]['file'],

                "create_date" => date('Y-m-d h:i:s'),

                "assessment_id" => $assessment_id,

            ];

            $rs = $this->BaseModel->insert("assessment_detail_simulation_file", $arr_list);
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
}