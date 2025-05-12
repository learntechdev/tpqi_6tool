<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Documents extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (!isset($_SESSION['username'])) {
            header("Location: ../Documents/login");
        }
        session_destroy();
        $this->load->view("api/layout/header");
        $this->load->view("api/documents/index");
        $this->load->view("api/layout/footer");
    }

    public function login()
    {
        if (isset($_SESSION['username'])) {
            session_destroy();
            header("Location: ../../api/Documents/login");
        }
        $this->load->view("api/layout/header");
        $this->load->view("api/documents/login");
        $this->load->view("api/layout/footer");
    }

}
