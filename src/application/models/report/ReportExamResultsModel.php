<?php
class ReportExamResultsModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("/BaseModel");
        $this->load->model("masterdata/MasterDataModel");
    }

    public function exam_results($filter = array())
    {
        $data = array();
        $data['pass'] = 0;
        $data['no_pass'] = 0;

        $data['portfolio_pass'] = 0;
        $data['interview_pass'] = 0;
        $data['simulation_pass'] = 0;
        $data['demonstration_pass'] = 0;
        $data['observation_pass'] = 0;
        $data['thirdparty_pass'] = 0;

        $data['portfolio_no_pass'] = 0;
        $data['interview_no_pass'] = 0;
        $data['simulation_no_pass'] = 0;
        $data['demonstration_no_pass'] = 0;
        $data['observation_no_pass'] = 0;
        $data['thirdparty_no_pass'] = 0;

        $condition = '';
        /*  if ($filter["tp_created_date_start"]) {

        }*/

        $sql = " SELECT tool_type,exam_result,COUNT(*) as nums FROM assessment GROUP BY tool_type,exam_result
        " . $condition;
        $result = $this->db->query($sql);
        //$result_data = $result->row_array();
        foreach ($result->result() as $row) {
            // echo $row->exam_result . ' ';
            if ($row->exam_result == 'ผ่าน') {
                $data['pass'] += $row->nums;
                if ($row->tool_type == '2') {
                    $data['portfolio_pass'] += $row->nums;
                } else if ($row->tool_type == '3') {
                    $data['interview_pass'] += $row->nums;
                } else if ($row->tool_type == '4') {
                    $data['simulation_pass'] += $row->nums;
                } else if ($row->tool_type == '5') {
                    $data['demonstration_pass'] += $row->nums;
                } else if ($row->tool_type == '6') {
                    $data['observation_pass'] += $row->nums;
                } else if ($row->tool_type == '7') {
                    $data['thirdparty_pass'] += $row->nums;
                }
            } else {
                $data['no_pass'] += $row->nums;
                if ($row->tool_type == '2') {
                    $data['portfolio_no_pass'] += $row->nums;
                } else if ($row->tool_type == '3') {
                    $data['interview_no_pass'] += $row->nums;
                } else if ($row->tool_type == '4') {
                    $data['simulation_no_pass'] += $row->nums;
                } else if ($row->tool_type == '5') {
                    $data['demonstration_no_pass'] += $row->nums;
                } else if ($row->tool_type == '6') {
                    $data['observation_no_pass'] += $row->nums;
                } else if ($row->tool_type == '7') {
                    $data['thirdparty_no_pass'] += $row->nums;
                }
            }
        }

        $data['result_total'] = $data['pass'] + $data['no_pass'];

        // echo print_r($data);

        return $data;
    }

    public function search($filter = array())
    {

        $condition = '';
        if ($filter["tp_created_date_start"]) {
            $date_start = $this->BaseModel->dateToSQL($filter["tp_created_date_start"]);
            $condition .= " AND date(assessment_date) >= '" . $date_start . "' ";
        }

        if ($filter["tp_created_date_end"]) {
            $date_end = $this->BaseModel->dateToSQL($filter["tp_created_date_end"]);
            $condition .= " AND date(assessment_date) <= '" . $date_end . "' ";
        }

        if ($filter['keyword'] != '') {
            $condition .= " AND CONCAT(exam_schedule_id) like '%" . trim($filter['keyword']) . "%' ";
        }

        $condition .= "GROUP BY exam_schedule_id,tool_type ";
        $condition .= "ORDER BY assessment_id DESC ";

        $sql = " SELECT *,SUM(exam_result = 'ผ่าน' ) as nums_pass,SUM(exam_result = 'ไม่ผ่าน' ) as nums_no_pass,COUNT(*) as nums_user
        FROM assessment WHERE 1 " . $condition;
        //print_r($sql);
        return $this->BaseModel->get_all_pagination($sql, $filter["page_no"], $filter["per_page"]);
    }

    public function detailRoundExamResult($filter)
    {
        $tpqi_exam_no = $filter["tpqi_exam_no"];
        $tool_type = $filter["tool_type"];

        $sql = " SELECT ass.exam_schedule_id,ass.app_id,ass.total_score, ass.full_score,ass.exam_percent_score,
        ass.exam_result, ass.recomment,
         CONCAT(person.initial_name,person.name,' ', person.lastname) AS fullname FROM assessment ass
                LEFT JOIN assessment_applicant person 
                ON ass.app_id = person.app_id
                WHERE ass.exam_schedule_id = '" . $tpqi_exam_no . "'
                AND  ass.tool_type = '" . $tool_type . "' ";

        return $this->BaseModel->get_all_pagination($sql, $filter["page_no"], $filter["per_page"]);
    }
}