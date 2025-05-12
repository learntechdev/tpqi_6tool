<?php
class CriteriaToolModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("/BaseModel");
        $this->load->model("masterdata/MasterDataModel");
    }

    public function search($filter = array())
    {

        $condition = '';
        if ($filter["tp_created_date_start"]) {
            $date_start = $this->BaseModel->dateToSQL($filter["tp_created_date_start"]);
            $condition .= " AND date(created_date) >= '" . $date_start . "' ";
        }

        if ($filter["tp_created_date_end"]) {
            $date_end = $this->BaseModel->dateToSQL($filter["tp_created_date_end"]);
            $condition .= " AND date(created_date) <= '" . $date_end . "' ";
        }

        if ($filter['keyword'] != '') {
            $condition .= " AND CONCAT(title,' ',description) like '%" . trim($filter['keyword']) . "%' ";
        }

        $condition .= "ORDER BY criteria_type_id DESC ";
        $sql = " SELECT * FROM settings_criteria_advise_type WHERE 1 " . $condition;
        //print_r($sql);
        return $this->BaseModel->get_all_pagination($sql, $filter["page_no"], $filter["per_page"]);
    }

    public function get_detail($criteria_type_id)
    {
        $sql = " SELECT * FROM settings_criteria_advise_type WHERE criteria_type_id = '" . $criteria_type_id . "' ";
        return $this->BaseModel->get_one_field($sql);
    }

    public function save_criteria($filter)
    {
        $date = date("Y-m-d H:i:s");
        if ($filter['form_type'] == 'create') {
            $sql = "INSERT INTO settings_criteria_advise_type (criteria_type_id, title, description, criteria, min_score, max_score, type, occ_level_id, created_date, last_update_date, status)
            VALUES (NULL, '" . $filter['title'] . "',  '" . $filter['description'] . "', '', '" . $filter['min_score'] . "', '" . $filter['max_score'] . "', '1', '0', '" . $date . "', '" . $date . "', '" . $filter['status'] . "')";
            $query = $this->db->query($sql);
        } else {
            $sql = "UPDATE settings_criteria_advise_type SET
            title = '" . $filter['title'] . "',
            description = '" . $filter['description'] . "',
            min_score = '" . $filter['min_score'] . "',
            max_score = '" . $filter['max_score'] . "',
            last_update_date = '" . $date . "',
            status = '" . $filter['status'] . "'

             WHERE settings_criteria_advise_type.criteria_type_id = '" . $filter['criteria_type_id'] . "' ";
            $query = $this->db->query($sql);
        }
        return $filter;
    }

}
