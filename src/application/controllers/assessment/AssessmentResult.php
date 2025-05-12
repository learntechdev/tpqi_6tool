<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AssessmentResult extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //$this->load->model("masterdata/MasterDataModel");
        $this->load->model("v2/assessment/AssessmentResultModel");
        // $this->load->model("shared/SharedModel");
    }

    public function insert_ass_longanswer()
    {
        $rs = "";
        $json = str_replace(array("\t", "\n"), "", $_POST["dt"]);
        $data = json_decode($json);

        if ($data->action == "create") {
            $app_id = $data->app_id;
            $exam_schedule_id = $data->exam_schedule_id;
            $tool_type = $_POST['tool_type'];

            $total_score = "";
            $exam_percent_score = "";
            $full_score = "";
            $type = "";
            if ($data->criteria_used_byexamier == '0') {
                $total_score = "";
                $exam_percent_score = "";
                $full_score = "";
                $type = '1';
            } else {
                $total_score = $data->total_score;
                $exam_percent_score = $data->exam_percent_score;
                $full_score = $data->full_score;
                $type = '2';
            }

            $assessment = [
                "exam_schedule_id" => $exam_schedule_id,
                "app_id" => $app_id,
                "tool_type" => $tool_type,
                "total_score" => $total_score,
                "full_score" => $full_score,
                "exam_percent_score" => $exam_percent_score,
                "exam_result" => $data->exam_result,
                "recomment" => $data->recomment,
                "assessment_date" => date('Y-m-d H:i:s'),
                "type" => $type
            ];

            //เช็คว่ามีข้อมูลอยู่ใน db หรือยัง ถ้ามีให้ลบออกก่อน
            $chk_old_data = $this->AssessmentResultModel->is_valid_assessment($exam_schedule_id, $app_id, $tool_type);

            $rs = '';
            if ($chk_old_data != "0") {
                $rs = $this->AssessmentResultModel->insert_ass_result($assessment, $data->list, $tool_type);
            }
            echo json_encode($rs);
        }
    }
}