<?php
class UIModel extends CI_model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function header($param = array())
    {
        //$this->load->view("layout/header");
        if ($_SESSION["username"] == '') {
            redirect('authen/Authentication/index');
        } else {
            $this->load->view("layout/header");
        }
    }

    public function footer()
    {
        $this->load->view("layout/footer");
    }
	
	public function fmheader($param = array())
    {
        //$this->load->view("layout/header");
        if ($_SESSION["username"] == '') {
            redirect('authen/Authentication/index');
        } else {
            $this->load->view("layout/filemanager_header");
        }
    }

    public function fmfooter()
    {
        $this->load->view("layout/filemanager_footer");
    }
}