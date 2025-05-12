<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Userlog extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("shared/SharedModel");
        $this->load->model("settings/UserlogModel");
        $this->load->model("BaseModel");

    }

    private function criteria()
    {
        $filter = array();

        if (isset($_GET["page_no"])) {
            if (trim($_GET["page_no"]) != "") {
                $filter["page_no"] = $_GET["page_no"];
            }
        } else {
            $filter["page_no"] = 1;
        }

        if (isset($_GET["per_page"])) {
            if (trim($_GET["per_page"]) != "") {
                $filter["per_page"] = $_GET["per_page"];
            }
        } else {
            $filter["per_page"] = 10;
        }

        if (isset($_GET['num_rows'])) {
            $filter['num_rows'] = $_GET['num_rows'];
        }

        if (isset($_GET['asm_tool'])) {
            $filter['asm_tool'] = $_GET['asm_tool'];
        } else {
            $filter['asm_tool'] = '';
        }

        if (isset($_GET['log_action'])) {
            $filter['log_action'] = $_GET['log_action'];
        } else {
            $filter['log_action'] = '';
        }

        if (isset($_GET['tp_created_date_start'])) {
            $filter['tp_created_date_start'] = $_GET['tp_created_date_start'];
        } else {
            $filter['tp_created_date_start'] = '';
        }

        if (isset($_GET['tp_created_date_end'])) {
            $filter['tp_created_date_end'] = $_GET['tp_created_date_end'];
        } else {
            $filter['tp_created_date_end'] = '';
        }

        return $filter;
    }

    public function index()
    {
        $filter = array();
        $filter = $this->criteria();
        $menu = $_SESSION["user_type"] == "8" ? "1,8" : "8";
        $data["dataList"] = $this->UserlogModel->get_userlog($filter);
        $data["breadcrumb"] = $this->MasterDataModel->breadcrumb($menu);

        $active_title = "ทบทวนข้อสอบ";
        $data["active_title"] = array("active_title" => $active_title);

        $this->SharedModel->layouts("settings/user_log/index", $data);
    }

    public function search()
    {
        $filter = array();
        $filter = $this->criteria();
        $data["dataList"] = $this->UserlogModel->get_userlog($filter);

        $this->load->view("settings/user_log/showdata", $data);
    }

    public function export_excel()
    {
        $filter = array();
        $filter = $this->criteria();
        $this->load->library("excel");
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $rowCount = 2;
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'วันที่')
            ->setCellValue('B1', 'ชื่อผู้ใช้งาน')
            ->setCellValue('C1', 'การกระทำ')
            ->setCellValue('D1', 'เครื่องมือ')
            ->setCellValue('E1', 'รหัสข้อสอบ');

        $results = $this->UserlogModel->get_userlog($filter);
        $asm_tool = $this->MasterDataModel->tool_type_array();
        $log_action = $this->MasterDataModel->get_log_action();
        foreach ($results['result'] as $key => $row) {
            foreach ($log_action as $vv) {
                if ($vv['action'] == $row['action']) {
                    $action_name = $vv['name'];
                    if ($row['template_id'] != '') {
                        $template_id = '' . $row['template_id'];
                    }

                }
            }
            foreach ($asm_tool as $vv) {
                if ($vv['name_eng'] == $row['menu_name']) {
                    $name_tool = $vv['name'];
                }
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $this->BaseModel->dateToThai($row['date_action'], true));
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row['name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $action_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $name_tool);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $template_id);

            $rowCount++;

        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $filename = 'ประวัติการเข้าใช้งานระบบ.xlsx';
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        ob_end_clean();
        $objWriter->save('php://output');
    }

}
