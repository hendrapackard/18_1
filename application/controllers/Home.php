<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller
{
    public function index()
    {
        $grafiks = $this->home->grafikKelas();
        $grafik2 = $this->home->grafikBuku();
        $jmlAnggota = $this->home->getAllAnggotaCount()->jmlAnggota;
        $jmlJudul = $this->home->getAllJudulCount()->jmlJudul;
        $jmlBuku = $this->home->getAllBukuCount()->jmlBuku;
        $jmlKembali = $this->home->getAllKembaliCount()->jmlKembali;
        $main_view = 'home/index';
        $this->load->view('template',compact('main_view','grafiks','grafik2','jmlAnggota','jmlJudul','jmlBuku','jmlKembali'));
    }

}