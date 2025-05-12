<?php
class ImportItemQualificationModel extends CI_Model
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

    public function checkdata($api_url, $occ_level_id)
    {
        $token = $this->tpqi_authen();
        $data = array(
            'token' => $token
        );

        $data_string = json_encode($data);
        $curl = curl_init($api_url . "/" . $occ_level_id);
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
             $item = $data["result"];
				$arr_list = [
					"id" => $item["id"],
					"frame" => $item["frame"],
					"version" => $item["version"],
					"status" => $item["status"] == NULL ? "" : $item["status"],
					"tier1_code" => $item["tier1_code"],
					"tier1_title" => $item["tier1_title"],
					"tier1_title_en" => $item["tier1_title_en"] == NULL ? "" : $item["tier1_title_en"],
					"tier2_code" => $item["tier2_code"] == NULL ? "" : $item["tier2_code"],
					"tier2_title" => $item["tier2_title"] == NULL ? "" : $item["tier2_title"],
					"tier2_title_en" => $item["tier2_title_en"] == NULL ? "" : $item["tier1_title_en"],
					"tier3_id" =>  $item["tier3_id"] == NULL ? "" : $item["tier3_id"],
					"tier3_title" => $item["tier3_title"] == NULL ? "" : $item["tier3_title"],
					"tier3_title_en" => $item["tier3_title_en"] == NULL ? "" : $item["tier1_title_en"],
					"level_code" => $item["level_code"],
					"level_name" => $item["level_name"],
					"level_name_en" => $item["level_name_en"] == NULL ? "" : $item["level_name_en"],
					"import_date" => date('Y-m-d H:i:s')
				];

				$result = $this->BaseModel->insert("standard_qualification", $arr_list);

				if ($result) {
					$uoc = $this->insert_uoc($item["uoc_list"], $item["id"]);
				} else {
					exit();
				} 
			
			return $result;
        }
    }

    private function insert_uoc($dt_uoc, $occ_level_id)
    {
            foreach ($dt_uoc as $item) {
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
