<?php
class BaseModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /** ฟังก์ชันสำหรับ insert */
    public function insert($table, $data)
    {
        $result = "";
        try {
            $this->db->trans_start();
            $query = $this->db->insert("$table", $data);
            $this->db->trans_commit();
            $result = 1;
        } catch (Exception $e) {
            $this->db->trans_rollback();
            //$result = 0;
            $result = $e->getMessage();
        }
        return $result;
    }

    /** ฟังก์ชันสำหรับ update */
    public function update($table, $data, $condition)
    {
        $result = "";
        try {
            $this->db->trans_start();
            $this->db->where($condition);
            $this->db->update("$table", $data);
            $this->db->trans_commit();
            $result = 1;
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $result = 0;
        }
        return $result;
    }

    /** สำหรับลบข้อมูล */
    public function delete($table, $condition)
    {
        $result = "";
        try {
            $this->db->trans_start();
            $this->db->where($condition);
            $this->db->delete("$table");
            $this->db->trans_commit();
            $result = 1;
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $result = 0;
        }
        return $result;
    }

    public function get_all($sql)
    {
        $query = $this->db->query($sql);
        $result_arr = $query->result();
        if ($query->num_rows() > 0) {
            return $result_arr;
        } else {
            return "";
        }
    }

    public function get_all_arr($sql)
    {
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        if ($query->num_rows() > 0) {
            return $result_arr;
        } else {
            return "";
        }
    }

    public function get_all_rowarr($sql)
    {
        $query = $this->db->query($sql);
        $result_arr = $query->row_array();
        if ($query->num_rows() > 0) {
            return $result_arr;
        } else {
            return "";
        }
    }

    public function get_one_field($sql)
    {
        $query = $this->db->query($sql);
        $result = $query->row_array();
        return $result;
    }

    public function get_num_rows($sql)
    {
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function get_all_pagination($sql, $page_no, $per_page)
    {
        $param["query"] = $sql;

        if ($page_no) {
            $param["page_no"] = $page_no;
        } else {
            $param["page_no"] = 1;
        }

        if ($per_page) {
            $param["per_page"] = $per_page;
        }

        $result = $this->pagination($param);
        return $result;
    }

    public function pagination($param)
    {
        if (isset($param["page_no"])) {
            $page = $param["page_no"];
        } else {
            $page = 1;
        }
        if (isset($param["query"])) {
            $query = $param["query"];
            $result = $this->db->query($query);
            $numRowsAll = $result->num_rows();
            if (!isset($param["per_page"])) {
                $perPage = $numRowsAll;
            } else {
                $perPage = $param["per_page"];
            }

            $startRow = ($page - 1) * $perPage;

            $queryLimit = $query . "
                limit   " . $startRow . "," . $perPage . "
            ";
            $result = $this->db->query($queryLimit);

            if ($result) {
                if ($result->num_rows()) {
                    foreach ($result->result_array() as $key => $row) {
                        $data[] = $row;
                    }
                } else {
                    return false;
                }
            } else {
                echo "<pre>" . $query . "</pre>";
            }
        } else {
            $data = $param["data"];
        }
        if (isset($param["displayAll"])) {
            $full = $param["displayAll"];
        } else {
            $full = false;
        }
        if ($full) {
            $perPage = count($data);
        } else {
            if (!isset($param["page_page"])) {
            } else {
                $perPage = $param["per_page"];
            }
        }

        if (is_array($data) && count($data) > 0) {
            $count = 0;
            $elementID = 0;
            $perPageCount = 0;

            $maxPage = ceil($numRowsAll / $perPage);
            $itemCount = $numRowsAll;

            if (isset($param["query"])) {
                $temp = $data;
            } else {
                $temp = array();
                foreach ($data as $key => $value) {
                    if ($elementID >= (($page - 1) * $perPage)) {
                        $temp[$key] = $value;
                        $perPageCount++;
                        if ($perPageCount >= $perPage) {
                            break;
                        }
                    }
                    $count++;
                    $elementID++;

                    if ($count >= $perPage) {
                        $count = 0;
                    }
                }
            }
            $returnValue["numRowsAll"] = $numRowsAll;
            $returnValue["pageNo"] = $page;
            $returnValue["perPage"] = $perPage;
            $returnValue["maxPage"] = $maxPage;
            $returnValue["result"] = $temp;
            if (isset($query)) {
                $returnValue["query"] = $query;
            }
            //return $this->log_var($returnValue);
            return $returnValue;
        } else {
            return false;
        }
    }

    public function dateToThai($date, $isTime = true)
    {
        if (trim($date) == "") {
            return "";
        }
        $temp = explode(" ", $date);
        if (count($temp) > 1) {
            $date = $temp[0];
            $time = substr($temp[1], 0, 5);
            if ($isTime) {
                $isTime = true;
            }
        } else {
            $date = $temp[0];
            if ($isTime) {
                $isTime = false;
            }
        }

        $temp = explode("-", $date);
        $yearNum = $temp[0];
        $monNum = $temp[1];
        $dayNum = $temp[2];

        $dayNum = (int) $dayNum;

        if ($isTime) {
            return $dayNum . " " . $this->monShortNameTH($monNum) . " " . ($yearNum + 543) . " " . $time;
        } else {
            return $dayNum . " " . $this->monShortNameTH($monNum) . " " . ($yearNum + 543);
        }
    }

    public function monShortNameTH($monNum)
    {
        switch ($monNum) {
            case "01":
                return "ม.ค.";
            case "02":
                return "ก.พ.";
            case "03":
                return "มี.ค.";
            case "04":
                return "เม.ย.";
            case "05":
                return "พ.ค.";
            case "06":
                return "มิ.ย.";
            case "07":
                return "ก.ค.";
            case "08":
                return "ส.ค.";
            case "09":
                return "ก.ย.";
            case "10":
                return "ต.ค.";
            case "11":
                return "พ.ย.";
            case "12":
                return "ธ.ค.";
        }
    }

    public function dateToSQL($date)
    {
        // echo "DATE : ".$date."<br>";
        $dateTimeArr = explode(" ", $date);

        if (count($dateTimeArr) == 1) {
            $dateArr = explode("/", $dateTimeArr[0]);

            // echo "Offset2:".$dateArr[2]."<br>";

            return ($dateArr[2] - 543) . "-" . (str_pad($dateArr[1], 2, 0, STR_PAD_LEFT)) . "-" . (str_pad($dateArr[0], 2, 0, STR_PAD_LEFT));
        } else {
            $dateArr = explode("/", $dateTimeArr[0]);
            if (isset($dateTimeArr[1])) {
                $time = $dateTimeArr[1];
            }
            return ($dateArr[2] - 543) . "-" . (str_pad($dateArr[1], 2, 0, STR_PAD_LEFT)) . "-" . (str_pad($dateArr[0], 2, 0, STR_PAD_LEFT));
        }
    }

    public function dateThaiToInput($date, $displayTime = false)
    {
        if ($date == "0000-00-00 00:00:00") {
            return false;
        } else if (trim($date) != "") {
            $dateTimeArr = explode(" ", $date);
            $dateArr = explode("-", $dateTimeArr[0]);
            if ($displayTime) {
                return ($dateArr[2]) . "/" .  $dateArr[1] . "/" . ($dateArr[0] + 543) . " " . $dateTimeArr[1];
            } else {
                return ($dateArr[2]) . "/" .  $dateArr[1] . "/" . ($dateArr[0] + 543);
            }
        } else {
            return false;
        }
    }

    private function log_var($var, $is_die = false)
    {
        echo "<pre>";
        echo var_export($var, true);
        echo "</pre>";
        if ($is_die) {
            die();
        }
    }
}