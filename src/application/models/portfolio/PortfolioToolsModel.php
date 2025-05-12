<?php
class PortfolioToolsModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("/BaseModel");
    }

    //ตรวจสอบในฐานข้อมูลว่ามีชุดข้อสอบนี้อยู่หรือไม่ ถ้ามีให้ลบออก
    public function isvalid_tpdetail_uoc($template_id)
    {
        $sql = " SELECT * FROM template_portfolio
                    WHERE blueprint_id	 = '" . $template_id . "' ";

        $num_row = $this->BaseModel->get_num_rows($sql);
        if ($num_row > 0) {
            $condition = ["blueprint_id	" => $template_id];
            $rs = $this->BaseModel->delete("template_portfolio", $condition);
            return 1;
        } else {
            return 0;
        }
    }

    //บันทึกข้อมูลเทมเพลตแบบ checklist สร้างข้อสอบตามประเภท uoc
    public function insert_tpdetail_uoc($template_id, $json_q_detail)
    {
        foreach ($json_q_detail as $uoc) {
            foreach ($uoc as $item) {
                if ($item->topic != "") {
                    $arr_list = [
                        "blueprint_id" => $template_id,
                        "uoc_code" => $item->uoc_code,
                        //"order_line" => $item->order_line,
                        "main_topic" => $item->topic,
                        "question_status" => $item->question_status,
                        // "created_date" => date('Y-m-d H:i:s'),
                        //"created_by" => $_SESSION["user_id"]
                    ];

                    $result = $this->BaseModel->insert("template_portfolio", $arr_list);
                    if ($result) {
                        $result = 1;
                    } else {
                        $result = 0;
                    }
                }
            }
        }
        return $result;
    }

    // บันทึกข้อมูลเทมเพลต checklist (หัวข้อหลักและหัวข้อย่อย)
    public function insert_tp_checklist_maintopic($template_id, $json_q_detail)
    {
        $detail_arr = json_decode(json_encode($json_q_detail), true);

        for ($i = 1; $i <= COUNT($detail_arr); $i++) {
            $q_detail = [
                "maintopic" => $detail_arr[$i]['topic'],
                "order_line" => $i,
                "created_date" => date('Y-m-d H:i:s'),
                "blueprint_id" => $template_id,
            ];

            $maintopic_id = "";
            $this->db->trans_begin();
            $this->db->insert('tp_checklist_maintopic', $q_detail);

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                return (0);
            } else {
                $maintopic_id = $this->db->insert_id();
                $this->db->trans_commit();
            }

            if ($maintopic_id != "") {
                for ($j = 1; $j <= COUNT($detail_arr[$i]['detail']); $j++) {
                    $subtopic = [
                        "subtopic" => $detail_arr[$i]['detail'][$j]['subtopic'],
                        "order_line" => $j,
                        "maintopic_id" => $maintopic_id,
                    ];

                    $rs_subtopic = $this->BaseModel->insert("tp_checklist_subtopic", $subtopic);
                }
            }
        }

        if ($rs_subtopic) {
            $rs_subtopic = 1;
        } else {
            $rs_subtopic = 0;
        }

        return $rs_subtopic;
    }

    // แก้ไขข้อมูลเทมเพลต checklist (หัวข้อหลักและหัวข้อย่อย)
    public function update_checklist_mainsubtopic($template_id)
    {
        $sql = " SELECT GROUP_CONCAT(id) as id
                FROM tp_checklist_maintopic
                WHERE blueprint_id = '" . $template_id . "' ";

        $id = $this->BaseModel->get_one_field($sql);
        // print_r($id);

        //$condition = ["maintopic_id    " => "in (".$id["id"].")" ];

        // print_r($condition);

        $num_row = $this->BaseModel->get_num_rows($sql);

        if ($num_row > 0) {
            $rs = $this->BaseModel->delete("tp_checklist_subtopic", "maintopic_id in (" . $id["id"] . ")");
            if ($rs) {
                $condition_maintopic = ["blueprint_id	" => $template_id];
                $rs = $this->BaseModel->delete("tp_checklist_maintopic", $condition_maintopic);
            }

            return 1;
        } else {
            return 0;
        }
    }

    //ดึงข้อมูลรายละเอียดเทมเพลต checklist มีหัวข้อหลักและหัวข้อย่อย
    public function get_checklist_mainsubtopic($template_id)
    {
        $sql = " SELECT m.id as m_id,m.order_line AS m_order_line,m.maintopic,
                    m.created_date,m.blueprint_id, sub.subtopic, sub.order_line AS sub_order_line
                    FROM tp_checklist_maintopic m
                    LEFT join tp_checklist_subtopic sub ON m.id = sub.maintopic_id
                WHERE m.blueprint_id = '" . $template_id . "' ";
        return $this->BaseModel->get_all($sql);
    }

    //ดึงข้อมูลรายละเอียดเทมเพลต (เทมเพลตแบบ checklist ที่มีเฉพาะหัวข้อหลัก)
    public function get_template_detail($template_id)
    {
        $sql = " SELECT * FROM template_portfolio
                WHERE blueprint_id = '" . $template_id . "' ";
        return $this->BaseModel->get_all($sql);
    }

    //ดึงข้อมูลไปแสดงเพื่อแก้ไข (checklist ตาม UOC)
    public function get_template_detail_foredit($template_id, $uoc_code)
    {
        $sql = " SELECT * FROM template_portfolio
                WHERE blueprint_id = '" . $template_id . "'
                AND uoc_code = '" . $uoc_code . "' ";
        return $this->BaseModel->get_all($sql);
    }

    // ดึงข้อมูลไปแสดงเพื่อแก้ไข (checklist หัวข้อหลักและย่อย (ดึงหัวข้อหลัก))
    public function get_detail_maintopic($blueprint_id)
    {
        $sql = " SELECT * FROM tp_checklist_maintopic
                    WHERE blueprint_id = '" . $blueprint_id . "' ";
        return $this->BaseModel->get_all($sql);
    }

    // ดึงข้อมูลไปแสดงเพื่อแก้ไข (checklist หัวข้อหลักและย่อย (ดึงหัวข้อย่อย))
    public function get_detail_subtopic($maintopic_id)
    {
        $sql = " SELECT * FROM tp_checklist_subtopic
                WHERE maintopic_id = '" . $maintopic_id . "' ";
        return $this->BaseModel->get_all($sql);
    }

    /* public function insert_tp_detail($data)
    {
    $result = $this->BaseModel->insert("exam_template_detail_portfolio", $data);
    return $result;

    }*/

    /*public function get_template_preview($template_id)
    {
    $sql = " SELECT blueprint.* , advise.* FROM exam_blueprint blueprint
    LEFT JOIN exam_template_criteria_advise advise
    ON blueprint.template_id = advise.template_id
    WHERE blueprint.template_id = '" . $template_id . "' ";

    return $this->BaseModel->get_all($sql);
    }

    public function get_template_detail($template_id)
    {
    $sql = " SELECT * FROM exam_template_detail_portfolio tp_detail
    LEFT JOIN exam_blueprint bp
    ON tp_detail.template_id = bp.template_id
    WHERE tp_detail.template_id = '" . $template_id . "' ";

    return $this->BaseModel->get_all($sql);
    }
     */

    public function get_port_type_name($port_type)
    {
        $sql = " SELECT * FROM settings_portfolio_type
                 WHERE id = '" . $port_type . "' ";
        return $this->BaseModel->get_one_field($sql);
    }

    public function update_tp_detail($data)
    {
        $condition = ["template_detail_id" => $data['template_detail_id']];
        $tp_detail = [
            "portfolio_type" => $data['portfolio_type'],
            "detail" => $data['detail'],
        ];
        $rs = $this->BaseModel->update("exam_template_detail_portfolio", $tp_detail, $condition);

        if ($rs) {
            return 1;
        } else {
            return 0;
        }
    }

    public function get_assessment_detail($blueprint_id, $exam_schedule_id, $app_id, $blueprint_data)
    {
        $exam_type = $blueprint_data[0]->exam_type;
        $template_type = $blueprint_data[0]->template_type;
        $criteria_used_byexamier = $blueprint_data[0]->criteria_used_byexamier;
        // echo $exam_type . ' ' . $template_type;
        $sql = "";
        if ($exam_type == '1' && $template_type == '2') { //ตามคุณวุฒิ & หัวข้อหลัก-ย่อย
            $sql = " SELECT a.*,b.maintopic,c.subtopic
            FROM exam_person_portfolio as a
            LEFT JOIN tp_checklist_maintopic as b
            ON a.maintopic_id = b.id
            LEFT JOIN tp_checklist_subtopic as c
            ON a.subtopic_id = c.id
            WHERE a.blueprint_id = '" . $blueprint_id . "'
            AND a.exam_schedule_id = '64/04/0001'
            AND a.app_id = '" . $app_id . "' ";
        } else if ($exam_type == '2' && $template_type == '1') { //ตาม uoc & เฉพาะหัวข้อหลัก
            $sql = " SELECT *,(SELECT main_topic FROM tp_checklist WHERE id = a.tp_checklist_id  ) as maintopic
            FROM exam_person_portfolio as a
            WHERE a.blueprint_id = '" . $blueprint_id . "'
            AND a.exam_schedule_id = '" . $exam_schedule_id . "'
            AND a.app_id = '" . $app_id . "' ";
        }
        return $this->BaseModel->get_all($sql);
    }

    public function insert_assessment($assessment, $assessment_detail, $tool_type)
    {
        $assessment_id = "";
        $this->db->trans_begin();
        $this->db->insert('assessment', $assessment);

        $assessment_id = $this->db->insert_id();

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return (0);
        } else {
            $this->db->trans_commit();
        }

        $rs = 0;
        if ($assessment_id != "") {

            $detail_arr = json_decode(json_encode($assessment_detail), true);
            for ($i = 1; $i <= COUNT($detail_arr); $i++) {
                $condition = ["id" => $detail_arr[$i]['exam_person_portfolio_id']];
                $tp_detail = [
                    // "assessment_status" => $detail_arr[$i]['assessment_status'],
                    "assessment_status" => '1',
                ];
                $rs = $this->BaseModel->update("exam_person_portfolio", $tp_detail, $condition);
            }

            for ($i = 1; $i <= COUNT($detail_arr); $i++) {
                $assessment_detail_insert = [
                    "exam_person_portfolio_id" => $detail_arr[$i]["exam_person_portfolio_id"],
                    "app_id" => $assessment["app_id"],
                    "assessment_id" => $assessment_id,
                    "uoc_code" => $detail_arr[$i]['uoc_code'] != '' ? $detail_arr[$i]['uoc_code'] : "",
                    "maintopic_id" => $detail_arr[$i]['maintopic_id'] != '' ? $detail_arr[$i]['maintopic_id'] : "",
                    "subtopic_id" => $detail_arr[$i]['subtopic_id'] != '' ? $detail_arr[$i]['subtopic_id'] : "",
                    "score" => $detail_arr[$i]['score'] != '' ? $detail_arr[$i]['score'] : "",
                    "file_status" => $detail_arr[$i]['file_status'] != '' ? $detail_arr[$i]['file_status'] : "",
                ];
                $rs = $this->BaseModel->insert('assessment_detail_portfolio', $assessment_detail_insert);
            }

            $result = [];
            if ($rs) {
                $rs = $this->update_assessment_applicant(
                    $assessment["app_id"],
                    $assessment["exam_schedule_id"],
                    $tool_type
                );
                $result = [
                    "status" => 1,
                    "message" => "สำเร็จ"
                ];
            } else {
                $result = [
                    "status" => 0,
                    "message" => "ไม่สำเร็จ"
                ];
            }
            return $result;
        }
    }

    //ปรับปรุงสถานะการประเมินของบุคคลนั้นๆ
    public function update_assessment_applicant($app_id, $exam_schedule_id, $tool_type)
    {
        $data = [
            "assessment_status" => '1',
        ];

        $condition = [
            "app_id" => $app_id,
            "exam_schedule_id" => $exam_schedule_id,
            "asm_tool_type" => $tool_type
        ];

        return $this->BaseModel->update("assessment_applicant", $data, $condition);
    }

    public function ck_template_uoc($template_id, $uoc_code)
    {

        $sql = " SELECT * FROM template_portfolio
        WHERE uoc_code = '" . $uoc_code . "'
        AND blueprint_id = '" . $template_id . "' ";
        $num_row = $this->BaseModel->get_num_rows($sql);
        if ($num_row > 0) {
            return 1;
        } else {
            return 0;
        }
    }
}