<?php
class ImportdataModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("/BaseModel");
    }
    // authen api of tpqi-net
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

    public function checkdata($api_url, $page_no, $import_type)
    {
        $token = $this->tpqi_authen();
        $data = array(
            'token' => $token
        );

        $data_string = json_encode($data);
        if ($import_type == 2) {
            $curl = curl_init($api_url . "/" . $page_no . "/1/0");
        } else {
            $curl = curl_init($api_url . "/" . $page_no);
        }

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
        $process = "";
        if ($data["status"] == 000) {
            $total_page = $data["result"]["page_all"];
            if ($total_page >= 1) {
                for ($i = 1; $i <= $total_page; $i++) {
                //for($i=80;$i<=81; $i++){
                    if ($import_type == 2) { //ดึงรอบสอบ
                        $str_url = $api_url . "/" . $i . "/1/0";
                    } else {
                        $str_url = $api_url . "/" . $i;
                    }
                    $process = $this->process_with_pager($token, $str_url, $import_type);
                }
            }
            return $process;
        }
    }

    private function process_with_pager($token, $api_url, $import_type)
    {
        $data = array(
            'token' => $token
        );

        $data_string = json_encode($data);
        $curl = curl_init($api_url);
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
        $rs = "";
        if ($data["status"] == 000) {
            if ($import_type == 1) {
                $rs = $this->insert_all_qualification($result);
            } else {
                $rs = $this->insert_examsround($result);
            }
        }
        return $rs;
    }

    private function insert_all_qualification($dt)
    {
        $data = (array) json_decode($dt, true);
        $rs = $data["result"]["item_list"];

        foreach ($rs as $item) {
            $arr_list = [
                "id" => $item["id"],
				"frame" => $item["frame"] == NULL ? "" : $item["frame"], 
				"version" => $item["version"] == NULL ? "" : $item["version"],
                "tier1_code" => $item["tier1_code"] == NULL ? "" : $item["tier1_code"],
                "tier1_title" => $item["tier1_title"] == NULL ? "" : $item["tier1_title"],
                "tier1_title_en" => $item["tier1_title_en"] == NULL ? "" : $item["tier1_title_en"],
                "tier2_code" => $item["tier2_code"] == NULL ? "" : $item["tier2_code"],
                "tier2_title" => $item["tier2_title"] == NULL ? "" : $item["tier2_title"],
                "tier2_title_en" => $item["tier2_title_en"] == NULL ? "" : $item["tier1_title_en"],
                "tier3_id" =>  $item["tier3_id"] == NULL ? "" : $item["tier3_id"],
                "tier3_title" => $item["tier3_title"] == NULL ? "" : $item["tier3_title"],
                "tier3_title_en" => $item["tier3_title_en"] == NULL ? "" : $item["tier1_title_en"],
                "level_code" => $item["level_code"] == NULL ? "" : $item["level_code"],
                "level_name" => $item["level_name"] == NULL ? "" : $item["level_name"],
                "level_name_en" => $item["level_name_en"] == NULL ? "" : $item["level_name_en"]
            ];

            $result = $this->BaseModel->insert("standard_qualification", $arr_list);

            if ($result) {
				if($item["id"] != "" || $item["id"] != NULL){
					$uoc = $this->insert_uoc($item["id"]);
				}
            } else {
                exit();
            }
        }
        return $result;
    }

    /**  connect api */
    public function connect_api($api_url, $param)
    {
        $token = $this->tpqi_authen();
        $data = array(
            'token' => $token
        );

        $data_string = json_encode($data);
        $curl = curl_init($api_url . "/" . $param);
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

        /* $data = (array) json_decode($result, true);
        $token = $data["token"];
        return $token;*/

        // print_r($result);

        if ($data["status"] == 000) {
            // print_r($result);
            return $result;
        } else {
            return null;
        }
    }

    private function insert_uoc($occ_level_id)
    {
        //$url = "http://147.50.138.201/tpqi_net63/public/web_api/v1/item_qualification";
		$url = "https://tpqinet-api.tpqi.go.th/web_api/v1/item_qualification";
        $conn_data = $this->connect_api($url, $occ_level_id);
        $data = (array)json_decode($conn_data, true);
        if ($data["status"] == 000) {
            $uoc_list = $data["result"]["uoc_list"];
            foreach ($uoc_list as $item) {
                $uoc_row = [
                    "uoc_id" => $item["uoc_id"] == NULL ? "" : $item["uoc_id"],
                    "uoc_code" => $item["uoc_code"] == NULL ? "" : $item["uoc_code"],
                    "uoc_name" => $item["uoc_name"] == NULL ? "" : $item["uoc_name"],
                    "uoc_name_en" => $item["uoc_name_en"] == NULL ? "" : $item["uoc_name_en"],
                    "occ_level_id" => $occ_level_id
                ];

                $result_uoc = $this->BaseModel->insert("standard_uoc", $uoc_row);

                if ($result_uoc) {
					if($item["eoc_list"] != "" || $item["eoc_list"] != NULL){
						$eoc_list = $item["eoc_list"];
						$result_eoc = $this->insert_eoc($eoc_list, $item["uoc_id"], $occ_level_id);
					}
                }
            }
        } else {
            return null;
        }
    }

    private function insert_eoc($eoc_list, $uoc_id, $occ_level_id)
    {
        foreach ($eoc_list as $item) {
            $eoc_row = [
                "eoc_id" =>  $item["eoc_id"] == NULL ? "" : $item["eoc_id"],
                "eoc_code" => $item["eoc_code"] == NULL ? "" : $item["eoc_code"],
                "eoc_name" => $item["eoc_name"] == NULL ? "" : $item["eoc_name"],
                "uoc_id" => $uoc_id,
                "occ_level_id" => $occ_level_id
            ];

            $result_eoc = $this->BaseModel->insert("standard_eoc", $eoc_row);
            if ($result_eoc) {
				if($item["pc_list"] != "" || $item["pc_list"] != NULL){
					$pc_list = $item["pc_list"];
					$result_pc = $this->insert_pc($pc_list, $item["eoc_id"], $occ_level_id);
				}
            }
        }
    }

    private function insert_pc($pc_list, $eoc_id, $occ_level_id)
    {
        foreach ($pc_list as $item) {
            $pc_row = [
                "pc_id" => $item["pc_id"] == NULL ? "" : $item["pc_id"],
                "pc_name" => $item["pc_name"] == NULL ? "" : $item["pc_name"],
                "eoc_id" => $eoc_id,
                "occ_level_id" => $occ_level_id
            ];
            $result_pc = $this->BaseModel->insert("standard_pc", $pc_row);
        }
    }

    //นำเข้าข้อมูลรอบสอบจาก tpqi-net
    private function insert_examsround($dt)
    {
        // print_r($data);
        $data = (array) json_decode($dt, true);
        $rs = $data["result"]["item_list"];
        // print_r(json_encode($rs) );

        //  $test = $data['result'][0]->page_current;
        foreach ($rs as $sch) {
            if ($sch["exam_no"] != "" && ($sch["exam_no"] == "64/07/0093") ) {
                $ass_list = $sch["assessment_list"];
                // print_r($ass_list);
                $tmp_method_id = "";
                $i = 0;
                $result  = "";
                foreach ($ass_list as $item) {
                    if ($item["method_id"] != 1) {
                        $arr_list = [
                            "tpqi_exam_no" => $sch["exam_no"],
                            "org_id" => $sch["org_code"],
                            "org_name" => $sch["org_name"],
                            "occ_level_id" => $sch["qualification_id"],
                            "occ_level_name" => $sch["qualification_name"],
                            "site_address_id" => $sch["site_address_id"],
                            "place" => $sch["site_address_name"],
                            "asm_tool_type" => "1",
                            //"exam_num" => $i,
                            "start_date" => $item["start_date"] == NULL ? "" : $item["start_date"],
                            "end_date" => $item["end_date"] == NULL ? "" : $item["end_date"],
                            "status" => '1'
                        ];
                        $result = $this->BaseModel->insert("exam_schedule", $arr_list);
                    }
                }
                if ($result) {
                    $rs = $this->item_exam_around($sch["exam_no"]);
                }
            }
        }
    }

    //ดึงข้อมูลผู้เข้าประเมินในรอบสอบนั้นๆ
    private function item_exam_around($tpqi_exam_no)
    {
        $url = "https://tpqinet-api.tpqi.go.th/web_api/v1/item_exam_around";
        //$url = "http://147.50.138.201/tpqi_net63/public/web_api/v1/item_exam_around";
        $conn_data = $this->connect_api($url, $tpqi_exam_no);
        $data = (array)json_decode($conn_data, true);

        if ($data["status"] == 000) {
            $org_code = $data["result"]["org_code"];
            //$org_name = $data["result"]["org_name"];
            $qualification_id = $data["result"]["qualification_id"];
            $qualification_name = $data["result"]["qualification_name"];
            $ass_list = $data["result"]["assessment_list"];

            foreach ($ass_list as $ass_item) {
                if ($ass_item["method_id"] != 1 && $ass_item["method_id"] != 8) {
                    // if ($tmp_method_id != $ass_item["method_id"]) {
                    $person_list = $data["result"]["application_list"];
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
                            "schedule_exam_date" => "",
                            "assessment_date" => "",
                            "assessment_status" => "0",
                            "confirm_ass_status" => "0"
                        ];
                        $result_applist = $this->BaseModel->insert("assessment_applicant", $person_row);
                    }

                    // print_r($person_row);
                    // $tmp_method_id =  $ass_item["method_id"];
                    //}
                }
            }
        } else {
            return null;
        }
    }
}
