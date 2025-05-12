<?php
class ImportQualificationModel extends CI_Model
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
        $data = (array) json_decode($result, true);
        $token = $data["token"];
        return $token;
    }

    public function checkdata($api_url, $start_page, $end_page)
    {
        $token = $this->tpqi_authen();
        $data = array(
            'token' => $token
        );

        $data_string = json_encode($data);
        $curl = curl_init($api_url . "/" . $start_page);

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
                for ($i = $start_page; $i <= $end_page; $i++) {
                    $str_url = $api_url . "/" . $i;
                    $process = $this->process_with_pager($token, $str_url);
                }
            }
            return $process;
        }
    }

    private function process_with_pager($token, $api_url)
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
            $item_list = $data["result"]["item_list"];
            foreach ($item_list as $item) {
                $rs = $this->insert_uoc($item["id"], $token);
            }
            return $rs;
            // $rs = $this->insert_all_qualification($result, $token);
        }
    }

    private function insert_all_qualification($dt, $token)
    {
        $data = (array) json_decode($dt, true);
        $rs = $data["result"]["item_list"];
        foreach ($rs as $item) {
            $uoc = $this->insert_uoc($item["id"], $token);
            return $uoc;
        }
    }

    private function insert_uoc($occ_level_id, $token)
    {
        $url = "https://tpqinet-api.tpqi.go.th/web_api/v1/item_qualification";

        $data = array(
            'token' => $token
        );

        $data_string = json_encode($data);
        $curl = curl_init($url . "/" . $occ_level_id);
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
            $dt_item = $data["result"];
            $arr_list = [
                "id" => $dt_item["id"],
                "frame" => $dt_item["frame"],
                "version" => $dt_item["version"],
                "status" => $dt_item["status"] == NULL ? "" : $dt_item["status"],
                "tier1_code" => $dt_item["tier1_code"],
                "tier1_title" => $dt_item["tier1_title"],
                "tier1_title_en" => $dt_item["tier1_title_en"] == NULL ? "" : $dt_item["tier1_title_en"],
                "tier1_status" => $dt_item["tier1_status"] == NULL ? "" : $dt_item["tier1_status"],
                "tier2_code" => $dt_item["tier2_code"] == NULL ? "" : $dt_item["tier2_code"],
                "tier2_title" => $dt_item["tier2_title"] == NULL ? "" : $dt_item["tier2_title"],
                "tier2_title_en" => $dt_item["tier2_title_en"] == NULL ? "" : $dt_item["tier1_title_en"],
                "tier2_status" => $dt_item["tier2_status"] == NULL ? "" : $dt_item["tier2_status"],
                "tier3_id" =>  $dt_item["tier3_id"] == NULL ? "" : $dt_item["tier3_id"],
                "tier3_title" => $dt_item["tier3_title"] == NULL ? "" : $dt_item["tier3_title"],
                "tier3_title_en" => $dt_item["tier3_title_en"] == NULL ? "" : $dt_item["tier1_title_en"],
                "tier3_status" => $dt_item["tier3_status"] == NULL ? "" : $dt_item["tier3_status"],
                "level_code" => $dt_item["level_code"],
                "level_name" => $dt_item["level_name"],
                "level_name_en" => $dt_item["level_name_en"] == NULL ? "" : $dt_item["level_name_en"],
                "import_date" => date('Y-m-d H:i:s')
            ];

            $result = $this->BaseModel->insert("standard_qualification", $arr_list);

            if ($result == 1) {
                $uoc_list = $data["result"]["uoc_list"];
				if(count($data["result"]["uoc_list"]) > 0 ){
					foreach ($uoc_list as $item) {
						$uoc_row = [
							"uoc_id" => $item["uoc_id"],
							"uoc_code" => $item["uoc_code"],
							"uoc_name" => $item["uoc_name"] == NULL ? "" : $item["uoc_name"],
							"uoc_name_en" => $item["uoc_name_en"] == NULL ? "" : $item["uoc_name_en"],
							"occ_level_id" => $occ_level_id
						];

						$result_uoc = $this->BaseModel->insert("standard_uoc", $uoc_row);

						if ($result_uoc) {
							$eoc_list = $item["eoc_list"];
							$result_eoc = $this->insert_eoc($eoc_list, $item["uoc_id"], $occ_level_id);
						}
					}
				}else{
					return null;
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
                "eoc_id" => $item["eoc_id"],
                "eoc_code" => $item["eoc_code"],
                "eoc_name" => $item["eoc_name"] == NULL ? "" : $item["eoc_name"],
                "uoc_id" => $uoc_id,
                "occ_level_id" => $occ_level_id
            ];

            $result_eoc = $this->BaseModel->insert("standard_eoc", $eoc_row);
            if ($result_eoc) {
                $pc_list = $item["pc_list"];
                $result_pc = $this->insert_pc($pc_list, $item["eoc_id"], $occ_level_id);
            }
        }
    }

    private function insert_pc($pc_list, $eoc_id, $occ_level_id)
    {
        foreach ($pc_list as $item) {
            $pc_row = [
                "pc_id" => $item["pc_id"],
                "pc_name" => $item["pc_name"] == NULL ? "" : $item["pc_name"],
                "eoc_id" => $eoc_id,
                "occ_level_id" => $occ_level_id
            ];
            $result_pc = $this->BaseModel->insert("standard_pc", $pc_row);
        }
    }
}
