<?php
class Anggota_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $no_induk = $this->session->userdata('no_induk');
        $level = $this->session->userdata('level');
        $is_login = $this->session->userdata('is_login');

        if (!$is_login){
            redirect(base_url());
            return;
        }
    }
}