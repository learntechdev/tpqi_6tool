<?php
class ImportdataModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("/BaseModel");
    }

    private function tpqi_authen()
    {
        $data = array(
            'ClientID' => '5fe8a60e76970',
            'ClientSecret' => 'c1fd0ce9c7d24f480fadeada8eb10d22'
        );

        $data_string = json_encode($data);
        //$curl = curl_init('http://147.50.138.201/tpqi_net63/public/web_api/v1/auth');
        $curl = curl_init('https://tpqinet-api.tpqi.go.th/web_api/v1/auth');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            )
        );

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $result = curl_exec($curl);
        curl_close($curl);
        //print_r($result);
        $data = (array) json_decode($result, true);
        $token = $data["token"];
        return $token;
        //print_r($data["token"]);
    }

    public function checkdata($api_url, $tpqi_exam_no)
    {
        $token = $this->tpqi_authen();
        $data = array(
            'token' => $token
        );

        $data_string = json_encode($data);
        $curl = curl_init($api_url . "/" . $tpqi_exam_no);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'token:' . $token
            )
        );

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $result = curl_exec($curl);
        curl_close($curl);

        $data = (array) json_decode($result, true);

        if ($data["status"] == 000) {
            return $this->item_exam_around($result);
        } else {
            return 0;
        }
    }

    //เช็ครอบสอบว่ามีในฐานข้อมูลหรือไม่
    private function valid_examround($tpqi_exam_no)
    {
        $sql = " SELECT tpqi_exam_no FROM exam_schedule
        WHERE tpqi_exam_no = '" . $tpqi_exam_no . "'";
        $num_row = $this->BaseModel->get_num_rows($sql);
        return $num_row;
    }

    //ดึงข้อมูลผู้เข้าประเมินในรอบสอบนั้นๆ
    private function item_exam_around($result)
    {
        $data = (array) json_decode($result, true);

        $tpqi_exam_no = $data["result"]["exam_no"];
        $org_code = $data["result"]["org_code"];
        $org_name = $data["result"]["org_name"];
        $qualification_id = $data["result"]["qualification_id"];
        $qualification_name = $data["result"]["qualification_name"];
        $ass_list = $data["result"]["assessment_list"];
        $count_person_list = (array)($data["result"]["application_list"]);

        $valid_examround = $this->valid_examround($tpqi_exam_no);
        if ($valid_examround > 0) {
            return 2; //มีรอบสอบอยู่ในฐานข้อมูลแล้ว
        } else {
            foreach ($ass_list as $ass_item) {
                if ($ass_item["method_id"] != 1 && $ass_item["method_id"] != 8) {
                    $exam_round = [
                        "tpqi_exam_no" => $tpqi_exam_no,
                        "org_id" => $org_code,
                        "org_name" => $org_name,
                        "occ_level_id" => $qualification_id,
                        "occ_level_name" => $qualification_name,
                        "site_address_id" => $data["result"]["site_address_id"],
                        "place" => $data["result"]["site_address_name"],
                        "asm_tool_type" => $ass_item["method_id"],
                        "start_date" => $ass_item["start_date"] == NULL ? "" : $ass_item["start_date"],
                        "end_date" => $ass_item["end_date"] == NULL ? "" : $ass_item["end_date"],
                        "status" => '1',
                        "import_date" => date('Y-m-d H:i:s')
                    ];

                    $result = $this->BaseModel->insert("exam_schedule", $exam_round);

                    if ($result == '1') {
                        $person_list = $data["result"]["application_list"];
                        $row_idx = 0;
                        foreach ($person_list as $item) {

                            $person_row = [
                                "exam_schedule_id" => $tpqi_exam_no,
                                "asm_tool_type" => $ass_item["method_id"],
                                "org_id" => $org_code,
                                "app_id" =>  $item["application_no"] == NULL ? "" : $item["application_no"],
                                "citizen_id" => $item["citizen_id"] == NULL ? "" : $item["citizen_id"],
                                "initial_name" => $item["prefix"] == NULL ? "" : $item["prefix"],
                                "name" => $item["first_name"],
                                "lastname" => $item["last_name"],
                                "occ_level_id" => $qualification_id,
                                "occ_level_name" => $qualification_name,
                                "assessment_date" => "",
                                "assessment_status" => "0",
                                "confirm_ass_status" => "0"
                            ];

                            $result_applist = $this->BaseModel->insert("assessment_applicant", $person_row);
                            $row_idx++;
                        }

                        /*if ($row_idx == count($count_person_list)) {
                            return $this->insert_cb_agent($data, $tpqi_exam_no);
                        } else {
                            return 0;
                        }*/
                    }
                }
            }
			
			return $this->insert_cb_agent($data, $tpqi_exam_no);
			
        }
    }

    //บันทึกข้อมูล agent ที่อนุญาตให้เห็นข้อมูลของรอบสอบนั้น
    private function insert_cb_agent($cb, $tpqi_exam_no)
    {
        $cb_list = $cb["result"]["cb_agent_list"];
        $count_cb_list = (array)($cb["result"]["cb_agent_list"]);

        $row_idx = 0;
        foreach ($cb_list as $item) {
            $agent_row = [
                "tpqi_exam_no" => $tpqi_exam_no,
                "citizen_id" =>  $item["citizen_id"] == NULL ? "" : $item["citizen_id"],
                "name" =>  $item["full_name"] == NULL ? "" : $item["full_name"],
            ];

            $result_agentlist = $this->BaseModel->insert("tpqinet_authorized_examround", $agent_row);
            $row_idx++;
        }

        if ($row_idx == count($count_cb_list)) {
            return 1;
        } else {
            return 0;
        }
    }
}
