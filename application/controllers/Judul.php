<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Judul extends MY_Controller
{
    //////////////////////////////CRUD//////////////////////////////

    //Menampilkan Data Judul Buku
    public function index()
    {
        $juduls = $this->judul->getAllJudul();
        $main_view = 'judul/index';
        $this->load->view('template',compact( 'main_view','juduls'));
    }

    //Harus Login terlebih dahulu
    protected function isLogin()
    {
        $isLogin = $this->session->userdata('is_login');
        if(!$isLogin) {
            redirect(base_url());
        }
    }
    ///////////////////////////////////////////////////////////


}