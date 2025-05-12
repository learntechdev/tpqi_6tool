<?php
class ExamResultModel extends CI_Model
{
    public function __construct()
    {

        parent::__construct();
        $this->load->model("/BaseModel");
        $this->load->model("masterdata/MasterDataModel");
        $this->load->model("shared/SharedModel");
    }

    public function get_examresult($keyword)
    {

        $sql = "";
        $sql = " SELECT * FROM  exam_schedule
                WHERE assessment_status = '1' AND get_examresult_status ='0' ";
        if ($keyword != "") {
            $sql .= " AND tpqi_exam_no = '" . $keyword . "' ";
        }

        $query = $this->db->query($sql);
        $status = "";
        $msg = "";

        if ($query->num_rows() > 0) {
            $status = "1";
            $msg = "พบข้อมูล";
        } else {
            $status = "0";
            $msg = "ไม่พบข้อมูล";
        }

        $results = [
            "status_code" => $status,
            'message' => $msg,

        ];

        foreach ($query->result() as $row) {
            $results["result"][] = $this->build_fields($row);
        }
        return $results;
    }

    private function build_fields($row)
    {
        $dict = array(
            'exam_schedule_id' => $row->exam_schedule_id,
            'tpqi_exam_no' => $row->tpqi_exam_no,
            'org_id' => $row->org_id,
            'org_name' => $row->org_name,
            'occ_level_id' => $row->occ_level_id,
            'occ_level_name' => $row->occ_level_name,
            'method_id' => $row->asm_tool_type,
            "asm_tool_type" => $this->SharedModel->get_tool_type_name($row->asm_tool_type)['name'],
            'start_date' => $row->start_date,
            "end_date" => $row->end_date,
            "exam_time" => $row->exam_time,
            "site_address_id" => $row->site_address_id,
            'place' => $row->place,
            'list_applicant' => $this->get_exam_listapplicant($row->tpqi_exam_no, $row->asm_tool_type),
        );
        return $dict;
    }

    private function get_exam_listapplicant($sch_id, $tool_type)
    {
        $sql = " SELECT assessment_id,app_id,(select citizen_id from assessment_applicant
                        WHERE app_id = assessment.app_id limit 0,1)
                    as citizen_id,tool_type,exam_schedule_id,
        total_score,full_score,
        exam_percent_score,exam_result,recomment,
        DATE_FORMAT(assessment_date,'%Y-%m-%d') AS assessment_date
        FROM  assessment
        WHERE exam_schedule_id  = '" . $sch_id . "'
        AND tool_type = '" . $tool_type . "' ";
        $query = $this->db->query($sql);
        $results = [];
        foreach ($query->result() as $row) {
            $results[] = $this->build_fields_applicant($row);
        }
        return $results;
    }

    private function build_fields_applicant($row)
    {

        // echo print_r($row->app_id);

        $dict = array(
            "app_id" => $row->app_id,
            "citizen_id" => $row->citizen_id,
            "total_score" => $row->total_score,
            "full_score" => $row->full_score,
            "exam_percent_score" => $row->exam_percent_score,
            "exam_result" => $row->exam_result,
            "recomment" => $row->recomment,
            "assessment_date" => $row->assessment_date,
            "assessment_file" => $this->get_assessment_file($row->assessment_id, $row->app_id, $row->exam_schedule_id, $row->tool_type),
        );
        return $dict;
    }

    private function get_assessment_file($assessment_id, $app_id, $exam_schedule_id, $tool_type)
    {

        if ($tool_type == '2') {

            $sql = " SELECT CONCAT('https://tpqi.codehansa.com/portfolio_file/" . $app_id . "/',file) as file

            FROM  exam_person_portfolio

            WHERE app_id  = '" . $app_id . "'

            AND exam_schedule_id = '" . $exam_schedule_id . "'  ";
        } else if ($tool_type == '3') {

            $sql = " SELECT CONCAT('https://tpqi.codehansa.com/',filename) as file
            FROM  assessment_upload_files
            WHERE app_id   = '" . $app_id . "'
            AND exam_schedule_id = '" . $exam_schedule_id . "'  ";
        } else if ($tool_type == '4') {

            $sql = " SELECT CONCAT('https://tpqi.codehansa.com/simulation_assessment_flie/" . $app_id . "/',path_file) as file

            FROM  assessment_detail_simulation_file

            WHERE assessment_id  = '" . $assessment_id . "' ";
        } else if ($tool_type == '5') {

            $sql = " SELECT CONCAT('https://tpqi.codehansa.com/demonstration_assessment_flie/" . $app_id . "/',path_file) as file

            FROM  assessment_detail_demonstration_file

            WHERE assessment_id  = '" . $assessment_id . "' ";
        } else if ($tool_type == '6') {

            $sql = " SELECT CONCAT('https://tpqi.codehansa.com/observation_assessment_flie/" . $app_id . "/',path_file) as file

            FROM  assessment_detail_observation_file

            WHERE assessment_id  = '" . $assessment_id . "' ";
        } else if ($tool_type == '7') {

            $sql = " SELECT CONCAT('https://tpqi.codehansa.com/thirdparty_assessment_flie/" . $app_id . "/',path_file) as file

            FROM  assessment_detail_thirdparty_file

            WHERE assessment_id  = '" . $assessment_id . "' ";
        }

        return $this->BaseModel->get_all($sql);
    }

    public function confirm_get_examresult($data)
    {

        if (COUNT($data) > 0) {

            $tpqi_exam_no_arr = array();

            for ($i = 0; $i < COUNT($data); $i++) {

                // echo $data[$i]->exam_schedule_id;

                if (isset($data[$i]->tpqi_exam_no)) {

                    array_push($tpqi_exam_no_arr, "'" . $data[$i]->tpqi_exam_no . "'");
                } else {

                    $rs = [

                        "status_code" => "0",

                        'message' => "Invalid Input",

                    ];

                    return $rs;
                }
            }

            $tpqi_exam_no = implode(",", $tpqi_exam_no_arr);

            $sql = "UPDATE exam_schedule SET get_examresult_status = '1' WHERE exam_schedule.tpqi_exam_no in ($tpqi_exam_no) ";

            $result = $this->db->query($sql);

            if ($result) {

                $rs = [

                    "status_code" => "1",

                    'message' => "success",

                    'tpqi_exam_no' => $data,

                ];
            } else {

                $rs = [

                    "status_code" => "0",

                    'message' => "เกิดข้อผิดพลาด",

                ];
            }
        } else {

            $rs = [

                "status_code" => "0",

                'message' => "ไม่พบข้อมูล",

            ];
        }

        return $rs;
    }
}