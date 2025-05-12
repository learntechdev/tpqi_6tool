<?php
class UserlogModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("/BaseModel");
        $this->load->model("masterdata/MasterDataModel");
    }

    public function get_userlog($filter = array())
    {

        $condition = '';
        if ($filter["tp_created_date_start"]) {
            $date_start = $this->BaseModel->dateToSQL($filter["tp_created_date_start"]);
            $condition .= " AND date(date_action) >= '" . $date_start . "' ";
        }

        if ($filter["tp_created_date_end"]) {
            $date_end = $this->BaseModel->dateToSQL($filter["tp_created_date_end"]);
            $condition .= " AND date(date_action) <= '" . $date_end . "' ";
        }

        if ($filter['asm_tool'] != '') {
            $condition .= " AND menu_name = '" . $filter['asm_tool'] . "' ";
        }

        if ($filter['log_action'] != '') {
            $condition .= " AND action = '" . $filter['log_action'] . "' ";
        }

        $condition .= "ORDER BY date_action DESC ";
        $sql = " SELECT * FROM user_log
                LEFT JOIN user_login
                ON user_log.action_by = user_login.id
                WHERE 1 " . $condition;
        //print_r($sql);
        return $this->BaseModel->get_all_pagination($sql, $filter["page_no"], $filter["per_page"]);
    }
}
