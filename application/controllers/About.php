<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller {

    public function index()
    {
        $main_view = 'about/index';
        $this->load->view('template', compact('main_view'));
    }

    public function visi()
    {
        $main_view = 'about/visi';
        $this->load->view('template', compact('main_view'));
    }

    public function cara()
    {
        $main_view = 'about/cara';
        $this->load->view('template', compact('main_view'));
    }

    public function tata()
    {
        $main_view = 'about/tata';
        $this->load->view('template', compact('main_view'));
    }

}

/* End of file About.php */
/* Location: ./application/controllers/About.php */