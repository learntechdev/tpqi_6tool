<?php
class ExamlibraryModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("/BaseModel");
    }

    public function get_all($filter = array())
    {
        $tool = $filter["tool_type"];
        $condition = "";
		

        if ($filter["occ_level_id"] != "") {
            $condition = " AND exam_b.occ_level_id = '" . $filter["occ_level_id"] . "' ";
        }

        if ($filter["tp_created_date_start"] != "" && $filter["tp_created_date_end"] != "") {
            $date_start = $this->BaseModel->dateToSQL($filter["tp_created_date_start"]);
            $date_end = $this->BaseModel->dateToSQL($filter["tp_created_date_end"]);

            $condition .= " AND date(exam_b.created_date)
                            BETWEEN '" . $date_start . "' AND '" . $date_end . "' ";
        }
        //start line 29 end line 31 uncomment for filter by contract_no  add by dith 25/10/2566
         if ($filter['contract_no'] != "") {
            $condition = " AND exam_b.contract_no = '" . $filter["contract_no"] . "' ";
        }
        //start line 29 end line 31 uncomment for filter by contract_no  add by dith 25/10/2566

        if ($_SESSION['user_type'] != '8') {
			
            /* $sql = " SELECT exam_b.occ_level_id, CONCAT( IFNULL(tier1_title, ''), ' ', IFNULL(tier2_title, ''), ' ', IFNULL(tier3_title, ''), ' ', 		IFNULL(level_name, '') ) as levelName,
                    count(template_id) AS num_template FROM exam_blueprint exam_b
            LEFT JOIN standard_qualification occ
            ON exam_b.occ_level_id = occ.id
			INNER JOIN user_access_occlevel acclevel ON exam_b.occ_level_id = acclevel.occ_level_id and acclevel.user_id='" . $_SESSION['user_id'] . "' ".
            " WHERE exam_b.is_used = '1'
            AND exam_b.tool_type ='" . $tool . "'" . $condition .
            " GROUP BY occ_level_id
            ORDER BY  exam_b.created_date DESC ";*/
			
			$sql = " SELECT exam_b.occ_level_id, CONCAT( IFNULL(tier1_title, ''), ' ', IFNULL(tier2_title, ''), ' ', IFNULL(tier3_title, ''), ' ', 		IFNULL(level_name, '') ) as levelName,
                    count(template_id) AS num_template FROM exam_blueprint exam_b
            LEFT JOIN standard_qualification occ
            ON exam_b.occ_level_id = occ.id
			INNER JOIN user_access_occlevel acclevel ON exam_b.occ_level_id = acclevel.occ_level_id  ".
            " WHERE exam_b.is_used = '1'
            AND exam_b.tool_type ='" . $tool . "'" . $condition .
            " GROUP BY occ_level_id
            ORDER BY  exam_b.created_date DESC ";
			
			
			// $condition .= " AND created_by = '" . $_SESSION['user_id'] . "' ";
        }else{
			  $sql = " SELECT exam_b.occ_level_id, CONCAT( IFNULL(tier1_title, ''), ' ', IFNULL(tier2_title, ''), ' ', IFNULL(tier3_title, ''), ' ', 		IFNULL(level_name, '') ) as levelName,
                    count(template_id) AS num_template FROM exam_blueprint exam_b
            LEFT JOIN standard_qualification occ
            ON exam_b.occ_level_id = occ.id
            WHERE exam_b.is_used = '1'
            AND exam_b.tool_type ='" . $tool . "'" . $condition .
            " GROUP BY occ_level_id
            ORDER BY  exam_b.created_date DESC ";
			
			
		}

       /* $sql = " SELECT occ_level_id, CONCAT( IFNULL(tier1_title, ''), ' ', IFNULL(tier2_title, ''), ' ', IFNULL(tier3_title, ''), ' ', 		IFNULL(level_name, '') ) as levelName,
                    count(template_id) AS num_template FROM exam_blueprint exam_b
            LEFT JOIN standard_qualification occ
            ON exam_b.occ_level_id = occ.id
            WHERE exam_b.is_used = '1'
            AND exam_b.tool_type ='" . $tool . "'" . $condition .
            " GROUP BY occ_level_id
            ORDER BY created_date DESC ";
			
			*/
			
			
		/*$sql = " 	SELECT occ_level_id, CONCAT( IFNULL(tier1_title, ''), ' ', IFNULL(tier2_title, ''), ' ', IFNULL(tier3_title, ''), ' ', 		IFNULL(level_name, '') ) as levelName,
                    count(template_id) AS num_template FROM exam_blueprint exam_b
            LEFT JOIN standard_qualification occ
            ON exam_b.occ_level_id = occ.id
            WHERE exam_b.is_used = '1'
            AND exam_b.tool_type ='" . $tool . "'" . $condition .
            " GROUP BY occ_level_id
            ORDER BY created_date DESC "
			";
			
			*/

        //print_r($sql);
        return $this->BaseModel->get_all_pagination($sql, $filter["page_no"], $filter["per_page"]);
    }

    public function get_template($occ_level_id, $tool_type)
    {
        $condition = "";
        if ($_SESSION['user_type'] == '8') {
            $condition .= " AND created_by = '" . $_SESSION['user_id'] . "' ";
        }

        /*$sql = " SELECT * FROM exam_blueprint
                WHERE SUBSTRING_INDEX(occ_level_id, ':',1) = '" . $occ_level_id . "'
                AND tool_type ='" . $tool_type . "'
                AND is_used = '1' " . $condition;
                */
        $sql = " SELECT * FROM exam_blueprint
                WHERE occ_level_id = '" . $occ_level_id . "'
                AND tool_type ='" . $tool_type . "'
                AND is_used = '1' ";
        return $this->BaseModel->get_all($sql);
    }

    public function cancel_data($tp_id)
    {
        $data = [
            "is_used" => '0',
        ];

        $condition = [
            "template_id" => $tp_id,
        ];

        return $this->BaseModel->update("exam_blueprint", $data, $condition);
    }

    public function get_examblueprint()
    {
        $sql = " SELECT tooltype_id, tooltype_name,COUNT(b.template_id) as exam_total FROM settings_tooltype t 
                   LEFT JOIN exam_blueprint b 
                   ON t.tooltype_id = b.tool_type
                   GROUP BY t.tooltype_id ";
        $result = $this->BaseModel->get_all($sql);

        foreach ($result as $v) {
            $labels[] = $v->tooltype_name;
            $data[] = $v->exam_total;
        }

        return [
            "labels" => $labels,
            "data" =>  $data,
            "dt" => $result
        ];
    }
	
	public function approve_review_exam($status, $template_id, $reason_disapprove)
    {
        $send_approve = $status == 1 ? "1" : "";
        $data = ["exam_status" => $status, "send_approve" => $send_approve];
        $condition = ["template_id" => $template_id];
        $exam_status = $this->BaseModel->update("exam_blueprint", $data, $condition);
        if ($exam_status) {
            $rs  = $this->log_exam_status($status, $template_id, $reason_disapprove, "");
            return $rs;
        } else {
            return 0;
        }
    }
	
	private function log_exam_status($status, $template_id, $reason_disapprove, $exam_schedule_id)
    {
        $data = [
            "template_id" => $template_id,
            "exam_schedule_id" => $exam_schedule_id,
            "status" => $status,
            "reason_disapprove" => $reason_disapprove,
            "created_date" => date('Y-m-d H:i:s'),
            "created_by" => $_SESSION["user_id"],
        ];
        return  $this->BaseModel->insert("exam_status", $data);
    }
}