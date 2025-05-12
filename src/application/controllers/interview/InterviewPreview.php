<?php
require_once __DIR__ . '../../../vendor/autoload.php';
defined('BASEPATH') or exit('No direct script access allowed');

class InterviewPreview extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("masterdata/MasterDataModel");
        $this->load->model("interview/InterviewModel");
        $this->load->model("interview/InterviewPreviewModel");
        $this->load->model("shared/SharedModel");
    }

    public function index()
    {

        $doc_filename = "";
        //ตรวจสอบว่าสร้างชุดข้อสอบประเภทใด
        $tp_type = $this->SharedModel->get_blueprint($_GET['template_id']);
        if($tp_type[0]->exam_type == "2"  && $tp_type[0]->template_type == "3"){//ถาม-ตอบ (uoc)
            $doc_filename = "interview/preview/preview_uoc";
        }else {
           // $doc_filename = "interview/preview/index";
        }

        $data['result'] = $this->InterviewPreviewModel->get_tp_preview($_GET['template_id']);
        $data['rs_detail'] = $this->InterviewPreviewModel->get_tp_detail($_GET['template_id']);

        $mpdf = new mPDF('tha', 'A4', '0', 'THSaraban', 15, 15, 5, 0, 0, 0);
        $html = $this->load->view($doc_filename, $data, true);
        $server_name = $_SERVER['SERVER_NAME'];
        if(filter_var($server_name, FILTER_VALIDATE_IP)){
            $html = str_replace($server_name, 'localhost', $html);
        }

        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
}