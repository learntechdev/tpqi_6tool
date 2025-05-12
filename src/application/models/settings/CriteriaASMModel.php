<?php
class CriteriaASMModel extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->model("/BaseModel");
    }

    public function get_all($filter = array()) {
        $sql = " SELECT * FROM settings_occ_level ";
        return $this->BaseModel->get_all_pagination($sql, $filter["pageNo"], $filter["perPage"]);
    }
}
?>