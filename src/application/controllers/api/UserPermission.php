<?php

defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('UTC');

class UserPermission extends CI_Controller
{

    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        parent::__construct();
        $this->load->model("api/UserPermissionModel");
    }

    public function role_permission_save()
    {
        $token = $this->ApiMasterDataModel->checkToken();
        if (isset($token)) {
            $obj = file_get_contents('php://input');
            $data = json_decode($obj);
            $result = "";
            if (isset($data->role_id) && isset($data->permission_id) && isset($data->active)) {
                $role_id = $data->role_id;
                $permission_id = $data->permission_id;
                $active = $data->active;
                $result = $this->UserPermissionModel->role_permission_save($role_id, $permission_id, $active);
            } else {
                $result = [
                    "status" => "0",
                    "msg" => "params not valid!!",
                ];
            }
            echo json_encode($result);
        }
    }

    public function acc_user_role_save()
    {
        $token = $this->ApiMasterDataModel->checkToken();
        if (isset($token)) {
            $obj = file_get_contents('php://input');
            $data = json_decode($obj);
            $result = "";
            if (isset($data->user_id) && isset($data->role_id) && isset($data->active)) {
                $user_id = $data->user_id;
                $role_id = $data->role_id;
                $active = $data->active;
                $result = $this->UserPermissionModel->acc_user_role_save($user_id, $role_id, $active);
            } else {
                $result = [
                    "status" => "0",
                    "msg" => "params not valid!!",
                ];
            }
            echo json_encode($result);

        }
    }

    public function user_permission_save()
    {
        $token = $this->ApiMasterDataModel->checkToken();
        if (isset($token)) {
            $obj = file_get_contents('php://input');
            $data = json_decode($obj);
            $result = "";
            if (isset($data->user_id) && isset($data->role_id) && isset($data->active) && isset($data->permission)) {
                $user_id = $data->user_id;
                $role_id = $data->role_id;
                $active = $data->active;
                $permission = $data->permission;
                $result = $this->UserPermissionModel->user_permission_save($user_id, $role_id, $permission, $active);
            } else {
                $result = [
                    "status" => "0",
                    "msg" => "params not valid!!",
                ];
            }
            echo json_encode($result);

        }
    }

    public function permission_profession_save()
    {
        $token = $this->ApiMasterDataModel->checkToken();
        if (isset($token)) {
            $obj = file_get_contents('php://input');
            $data = json_decode($obj);
            $result = "";
            if (isset($data->user_nid) && isset($data->user_role) && isset($data->permiss)) {
                $user_id = $data->user_nid;
                $user_role = $data->user_role;
                $permiss = $data->permiss;
                $result = $this->UserPermissionModel->permission_profession_save($user_id, $user_role, $permiss);
            } else {
                $result = [
                    "status" => "0",
                    "msg" => "params not valid!!",
                ];
            }
            echo json_encode($result);

        }
    }

}
