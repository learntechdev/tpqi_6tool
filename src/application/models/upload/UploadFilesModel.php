<?php
class UploadFilesModel extends CI_model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("/BaseModel");
    }

    public function uploadfile($files)
    {
        $result = $this->BaseModel->insert("assessment_upload_files", $files);
        return $result;
    }

    public function delForUpdate($app_id, $tool_type, $template_detail_id)
    {
        $condition = ["app_id" => $app_id, "tool_type" => $tool_type, "template_detail_id" => $template_detail_id];

        $delete = $this->BaseModel->delete("assessment_upload_files", $condition);
    }

}