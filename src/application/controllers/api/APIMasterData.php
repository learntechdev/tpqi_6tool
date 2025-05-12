<?php

//require_once __DIR__ . '../../vendor/autoload.php';

defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('UTC');

class APIMasterData extends CI_Controller
{

    public function __construct()
    {

        header("Access-Control-Allow-Origin: *");

        header("Content-Type: application/json; charset=UTF-8");

        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

        header("Access-Control-Allow-Max-Age: 3600");

        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        parent::__construct();

        $this->load->model("masterdata/MasterDataModel");

    }

    public function get_uoc()
    {

        $result = $this->MasterDataModel->find_u_e_p($_GET["keyword"]);

        echo json_encode($result);

    }

}
