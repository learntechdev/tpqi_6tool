<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('UTC');
class Authentication extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		try {
			$this->load->model("authen/AuthenModel");
			$this->load->model("authen/AuthenModelV1");
			$this->load->model("api/TpqinetAuthenModel");
		} 
		catch(Exception $e) { 

		}
    }

    public function index()
    {
        if (isset($_GET['session_id'])) {
            if ($_GET['session_id'] != '') {
                $member_session = $this->TpqinetAuthenModel->member_session($_GET['session_id']);

                if ($member_session == 1) {
                    $p =  str_replace("'", "", $_SESSION["role_id"]);
                    $x = explode(',', $p);
					redirect('asmtools/ASMTools/index');
                    /*if (in_array('67', $x)) {
                        //redirect('exam/ExamAssignment/fetchContract');
                        redirect('asmtools/ASMTools/index');
                    }
					else if (in_array('61', $x)) {
                        redirect('assessment/PersonAssessment/index');
                    } else {
                        redirect('exam/ExamAssignment/fetchContract');
                        //redirect('asmtools/ASMTools/index');
                    }*/
                } else {
                    $this->load->view("authen/index");
                }
            }
        } else {
            $this->load->view("authen/index");
        }
    }
	
	 public function index2()
    {
		$rs = false; 
		
		try {
			if (isset($_GET['session_id'])) {
				if ($_GET['session_id'] != '') {
					$member_session = $this->TpqinetAuthenModel->member_session($_GET['session_id']);

					if ($member_session == 1) {
						$p =  str_replace("'", "", $_SESSION["role_id"]);
						$x = explode(',', $p);
						$rs =true;
						 
						/*if (in_array('67', $x)) {
							//redirect('exam/ExamAssignment/fetchContract');
							redirect('asmtools/ASMTools/index');
						}
						else if (in_array('61', $x)) {
							redirect('assessment/PersonAssessment/index');
						} else {
							redirect('exam/ExamAssignment/fetchContract');
							//redirect('asmtools/ASMTools/index');
						}*/
					} else {
					    
					}
				}
			} else {
				
			}
		} 
		catch(Exception $e) { 
		$rs = false; 
		}
		if($rs ){
			// $this->load->view("authen/index");
		}else{
			print ("<script>alert('error')</script>");
		}
		 
		//$this->load->view("authen/index");
    }

    //Change Req มาใช้วิธีการ authen ผ่านระบบเครื่องมือประเมินโดยตรง
    public function authen()
    {
		$response = array(
				'status' => 0  
				);
        $username = $this->input->post("username");
        $password = $this->input->post("password");
		 
        $result = $this->AuthenModelV1->isvalid_account($username, $password);
		
		//echo $result;
		/*$user_type = $_SESSION["user_type"];
		
		if($result == '1'){
			$status = $result;
			$user_type = $user_type;
		}else{
			$user_type = '0';
			$status = '0';
		}
       
	  echo json_encode ([
           "status" => $status,
           "user_type" => $user_type
		]) ;*/
		
		
        if ($result == 1) {
			/*
            $p =  str_replace("'", "", $_SESSION["role_id"]);
            $x = explode(',', $p);

            if (in_array('67', $x)) {
                $user_type = "8";
            } else if (in_array('61', $x)) {
                $user_type = "1";
            } else if (in_array('57', $x)) {
                $user_type = "7";
            } else if (in_array('58', $x)) {
                $user_type = "8";
            } else {
                $user_type = "9";
            }*/
			//$user_type = 7;
            //$_SESSION["user_type"] = $user_type;
			$response = array(
				'status' => 1
				//,  
				//'user_type' => $user_type,  
				);

			 
            
        }
		echo json_encode($response);
    }

    public function logout()
    {
        foreach ($_SESSION as $key => $value) {
            unset($_SESSION[$key]);
        }
        echo json_encode(1);
    }
}
