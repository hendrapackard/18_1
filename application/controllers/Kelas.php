<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends Admin_Controller
{
    //////////////////////////////CRUD//////////////////////////////

    //Menampilkan data kelas
    public function index()
    {
        $main_view = 'kelas/index';
        $this->load->view('template',compact('main_view'));
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
            $row[] = form_open("kelas/delete/$kelas->id_kelas").form_hidden('id_kelas',"$kelas->id_kelas").form_button(['type' => 'submit','content' => '<i class="material-icons">delete</i>', 'class' => 'btn btn-danger waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Delete','onclick' => "return confirm('Anda yakin akan menghapus kelas ini?')"]).form_close();
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

    // Mengedit data kelas
    public function edit($id = null)
    {
        $kelas = $this->kelas->where('id_kelas',$id)->get();
        if (!$kelas) {
            $this->session->set_flashdata('warning', 'Data kelas tidak ada.');
            redirect('kelas');
        }

        if (!$_POST) {
            $input =(object) $kelas;
        } else {
            $input = (object) $this->input->post(null,true);
        }

        if (!$this->kelas->validate()) {

            $main_view = 'kelas/form';
            $form_action = "kelas/edit/$id";
            $heading    = 'Edit Kelas';

            $this->load->view('template',compact('main_view','form_action','heading', 'input'));
            return;
        }

        if ($this->kelas->where('id_kelas',$id)->update($input)) {
            $this->session->set_flashdata('success','Data kelas berhasil diupdate');
        }
        redirect('kelas');
    }

    //Menghapus Data Kelas
    public function delete($id = null)
    {
        $kelas = $this->kelas->where('id_kelas',$id)->get();
        if (!$kelas) {
            $this->session->set_flashdata('warning','Data kelas tidak ada');
            redirect('kelas');
        }

        if ($this->kelas->where('id_kelas',$id)->delete())
        {
            $this->session->set_flashdata('success','Data kelas berhasil dihapus');
        }else {
            $this->session->set_flashdata('error','Data kelas gagal dihapus');
        }
        redirect('kelas');
    }
    ///////////////////////////////////////////////////////////

    //Callback
    public function alpha_numeric_coma_dash_dot_space($str)
    {
        if (!preg_match('/^[a-zA-Z0-9 .,\-]+$/i', $str)) {
            $this->form_validation->set_message('alpha_numeric_coma_dash_dot_space', 'Hanya boleh berisi huruf, spasi, tanda hubung(-),titik(.) dan koma (,).');
            return false;
        }
        return true;
    }

    public function nama_kelas_unik()
    {
        $nama_kelas = $this->input->post('nama_kelas');
        $id_kelas = $this->input->post('id_kelas');

        $this->kelas->where('nama_kelas', $nama_kelas);
        !$id_kelas || $this->kelas->where('id_kelas!=', $id_kelas);
        $kelas = $this->kelas->get();

        if (count($kelas)) {
            $this->form_validation->set_message('nama_kelas_unik', '%s sudah digunakan.');
            return false;
        }
        return true;
    }
}