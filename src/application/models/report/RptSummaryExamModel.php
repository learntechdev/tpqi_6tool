<?php
class RptSummaryExamModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("/BaseModel");
        $this->load->model("masterdata/MasterDataModel");
    }

    public function getSummaryExam($filter = array())
    {

        $sql = " SELECT CONCAT(std.tier1_title,'',std.tier2_title,' ',std.tier3_title,' ',std.level_name) AS occ,
        COUNT(CASE WHEN e.tool_type = '2' THEN 1 END) tool2, 
        COUNT(CASE WHEN e.tool_type = '3' THEN 1 END) tool3, 
        COUNT(CASE WHEN e.tool_type = '4' THEN 1 END) tool4, 
        COUNT(CASE WHEN e.tool_type = '5' THEN 1 END) tool5, 
        COUNT(CASE WHEN e.tool_type = '6' THEN 1 END) tool6,
        COUNT(CASE WHEN e.tool_type = '7' THEN 1 END) tool7  
        FROM exam_blueprint e 
        RIGHT JOIN standard_qualification std 
        ON e.occ_level_id = std.id 
        WHERE e.send_approve = '1' 
        AND e.is_used = '1'
        AND std.status = '1'
        GROUP BY e.occ_level_id ";

        return $this->BaseModel->get_all_pagination($sql, $filter["page_no"], $filter["per_page"]);
    }
}