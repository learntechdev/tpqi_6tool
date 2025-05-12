<?php

class ThirdpartyToolsModel extends CI_Model

{

    public function __construct()

    {

        parent::__construct();

        $this->load->model("/BaseModel");
    }





    public function insert_assessment($assessment, $assessment_detail, $tool_type)

    {

        $messag = "";

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

            $detail_arr = json_decode(json_encode($assessment_detail), true);



            for ($i = 0; $i < COUNT($detail_arr); $i++) {



                if ($detail_arr[$i]['criteria_used_byexamier'] == '1') {

                    if ($detail_arr[$i]['score'] == '') {

                        $detail_arr[$i]['score'] = '0';
                    }
                }



                $assessment_detail_insert = [

                    "tp_checklist_id" => $detail_arr[$i]["tp_checklist_id"],

                    "app_id" => $assessment["app_id"],

                    "assessment_id" => $assessment_id,

                    "score" => $detail_arr[$i]['score'] != '' ? $detail_arr[$i]['score'] : null,

                    "exam_status" => $detail_arr[$i]['exam_status'] != '' ? $detail_arr[$i]['exam_status'] : null,

                    "criteria_used_byexamier" => $detail_arr[$i]['criteria_used_byexamier'],

                ];

                $rs = $this->db->insert('assessment_detail_thirdparty', $assessment_detail_insert);
            }



            if ($rs) {

                $rs = $this->update_assessment_applicant(

                    $assessment["app_id"],

                    $assessment["exam_schedule_id"],
                    $tool_type
                );

                $message = [

                    "status" => '1',

                    "assessment_id" => $assessment_id

                ];
            } else {

                $message = [

                    "status" => '0',

                ];
            }

            return $message;
        }
    }



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



    public function ck_template_uoc($template_id, $uoc_code)

    {



        $sql = " SELECT * FROM template_portfolio

        WHERE uoc_code = '" . $uoc_code . "'

        AND blueprint_id = '" . $template_id . "' ";

        $num_row = $this->BaseModel->get_num_rows($sql);

        if ($num_row > 0) {

            return 1;
        } else {

            return 0;
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

            $rs = $this->BaseModel->insert("assessment_detail_thirdparty_file", $arr_list);
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