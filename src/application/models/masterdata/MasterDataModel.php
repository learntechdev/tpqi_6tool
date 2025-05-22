<?php
class MasterDataModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("/BaseModel");
    }

    /*public function breadcrumb_interview()
    {
    $bc = [
    ["node"=>"หน้าแรก", "active_node" =>"", "icon"=>"<i class='icon-home2 mr-2'></i>", "url"=>"../../asmtools/asmtools/index"],
    ["node"=>"สัมภาษณ์", "active_node" =>"", "icon" => "", "url"=>"../../exam_library/Examlibrary/index"],
    ["node" => "สร้างชุดข้อสอบ", "active_node" =>"active", "icon" => "", "url"=>"InterviewTool/create"],
    ];
    return $bc;
    }*/

    public function count_exam($tool_type, $contractNo)
    {
        $condition = "";
        if ($_SESSION['user_type'] != '8') { //ผู้ดูแลระบบ
            $condition .= " AND created_by = '" . $_SESSION['user_id'] . "' ";
        }

        $sql = " SELECT COUNT(*) as num_exam FROM exam_blueprint 
                WHERE tool_type = '" . $tool_type . "'
                AND contract_no = '" . $contractNo . "'
                AND is_used = '1' " . $condition;

        return $this->BaseModel->get_one_field($sql);
    }

    public function breadcrumb($menu_id)
    {
        $sql = " SELECT * FROM settings_menus WHERE menu_id in ($menu_id) ORDER BY node ASC ";
        return $this->BaseModel->get_all($sql);
    }

    //ดึงเมนูการใช้งาน
    public function get_menu()
    {
        $sql = "";
        if (!empty($_SESSION["role_id"]) && $_SESSION["user_type"] != '8') {
            $role = $_SESSION["role_id"];
            $p =  str_replace("'", "", $_SESSION["role_id"]);
            $x = explode(',', $p);

            if (in_array('54', $x)) {
              $sql = " SELECT * FROM user_menu WHERE is_used = '1'
              ORDER BY order_line ASC ";
				  
            } else {
                $sql = " SELECT * FROM user_menu 
                            WHERE is_used = '1' 
                            AND role_id in($role) 
                        ORDER BY order_line ASC ";
            }
        } else {
            $sql = " SELECT * FROM user_menu WHERE is_used = '1'  
            ORDER BY order_line ASC";
        }

        // print_r($sql);
        //สำหรับใช้บน localhost
        //$sql = " SELECT * FROM user_menu";
        return $this->BaseModel->get_all($sql);
    }

    //สำหรับให้แสดงเมนการใช้งานตามที่ได้กำหนดสิทธิ์ไว้ Change Req 17/11/2564
    public function getMenu()
    {
        $sql = "";

        $menuAuthorized = $_SESSION["menu_authorized"];
		
		//$sql = "   SELECT * FROM user_menu WHERE menu_id in (select tmp2.menu_id from ( select tmp.menu_id, count(tmp.url) c from ( SELECT * //FROM user_menu WHERE menu_id in (  $menuAuthorized  ) AND is_used = '1' ) tmp group by tmp.url having c = 1 ) tmp2) ";
		
		$sql = " SELECT * FROM user_menu WHERE menu_id in (select tmp2.menu_id from ( select (tmp.menu_id), tmp.url from ( SELECT * FROM user_menu WHERE menu_id in ($menuAuthorized) AND is_used = '1' ) tmp group by tmp.url ) tmp2) ORDER BY `user_menu`.`order_line` ASC ";

     
        $data= $this->BaseModel->get_all($sql);
		return $data;
	
    }

    public function getAllMenu()
    {
        $sql = " SELECT * FROM user_menu WHERE is_used = '1'  
            ORDER BY order_line ASC";
		return $this->BaseModel->get_all($sql);
    }
	
	public function getAdminMenu()
    {
		$sql = "SELECT * FROM ( SELECT *, ROW_NUMBER() OVER (PARTITION BY menu_name ORDER BY order_line) AS row_num FROM user_menu WHERE is_used = '1' ) AS distinct_data WHERE row_num = 1";
        return $this->BaseModel->get_all($sql);
    }

    /** ข้อมูลรายชื่อเครื่องมือประเมิน */
    public function asmtools_array()
    {
        $asmtools_arr = array(
            array(
                'id' => 1, 'tool_type' => '2', 'bg_color' => 'bg-success-600', 'icon_path' => '../../assets/img/asm_tools/portfolio.png', 'name_tool' => 'แฟ้มสะสมงาน', 'name_tool_eng' => 'portfolio', 'url' => '../../exam_library/Examlibrary/index?tool_type=2',
                'url_create' => '../../portfolio/PortfolioTools/create'
            ),
            array(
                'id' => 2, 'tool_type' => '3', 'bg_color' => 'bg-orange-300', 'icon_path' => '../../assets/img/asm_tools/interview.png', 'name_tool' => 'สัมภาษณ์', 'name_tool_eng' => 'interview', 'url' => '../../exam_library/Examlibrary/index?tool_type=3',
                'url_create' => '../../interview/InterviewTool/create'
            ),
            array(
                'id' => 3, 'tool_type' => '4', 'bg_color' => 'bg-violet-400', 'icon_path' => '../../assets/img/asm_tools/simulate.png', 'name_tool' => 'จำลองสถานการณ์', 'name_tool_eng' => 'simulation', 'url' => '../../exam_library/Examlibrary/index?tool_type=4',
                'url_create' => '../../simulation/SimulationTools/create'
            ),
            array(
                'id' => 4, 'tool_type' => '5', 'bg_color' => 'bg-danger-600', 'icon_path' => '../../assets/img/asm_tools/practice.png', 'name_tool' => 'สาธิตการปฏิบัติงาน', 'name_tool_eng' => 'demonstration', 'url' => '../../exam_library/Examlibrary/index?tool_type=5',
                'url_create' => '../../demonstration/DemonstrationTools/create'
            ),
            array(
                'id' => 5, 'tool_type' => '6', 'bg_color' => 'bg-blue-400', 'icon_path' => '../../assets/img/asm_tools/binoculars.png', 'name_tool' => 'สังเกตการณ์ ณ หน้างานจริง', 'name_tool_eng' => 'observation', 'url' => '../../exam_library/Examlibrary/index?tool_type=6',
                'url_create' => '../../observation/Observation/create'
            ),
            array(
                'id' => 6, 'tool_type' => '7', 'bg_color' => 'bg-teal-400', 'icon_path' => '../../assets/img/asm_tools/assessment.png', 'name_tool' => 'ประเมินด้วยบุคคลที่สาม', 'name_tool_eng' => 'thirdparty', 'url' => '../../exam_library/Examlibrary/index?tool_type=7',
                'url_create' => '../../tools/Thirdparty/create'
            ),
        );

        if (isset($_SESSION["access_tools"])) {
            $asmtools_arr_access = array();
            for ($i = 0; $i < COUNT($asmtools_arr); $i++) {
                $name_tool_eng = $asmtools_arr[$i]['name_tool_eng'];
                $access_status = $_SESSION["access_tools"][0][$name_tool_eng];

                if ($access_status) {
                    array_push($asmtools_arr_access, $asmtools_arr[$i]);
                }
            }
            $asmtools_arr = $asmtools_arr_access;
        }
        return $asmtools_arr;
    }

    public function exam_schedule_status()
    {
        $status_arr = [
            ["id" => "0", "name" => "ทั้งหมด", "operation" => ""],
            ["id" => "1", "name" => "ยังไม่ได้จัดชุดข้อสอบ", "operation" => "กำหนดชุดข้อสอบ"],
            ["id" => "2", "name" => "จัดชุดข้อสอบแล้ว", "operation" => "กำหนดเกณฑ์การประเมิน"],
            ["id" => "3", "name" => "ยังไม่ได้กำหนดเกณฑ์", "operation" => "กำหนดเกณฑ์การประเมิน"],
            ["id" => "4", "name" => "กำหนดเกณฑ์แล้ว", "operation" => "อนุมัติเกณฑ์การสอบ"],
            ["id" => "5", "name" => "ยังไม่ได้อนุมัติเกณฑ์", "operation" => "อนุมัติเกณฑ์การสอบ"],
            ["id" => "6", "name" => "อนุมัติเกณฑ์แล้ว", "operation" => "เรียบร้อย"],
        ];
        return $status_arr;
    }

    public function tool_type_array()
    {
        $status_arr = [
            ["id" => "0", "tool_type" => "0", "name" => "ทั้งหมด", 'name_eng' => ''],
            ["id" => "1", "tool_type" => "1", "name" => "", 'name_eng' => ''],
            ["id" => "2", "tool_type" => "2", "name" => "แฟ้มสะสมผลงาน", 'name_eng' => 'portfolio'],
            ["id" => "3", "tool_type" => "3", "name" => "สัมภาษณ์", 'name_eng' => 'interview'],
            ["id" => "4", "tool_type" => "4", "name" => "จำลองสถานการณ์", 'name_eng' => 'simulation'],
            ["id" => "5", "tool_type" => "5", "name" => "สาธิตการปฏิบัติงาน", 'name_eng' => 'demonstration'],
            ["id" => "6", "tool_type" => "6", "name" => "สังเกตการณ์ ณ หน้างานจริง", 'name_eng' => 'observation'],
            ["id" => "7", "tool_type" => "7", "name" => "ประเมินด้วยบุคคลที่สาม", 'name_eng' => 'thirdparty'],
        ];
        return $status_arr;
    }

    public function url_create_tool($tool_type)
    {
        $url = "";
        if ($tool_type == "2") {
            $url = "portfolio/PortfolioTools/create";
        } else if ($tool_type == "3") {
            $url = "interview/InterviewTool/create";
        } else if ($tool_type == "4") {
            $url = "simulation/SimulationTools/create";
        } else if ($tool_type == "5") {
            $url = "demonstration/DemonstrationTools/create";
        } else if ($tool_type == "6") {
            $url = 'observation/Observation/create';
        } elseif ($tool_type == "7") {
            $url = 'tools/Thirdparty/create';
        } else {
            $url = "";
        }
        return $url;
    }

    /* ดึงข้อมูลคุณวุฒิวิชาชีพ */
    public function get_occ_level1($filter = array())
    {
        $sql = "";

        $sql = " SELECT id, concat(tier1_title,' ', tier2_title,' ', tier3_title,' ', level_name)
        AS occ_level FROM standard_qualification ";

        if ($_SESSION["role_id"] != "") {
            $p =  str_replace("'", "", $_SESSION["role_id"]);
            $x = explode(',', $p);

            if (!in_array('54', $x)) {
                $condition = "";
                if ($_SESSION["citizen_id"] != "") {
                    $sql_user_permiss = " SELECT GROUP_CONCAT(CONCAT('\'', branch_code, '\''))  branch_code
                FROM acc_user_permission_profession
                WHERE user_id = '" . $_SESSION["citizen_id"] . "'";
                    $rs_user_permiss = $this->BaseModel->get_one_field($sql_user_permiss);
                    if ($rs_user_permiss['branch_code'] != null) {
                        $rs = $rs_user_permiss['branch_code'];
                        $condition = " WHERE tier2_code in ($rs)  ";
                    }
                }

                $sql = $sql . $condition;
            }
        } else {
            $sql = $sql;
        }
		
       // print_r($sql);
       return $this->BaseModel->get_all($sql);
    }
	
    public function get_tpqi_eoc($occ_level_id, $uoc_id)
    {
        $sql = " SELECT * FROM standard_eoc
        WHERE occ_level_id = '" . $occ_level_id . "'
        AND uoc_id = '" . $uoc_id . "' ";
        $rs = $this->BaseModel->get_all($sql);
        $rows = $this->BaseModel->get_num_rows($sql);
        if ($rows > 0) {
            return $rs;
        } else {
            return "";
        }
    }

    /* ตัวเดิมไม่ใช้งาน
    public function get_occ_level($filter = array())
    {
    $sql = " SELECT * FROM settings_occ_level ";
    return $this->BaseModel->get_all($sql);
    }*/

    public function find_u_e_p($keyword)
    {
        $uoc = $this->get_uoc1($keyword);
        $eoc = $this->get_eoc($uoc["uoc_code"]);
        $data = array(
            'uoc' => $uoc["row_dt"],
            'eoc' => $eoc["row_dt"],
            'pc' => $this->get_pc($eoc["eoc_code"]),
        );
        return $data;
    }

    //ค้นหา uoc ในสาขาวิชาชีพนั้นๆ
    private function find_uoc($occ_level_id)
    {
        /*
        $find_uoc_code = " SELECT uocIDObj FROM settings_occ_level WHERE id = '" . $occ_level_id . "' ";
        $uoc_code = $this->BaseModel->get_one_field($find_uoc_code);
        $rows = $this->BaseModel->get_num_rows($find_uoc_code);
        $str_uoc_code = trim($uoc_code["uocIDObj"], '[]');
         */
        $sql = " SELECT * FROM standard_uoc WHERE occ_level_id = '" . $occ_level_id . "' ";
        $rs = $this->BaseModel->get_all($sql);
        $rows = $this->BaseModel->get_num_rows($sql);

        if ($rows > 0) {
            return $rs;
        } else {
            return "";
        }
    }

    /* ดึงข้อมูล UOC */
    public function fetch_uoc($keyword)
    {
        $sql = " SELECT * FROM standard_uoc WHERE occ_level_id = '" . $keyword . "'
            ORDER BY uoc_code ASC ";
        $rs = $this->BaseModel->get_all($sql);
        $rows = $this->BaseModel->get_num_rows($sql);

        if ($rows > 0) {
            return $rs;
        } else {
            return "";
        }

        /* $uoc_code = $this->find_uoc($keyword);
        return $uoc_code;
        print_r($uoc_code);*/
        /*  if ($uoc_code != "") {
    $sql = " SELECT * FROM v_pstd_uoc
    WHERE stdID IN ($uoc_code)
    ORDER BY stdCode ASC ";
    return $this->BaseModel->get_all($sql);

    } else {
    return null;
    }*/
    }

    /* ดึงข้อมูล UOC และ EOC */
    public function fetch_uoc_eoc($keyword)
    {
        $uoc_code = $this->find_uoc($keyword);

        if ($uoc_code != "") {
            $sql = " SELECT eoc.stdID as eoc_id,eoc.stdCode as eoc_code,eoc.stdName as eoc_name ,
            uoc.stdID as uoc_id,uoc.stdCode as uoc_code,uoc.stdName as uoc_name
            FROM v_pstd_eoc as eoc
            LEFT JOIN v_pstd_uoc as uoc
            ON uoc.stdID = eoc.parent
            WHERE eoc.parent in ($uoc_code)
            ORDER BY uoc.stdCode ASC ,eoc.stdCode ASC ";
            return $this->BaseModel->get_all($sql);
        } else {
            return null;
        }
    }

    public function fetch_eoc($keyword)
    {
        $uoc_code = $this->find_uoc($keyword);
        $str_uoc_code = explode(",", $uoc_code);
        $first_uoc_code = trim($str_uoc_code[0], '"');

        $sql_eoc = " SELECT * FROM v_pstd_eoc
                     WHERE parent = '" . $first_uoc_code . "'
                     ORDER BY stdCode ASC ";
        return $this->BaseModel->get_all($sql_eoc);
    }

    public function fetch_eoc1($keyword)
    {
        $sql_eoc = " SELECT * FROM settings_professional_standard
                     WHERE parent = '" . $keyword . "'
                     ORDER BY stdCode ASC ";
        //  return $sql_eoc;
        // $this->log_var($str_uoc);
        return $this->BaseModel->get_all($sql_eoc);
    }

    private function get_uoc1($keyword)
    {
        $sql = " SELECT * FROM settings_professional_standard ";
        if ($keyword != "") {
            $sql .= " WHERE parent = '" . $keyword . "' ";
        }
        $sql .= " ORDER BY stdCode ASC ";

        /* $sql_stdcode = " SELECT GROUP_CONCAT(stdID SEPARATOR ',') uoc_code FROM settings_professional_standard
        WHERE parent = '".$keyword."' and stdType = 'U' ORDER BY stdID DESC ";*/
        $sql_stdcode = " SELECT GROUP_CONCAT(stdID ORDER BY stdID ASC) AS uoc_code
                            FROM settings_professional_standard
                            WHERE parent = '" . $keyword . "'  AND stdType = 'U' ";

        $data = array(
            'row_dt' => $this->BaseModel->get_all($sql),
            'uoc_code' => $this->BaseModel->get_one_field($sql_stdcode),
        );
        return $data;
    }

    /*ดึงข้อมูล EOC */
    private function get_eoc($keyword = array())
    {
        $arr_keyword = explode(',', $keyword['uoc_code']);
        $str_keyword = $arr_keyword[0];

        $sql = " SELECT * FROM settings_professional_standard ";
        if ($keyword != "") {
            $sql .= " WHERE parent = '" . $str_keyword . "' ";
        }
        $sql .= " ORDER BY stdCode ASC ";

        $sql_stdcode = " SELECT GROUP_CONCAT(stdID ORDER BY stdID ASC) AS eoc_code
        FROM settings_professional_standard
        WHERE  parent = '" . $str_keyword . "' ";

        $data = array(
            'row_dt' => $this->BaseModel->get_all($sql),
            'eoc_code' => $this->BaseModel->get_one_field($sql_stdcode),
        );

        return $data;
    }

    /* ดึงข้อมูล PC */
    private function get_pc($keyword = array())
    {
        //$arr_keyword =$keyword['eoc_code'];
        $arr_keyword = explode(',', $keyword['eoc_code']);
        $str_keyword = $arr_keyword[0];

        $sql = " SELECT * FROM `settings_performance_detail` WHERE elementID in ($str_keyword)";
        return $this->BaseModel->get_all($sql);
    }

    /** สร้างรหัสเทมเพลตของเครื่องมือประเมิน */
    public function gen_asm_template($asm_type)
    {
        $sql = " SELECT doc_no FROM settings_gen_docscode
                WHERE tool_type = '" . $asm_type . "'";

        $arr_result = $this->BaseModel->get_one_field($sql);
        $rows = $this->BaseModel->get_num_rows($sql);

        $doc_no = "";
        $str_result = "";
        if ($rows > 0) {
            $doc_no = $arr_result['doc_no'];
            $docType = substr($doc_no, 0, 1);
            $autoRun = substr($doc_no, 1, 4) + 1;
            $numLength = strlen($autoRun);
            if ($numLength == 1) {
                $autoRun = '000' . $autoRun;
            } else if ($numLength == 2) {
                $autoRun = '00' . $autoRun;
            } else if ($numLength == 3) {
                $autoRun = '0' . $autoRun;
            }

            $doc_no = $asm_type . $autoRun;

            $str_result = $this->validateDocCode($doc_no, $asm_type, "update");
        } else {
            $doc_no = $asm_type . "0001";
            $str_result = $this->validateDocCode($doc_no, $asm_type, "insert");
        }

        if ($str_result) {
            return $doc_no;
        }
    }

    private function validateDocCode($doc_no, $asm_tool, $cmd)
    {
        $result = "";
        $data = array(
            'tool_type' => $asm_tool,
            'doc_no' => $doc_no,
        );

        if ($cmd == "insert") {
            $result = $this->BaseModel->insert("settings_gen_docscode", $data);
        } else {
            $condition = array('tool_type' => $asm_tool);
            $result = $this->BaseModel->update("settings_gen_docscode", $data, $condition);
        }
        return $result;
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

    /* ดึงข้อมูลประเภทแฟ้มสะสมผลงาน */
    public function get_portfolio_type($filter = array())
    {
        $sql = " SELECT * FROM settings_portfolio_type ";
        return $this->BaseModel->get_all($sql);
    }

    /* ดึงข้อชื่อคุณวุฒิวิชาชีพ By ID */
    public function get_occ_name($id)
    {
        $sql = " SELECT * FROM settings_occ_level WHERE id ='" . $id . "' ";
        $result = $this->db->query($sql);
        $result_data = $result->row_array();
        return $result_data['levelName'];
    }

    /* ดึงข้อชื่อคุณวุฒิวิชาชีพ By ID */
    public function get_occ_name_preview($id)
    {
        $sql = " SELECT id, concat(tier1_title,' ', tier2_title,' ', tier3_title,' ', level_name) as occ_level FROM `standard_qualification` WHERE id  ='" . $id . "' ";
        $result = $this->db->query($sql);
        $result_data = $result->row_array();
        return $result_data['occ_level'];
    }

    // ดึงชื่อของประเภทเทมเพลต
    public function get_template_type_name($template_type_id)
    {
        $sql = " SELECT * FROM settings_template_type
                WHERE id = '" . $template_type_id . "' ";
        return $this->BaseModel->get_one_field($sql);
    }

    //ประเภทการสร้างข้อสอบ
    public function exam_type($asm_tool)
    {
        /* $exam_type_arr = [
        ["id" => "0", "name" => "--กรุณาเลือก--"],
        ["id" => "1", "name" => "แม่แบบตามคุณวุฒิวิชาชีพ"],
        ["id" => "2", "name" => "แม่แบบตามหน่วยสมรรถนะ (UOC)"],
        ["id" => "3", "name" => "แม่แบบตามหน่วยสมรรถนะย่อย (EOC)"],
        ["id" => "4", "name" => "แม่แบบตามเกณฑ์การปฏิบัติงาน (PC)"]
        ];
        return $exam_type_arr;
         */
        $condition = "status = '1'";
        // if (!empty($asm_tool)) {
        //     $condition = "asm_tool = '" . $asm_tool . "' AND status = '1'";
        // }

        $sql = " SELECT exam_type,name FROM settings_template t
                LEFT JOIN settings_exam_type exam_type
                ON t.exam_type = exam_type.id
                WHERE " . $condition . " GROUP BY exam_type ";
        return $this->BaseModel->get_all($sql);
    }

    //ประเภทของแม่แบบ (templates)
    public function template_type($asm_tool, $exam_type)
    {
        /* Previous Query to fetch Exam templet type */
        $sql = "";
        // if ($exam_type == 2) {
        //     $sql = " SELECT DISTINCT template_type, name FROM settings_template t
        //            LEFT JOIN settings_template_type tp_type
        //            ON t.template_type = tp_type.id";
        // } else {
        //     $sql = " SELECT DISTINCT template_type, name FROM settings_template t
        //            LEFT JOIN settings_template_type tp_type
        //            ON t.template_type = tp_type.id
        //           WHERE asm_tool = '" . $asm_tool . "'
        //            AND exam_type = '" . $exam_type . "' ";
        // }
        $sql = " SELECT DISTINCT template_type, name FROM settings_template t
                   LEFT JOIN settings_template_type tp_type
                   ON t.template_type = tp_type.id";
        // $sql = " SELECT DISTINCT template_type, name FROM settings_template t
        //            LEFT JOIN settings_template_type tp_type
        //            ON t.template_type = tp_type.id
        //           WHERE asm_tool = '" . $asm_tool . "'
        //            AND exam_type = '" . $exam_type . "' ";

        // // $sql = " SELECT DISTINCT template_type, name FROM settings_template t
        // //             LEFT JOIN settings_template_type tp_type
        // //             ON t.template_type = tp_type.id ";
        return $this->BaseModel->get_all($sql);
    }

    //เกณฑ์การออกข้อสอบสำหรับแม่แบบรายการประเมิน (checklist)
    public function criteria_examier_advise_chklist()
    {
        $sql = " SELECT * FROM settings_criteria_advise_type WHERE status ='1' ";
        return $this->BaseModel->get_all($sql);
    }

    //เกณฑ์การออกข้อสอบสำหรับแม่แบบรายการประเมิน (checklist)
    public function get_template_criteria($template_id)
    {
        $sql = " SELECT exam_blueprint.*,settings_criteria_advise_type.description FROM exam_blueprint
        LEFT JOIN settings_criteria_advise_type
        ON settings_criteria_advise_type.criteria_type_id = exam_blueprint.criteria_type_byexamier
        WHERE template_id = '" . $template_id . "' ";
        return $this->BaseModel->get_one_field($sql);
    }

    //ข้อมูลเกณฑ์การประเมิน
    public function get_criteria($criteria_type_id)
    {
        $sql = " SELECT * FROM settings_criteria_advise_type
                WHERE criteria_type_id = '" . $criteria_type_id . "'";
        $rs = $this->BaseModel->get_all($sql);

        $num_row = $this->BaseModel->get_num_rows($sql);

        if ($num_row == 0) {
            $sql = " SELECT * FROM settings_criteria_advise_type
            WHERE occ_level_id = '0'";
            $rs = $this->BaseModel->get_all($sql);
        }
        return $rs;
    }

    public function get_log_action()
    {
        $status_arr = [
            ["action" => "created", "name" => "สร้างข้อสอบ"],
            ["action" => "updated", "name" => "อัพเดทข้อสอบ"],
            ["action" => "copy", "name" => "คัดลอกข้อสอบ"],
            ["action" => "delete", "name" => "ลบข้อสอบ"],
            ["action" => "reviewexam", "name" => "ทบทวนข้อสอบ"],
            ["action" => "pickexam", "name" => "กำหนดชุดข้อสอบ"],
            ["action" => "definecriteria", "name" => "กำหนดเกณฑ์การผ่าน"],
            ["action" => "approveexam", "name" => "อนุมัติชุดข้อสอบ"],
            ["action" => "examused", "name" => "นำข้อสอบไปใช้งาน",],
        ];
        return $status_arr;
    }

    //ดึงข้อมูลผู้ใช้งาน
    public function getUsers()
    {
        $sql = " SELECT distinct u.citizen_id, concat(u.prefix,u.first_name,' ',u.last_name) AS fullname, u.email FROM user_login u
                LEFT JOIN tpqinet_user_role r
                ON u.citizen_id	 = r.citizen_id
                 ";
        //WHERE r.role_id in('55','60','62','66','67')
        // where (u.first_name LIKE '%" . $term . "%' OR u.last_name LIKE '%" . $term . "%')

        $num_row = $this->BaseModel->get_num_rows($sql);
        if ($num_row > 0) {
            return  $this->BaseModel->get_all($sql);
        } else {
            return null;
        }
    }

    /* ดึงข้อมูลอาชีพ สำหรับกำหนดสิทธิ์การใช้งาน */
    public function getAllOCCforUserRight()
    {
        $sql = "";
        $sql = " SELECT tier3_id,tier3_title 
            FROM standard_qualification 
                WHERE tier1_status = '1' 
                AND tier2_status = '1' 
                AND tier3_status = '1' 
                GROUP BY tier3_id ";
        return $this->BaseModel->get_all($sql);
    }
	
	 private function loadAuthorizedOcc()
    {
        $username = $_SESSION["username"];
        $sql = " SELECT GROUP_CONCAT(CONCAT('\'', occ_level_id, '\'')) AS occ FROM user_access_occlevel
        WHERE username = '" . $username . "'
        AND status = '1' ";
        $rs_occ_permiss = $this->BaseModel->get_one_field($sql);
        $num_row = $this->BaseModel->get_num_rows($sql);
        if ($num_row > 0) {
            if ($rs_occ_permiss['occ'] != null) {
                $rs = $rs_occ_permiss['occ'];
                return $rs;
            }else{
				return 0;
			}
        } else {
            return 0;
        } 
    }

    /* ดึงข้อมูลคุณวุฒิวิชาชีพ Requirement change 17/11/2564 */
   public function get_occ_level($filter = array())
    {
        $sql = "";
        $condition = "";
        $occ_authorized =  $this->loadAuthorizedOcc();
        $userType = $_SESSION['user_type'];
		if($userType == 1) {
		 	  $sql = " SELECT id, CONCAT( IFNULL(tier1_title, ''), ' ', IFNULL(tier2_title, ''), ' ', IFNULL(tier3_title, ''), ' ', IFNULL(level_name, '') ) AS occ_level FROM standard_qualification " ;
		//	  $sql = " SELECT id, tier1_title, tier2_title, tier3_title, level_name FROM standard_qualification " ;
			return $this->BaseModel->get_all($sql);
		}else{
			if (($occ_authorized != '0' || $occ_authorized != '' || $occ_authorized != NULL) && $userType != "1") {
            $condition = " WHERE  id in($occ_authorized) ";
			$sql = " SELECT id, concat(tier1_title,' ', tier2_title,' ', tier3_title,' ', level_name)
			AS occ_level FROM standard_qualification " . $condition;
			return $this->BaseModel->get_all($sql);
			}else{
				return null;
			}
		}
    }

    public function get_occ_tier1_dropdown($filter = array())
    {
        $sql = "";
        $condition = "";
        $occ_authorized =  $this->loadAuthorizedOcc();
        $userType = $_SESSION['user_type'];
        if ($userType == 1) {
            $sql = " SELECT distinct tier1_code, tier1_title FROM standard_qualification ";
            return $this->BaseModel->get_all($sql);
        } else {
            // if (($occ_authorized != '0' || $occ_authorized != '' || $occ_authorized != NULL) && $userType != "1") {
            //     $condition = " WHERE  id in($occ_authorized) ";
            //     $sql = " SELECT distinct tier1_code, tier1_title FROM standard_qualification " . $condition;
            //     return $this->BaseModel->get_all($sql);
            // } else {
            //     return null;
            // }
            if (!empty($occ_authorized) && $userType != "1") {
                $condition = "";
                if (is_array($occ_authorized)) {
                    $condition = " WHERE  id in($occ_authorized) ";
                }

                $sql = " SELECT distinct tier1_code, tier1_title FROM standard_qualification " . $condition;
                return $this->BaseModel->get_all($sql);
            } else {
                return null;
            }
        }
    }

    public function get_occ_tier2_dropdown($filter = array())
    {
        $sql = "";
        $condition = "";
        $occ_authorized =  $this->loadAuthorizedOcc();
        $userType = $_SESSION['user_type'];
        if ($userType == 1) {
            $sql = " SELECT distinct tier2_code, tier2_title FROM standard_qualification ";
            return $this->BaseModel->get_all($sql);
        } else {
            if (!empty($occ_authorized) && $userType != "1") {
                $condition = "";
                if (is_array($occ_authorized)) {
                    $condition = " WHERE  id in($occ_authorized) ";
                }

                $sql = " SELECT distinct tier2_code, tier2_title FROM standard_qualification " . $condition;
                return $this->BaseModel->get_all($sql);
            } else {
                return null;
            }
        }
    }

    public function get_occ_tier3_dropdown($filter = array())
    {
        $sql = "";
        $condition = "";
        $occ_authorized =  $this->loadAuthorizedOcc();
        $userType = $_SESSION['user_type'];
        if ($userType == 1) {
            $sql = " SELECT distinct tier3_id, tier3_title FROM standard_qualification ";
            return $this->BaseModel->get_all($sql);
        } else {
            if (!empty($occ_authorized) && $userType != "1") {
                $condition = "";
                if (is_array($occ_authorized)) {
                    $condition = " WHERE  id in($occ_authorized) ";
                }

                $sql = " SELECT distinct tier3_id, tier3_title FROM standard_qualification " . $condition;
                return $this->BaseModel->get_all($sql);
            } else {
                return null;
            }
        }
    }

    public function get_occ_level_dropdown($filter = array())
    {
        $sql = "";
        $condition = "";
        $occ_authorized = $this->loadAuthorizedOcc();
        $userType = $_SESSION['user_type'];
        if ($userType == 1) {
            $sql = " SELECT distinct level_code, level_name FROM standard_qualification ";
            return $this->BaseModel->get_all($sql);
        } else {
            if (!empty($occ_authorized) && $userType != "1") {
                $condition = "";
                if (is_array($occ_authorized)) {
                    $condition = " WHERE id in($occ_authorized) ";
                }

                $sql = " SELECT distinct level_code, level_name FROM standard_qualification " . $condition;
                return $this->BaseModel->get_all($sql);
            } else {
                return null;
            }
        }
    }


    public function get_occ_level_seperate($filter = array())
    {
        $sql = "";
        $condition = "";
        $occ_authorized =  $this->loadAuthorizedOcc();
        $userType = $_SESSION['user_type'];
		if($userType == 1) {
		// 	  $sql = " SELECT id, CONCAT( IFNULL(tier1_title, ''), ' ', IFNULL(tier2_title, ''), ' ', IFNULL(tier3_title, ''), ' ', IFNULL(level_name, '') ) AS occ_level FROM standard_qualification " ;
			  $sql = " SELECT DISTINCT id, tier1_title, tier2_title, tier3_title, level_name FROM standard_qualification " ;
			return $this->BaseModel->get_all($sql);
		}else{
			if (($occ_authorized != '0' || $occ_authorized != '' || $occ_authorized != NULL) && $userType != "1") {
            $condition = " WHERE  id in($occ_authorized) ";
			$sql = " SELECT id, tier1_title, tier2_title, tier3_title, level_name FROM standard_qualification " . $condition;
			return $this->BaseModel->get_all($sql);
			}else{
				return null;
			}
		}
    }
	
	public function get_occ_level_tiers($id, $column)
    {
        $sql = "";
        $condition = "";
        $occ_authorized =  $this->loadAuthorizedOcc();
        $userType = $_SESSION['user_type'];
		if($userType == 1) {
		// 	  $sql = " SELECT id, CONCAT( IFNULL(tier1_title, ''), ' ', IFNULL(tier2_title, ''), ' ', IFNULL(tier3_title, ''), ' ', IFNULL(level_name, '') ) AS occ_level FROM standard_qualification " ;
			  $sql = "SELECT DISTINCT TRIM(" . $column . ") AS " . $column . ", TRIM(" . $id . ") AS " . $id . " FROM standard_qualification";
			return $this->BaseModel->get_all($sql);
		}else{
			if (($occ_authorized != '0' || $occ_authorized != '' || $occ_authorized != NULL) && $userType != "1") {
            $condition = " WHERE  id in($occ_authorized) ";
			$sql = "SELECT DISTINCT TRIM(" . $column . ") AS " . $column . ", TRIM(" . $id . ") AS " . $id . "
        FROM standard_qualification" . $condition;
			return $this->BaseModel->get_all($sql);
			}else{
				return null;
			}
		}
    }
	
	//Change 29/01/2565
    public function getOCCName($id)
    {
        $sql = " SELECT * FROM standard_qualification WHERE id ='" . $id . "' ";
        $result = $this->db->query($sql);
        $result_data = $result->row_array();
        return $result_data;
        print_r($sql);
    }

	//Change 29/01/2565
    public function getAllOCC($filter = array())
    {
        $sql = "";
        $sql = " SELECT id, concat(tier1_title,' ', tier2_title,' ', tier3_title,' ', level_name)
        AS occ_level FROM standard_qualification WHERE status = '1'";
        return $this->BaseModel->get_all($sql);
    }
	
	public function fetch_files()
    {
		
        $sql = " SELECT * FROM docs_forexam ORDER BY id DESC ";
        $rs = $this->BaseModel->get_all($sql);
		
	//	$rs = $this->BaseModel->get_all_pagination($sql, $filter["page_no"], $filter["per_page"]);
        $rows = $this->BaseModel->get_num_rows($sql);
		 
        if ($rows > 0) {
            return $rs;
        } else {
            return "";
        }
		
    }
	
	public function fetch_files_data()
    {
		$sql = " SELECT * FROM req_docs_forexam ORDER BY id DESC ";
        $rs = $this->BaseModel->get_all($sql);
        $rows = $this->BaseModel->get_num_rows($sql);
		 
        if ($rows > 0) {
            return $rs;
        } else {
            return "";
        }
		
	//	$log = date('Y-m-d H:i:s') . "- [INFO] Application started \n";
	//	file_put_contents('/tpqinet_asm_uat/application/logs/application.log', $log, FILE_APPEND);
		
    }
}