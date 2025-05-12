<?php
class ExamscheduleModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("/BaseModel");
        $this->load->model("masterdata/MasterDataModel");
    }

    // authen api of tpqi-net
    private function tpqi_authen()
    {
        $data = array(
            'ClientID'=> '5fe8a60e76970', 
            'ClientSecret'=> 'c1fd0ce9c7d24f480fadeada8eb10d22'
        );

        $data_string = json_encode($data);
        $curl = curl_init('http://147.50.138.201/tpqi_net63/public/web_api/v1/auth');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
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

    //ดึงข้อมูลจาก API ของ TPQI-NET
    public function tpqi_examround()
    {
        $token = $this->tpqi_authen();
        $data = array(
            'token'=> $token
        );

        $data_string = json_encode($data);
        $curl = curl_init('http://147.50.138.201/tpqi_net63/public/web_api/v1/all_exam_around/1/1/0');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'token:'.$token)
        );

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        $result = curl_exec($curl);
        curl_close($curl);
        
        $data = (array) json_decode($result, true);
        if($data["status"] == 000){
            $rs = $this->insert_examschedule($result);
            if($rs ==1){
                return 1;
            }else{
                return 0;
            }
        }
       // print_r($result);
    }

    private function insert_examschedule($dt)
    {
       // print_r($data);
        $data = (array) json_decode($dt, true);
        $rs = $data["result"]["item_list"];

       // print_r(json_encode($rs) );
      //  $test = $data['result'][0]->page_current;

        foreach ($rs as $sch)
        {
            if ($sch["exam_no"] != "") {
                $ass_list = $sch["assessment_list"];
              // print_r($ass_list);
                foreach ($ass_list as $item) {
                    $arr_list = [
                        "tpqi_exam_no" => $sch["exam_no"],
                        "org_id" => $sch["org_code"],
                        "org_name" => $sch["org_name"],
                        "occ_level_id" => $sch["qualification_id"],
                        "occ_level_name" => $sch["qualification_name"],
                        "site_address_id" => $sch["site_address_id"],
                        "place" => $sch["site_address_name"],
                        "asm_tool_type" => $item["method_id"],
                        "start_date" => $item["start_date"],
                        "end_date" => $item["end_date"],
                        "status" => '1'
                    ];
                    
                    if($item["method_id"] != 1){
                        $result = $this->BaseModel->insert("exam_schedule", $arr_list);
                    }
                }
            }
        }
      
      

      //  print_r($test);
        /*foreach ($data as $rs) {
            foreach ($rs as $item) {
                if ($item->exam_no != "") {
                    $arr_list = [
                        "tpqi_exam_no" => $item->exam_no,
                        "org_id" => $item->org_code,
                        "org_name" => $item->org_name,
                        "occ_level_id" => $item->qualification_id,
                        "occ_level_name" => $item->qualification_name,
                        "site_address_id" => $item->site_address_id,
                        "place" => $item->site_address_name,
                    ];

                    $result = $this->BaseModel->insert("exam_schedule", $arr_list);
                    if ($result) {
                        $result = 1;
                    } else {
                        $result = 0;
                    }
                }
            }
        }*/

       // return $result;
    }
    
    public function tpqi_authen1()
    {
       // $headers = array('Content-Type: application/json',);
        
        $url = 'http://147.50.138.201/tpqi_net63/public/web_api/v1/auth' ; 
        $ch = curl_init($url);

       // $data = ['ClientID'=> '5fe8a60e76970', 'ClientSecret'=> 'c1fd0ce9c7d24f480fadeada8eb10d22'];

        //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            "ClientID: 5fe8a60e76970",
            "ClientSecret:c1fd0ce9c7d24f480fadeada8eb10d22"
        ));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

       /* curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        */
        
        $result = curl_exec($ch);
        curl_close($ch);

       // $items = json_decode($result);

        $data = (array) json_decode($result, true);

        print_r($data);
      /*  if(isset($items)){ 
            return $items ; 
            print_r($items);
        } else { 
            return FALSE ; 
        }*/
    }
    
    


    //ดึงข้อมูลกำหนดการสอบ
    public function get_all($filter = array())
    {
        $condition = "";
        $status = "";
        if ($filter["type"] == "define" && $filter["status"] == 0) {
            $status = '1,2,3,4'; //ยังไม่ได้จัดชุดข้อสอบ
        } else if ($filter["type"] == 'ap' && $filter["status"] == 0) {
            $status = '4,5,6'; //ยังไม่ได้อนุมัติเกณฑ์
        } else {
            $status = $filter["status"];
        }

        $condition = " WHERE e_sch.status in (" . $status . ") ";

        if ($filter["tool_type"] != "0" && $filter["tool_type"] != "") {
            $condition .= " AND  e_sch.asm_tool_type = '" . $filter["tool_type"] . "' ";
        }

        if ($filter["keyword"] != "") {
            $condition .= " AND e_sch.occ_level_name like '%" . $filter["keyword"] . "%' ";
        }

        $sql = " SELECT e_sch.*, org.orgName
                FROM exam_schedule e_sch
                LEFT JOIN settings_organization org
                ON e_sch.org_id = org.orgID" . $condition .
            " ORDER BY exam_schedule_id DESC ";

        return $this->BaseModel->get_all_pagination($sql, $filter["page_no"], $filter["per_page"]);
    }

    public function get_exam_schedule_status($status)
    {
        $arr_data = $this->MasterDataModel->exam_schedule_status();
        $arr_status = [
            "name" => $arr_data[$status]["name"],
            "operation" => $arr_data[$status]["operation"],
        ];
        return $arr_status;
    }

    public function get_template($occ_level_id)
    {
        $sql = " SELECT * FROM exam_blueprint
                WHERE SUBSTRING_INDEX(occ_level_id, ':',1) = '" . $occ_level_id . "'
                AND is_used = '1' ";
        // print_r($sql);
        return $this->BaseModel->get_all($sql);
    }

    public function get_template_arr($occ_level_id)
    {
        $sql = " SELECT * FROM exam_blueprint
                WHERE SUBSTRING_INDEX(occ_level_id, ':',1) = '" . $occ_level_id . "'
                AND is_used = '1' ";
        return $this->BaseModel->get_all_arr($sql);
    }

    public function get_exam_criteria_advise($template_id)
    {
        $sql = " SELECT * FROM exam_template_criteria_advise
        WHERE template_id = '" . $template_id . "' ";
        return $this->BaseModel->get_all($sql);
    }

    public function get_criteriaforapprove($exam_schedule_id)
    {
        $sql = " SELECT *
                FROM exam_schedule exam_sch
                WHERE exam_sch.exam_schedule_id = '" . $exam_schedule_id . "' ";
        return $this->BaseModel->get_all($sql);
    }

    public function insert_exam_criteria($template_id, $exam_schedule_id)
    {
        $data_sch = [
            "exam_template_id" => $template_id,
            "status" => '4',
        ];

        $condition = [
            "exam_schedule_id" => $exam_schedule_id,
        ];

        return $this->BaseModel->update("exam_schedule", $data_sch, $condition);

    }

    //อนุมัติเกณฑ์การประเมิน
    public function approve_exam_criteria($approve_status, $exam_schedule_id, $reason_disapproval)
    {
        $data = [
            "status" => $approve_status,
            "reason_disapproval" => $reason_disapproval,
        ];

        $condition = [
            "exam_schedule_id" => $exam_schedule_id,
        ];

        return $this->BaseModel->update("exam_schedule", $data, $condition);
    }
}