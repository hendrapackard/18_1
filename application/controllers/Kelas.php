<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends Admin_Controller
{
    //////////////////////////////CRUD//////////////////////////////

    //Menampilkan data kelas
    public function index()
    {
        $main_view = 'kelas/index';
        $this->load->view('template',compact('main_view','kelass'));
    }
    
    //Datatable serverside
    public function ajax_list()
    {
        $list = $this->kelas->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $kelas) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $kelas->nama_kelas;
            $row[] = anchor("kelas/edit/$kelas->id_kelas",'<i class="material-icons">edit</i>', ['class' => 'btn btn-warning waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Edit']);
            $row[] = form_open("kelas/delete/$1").form_hidden('id_kelas',"$1").form_button(['type' => 'submit','content' => '<i class="material-icons">delete</i>', 'class' => 'btn btn-danger waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Delete','onclick' => "return confirm('Anda yakin akan menghapus kelas ini?')"]).form_close();
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->kelas->count_all(),
            "recordsFiltered" => $this->kelas->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    //Menambahkan Data Kelas
    public function create()
    {
        if (!$_POST) {
            $input = (object)$this->kelas->getDefaultValues();
        } else {
            $input = (object)$this->input->post(null, true);
        }

        if (!$this->kelas->validate()) {


            $main_view = 'kelas/form';
            $form_action = 'kelas/create';
            $heading    = 'Tambah Kelas';

            $this->load->view('template', compact('main_view', 'form_action', 'heading', 'input'));
            return;
        }

        if ($this->kelas->insert($input)) {
            $this->session->set_flashdata('success', 'Data kelas berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error', 'Data kelas gagal disimpan.');
        }

        redirect('kelas');

    }
    ////////////////////////////////////////////////////////////////

    //Callback
    public function alpha_numeric_coma_dash_dot_space($str)
    {
        if (!preg_match('/^[a-zA-Z0-9 .,\-]+$/i', $str)) {
            $this->form_validation->set_message('alpha_numeric_coma_dash_dot_space', 'Hanya boleh berisi huruf, spasi, tanda hubung(-),titik(.) dan koma (,).');
            return false;
        }
    }
}