<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Buku extends MY_Controller
{

    //Harus Login terlebih dahulu
    protected function isLogin()
    {
        $isLogin = $this->session->userdata('is_login');
        if (!$isLogin) {
            redirect(base_url());
        }
    }

    //Menambahkan data judul buku
    public function create()
    {
        $this->isLogin();

        $id_judul   = $this->input->post('id_judul');
        $judul      = $this->buku->getJudul($id_judul);
        $input      = (object) $this->input->post(null,true);
        $main_view  = 'buku/form';
        $form_action= 'buku/create';
        $first_load = $this->input->post('first_load');

        if ($first_load) {
            $this->load->view('template',compact('main_view', 'form_action', 'input', 'judul'));
            return;
        }

        //validasi
        if (!$this->buku->validate()){
            $this->load->view('template',compact('main_view', 'form_action', 'input', 'judul'));
            return;
        }

        $id_judul   = (int) $this->input->post('id_judul');
        $kode_buku  = sprintf("%04s", $id_judul);

        //mendapatkan label buku dari database
        $label = $judul->klasifikasi.' '.substr($judul->penulis,0,3).' '.substr($judul->judul_buku,0,1).' '.$kode_buku.'-'.'0000';

        //insert data copy buku
        if ($this->buku->insert2($input,$label)) {
            $this->session->set_flashdata('success','Data buku berhasil disimpan');
        }else {
            $this->session->set_flashdata('error','Data buku gagal disimpan');
        }

        redirect('judul');
    }

    //Menampilkan total buku
    public function total($id_judul = null)
    {
        if (is_null($id_judul)) {
            redirect('judul');
        }

        $bukus      = $this->buku->total($id_judul);
        $main_view  = 'buku/total';
        $this->load->view('template',compact('main_view', 'bukus'));
    }

    //Menampilkan Buku yang tersedia
    public function ada($id_judul = null)
    {
        if (is_null($id_judul)) {
            redirect('judul');
        }

        $bukus = $this->buku->ada($id_judul);
        $main_view = 'buku/ada';
        $this->load->view('template',compact('main_view','bukus'));
    }

    //Menampilkan buku yang dipinjam
    public function dipinjam($id_judul = null)
    {
        if (is_null($id_judul)) {
            redirect('judul');
        }

        $bukus = $this->buku->dipinjam($id_judul);
        $main_view = 'buku/dipinjam';
        $this->load->view('template',compact('main_view','bukus'));
    }

    //Callback
    public function alpha_numeric_coma_dash_dot_space($str)
    {
        if (!preg_match('/^[a-zA-Z0-9 .,\-]+$/i', $str)) {
            $this->form_validation->set_message('alpha_numeric_coma_dash_dot_space','Hanya boleh berisi huruf, spasi, tanda hubung(-), titik(.) dan koma(,).');
            return false;
        }
    }
}