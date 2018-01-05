<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Admin_Controller
{
    //////////////////////////////CRUD//////////////////////////////

    //Menampilkan data user
    public function index()
    {
        $main_view  = 'user/index';
        $this->load->view('template',compact('main_view'));
    }

    //Datatable serverside
    public function ajax_list()
    {
        $list = $this->user->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $user) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $user->no_anggota;
            $row[] = $user->level;
            $row[] = $user->no_induk;
            $row[] = $user->nama;
            $row[] = $user->nama_kelas;
            $row[] = $user->is_verified == 'n' ? '<span class="label label-danger">Belum Terverifikasi' : '<span class="label label-success">Terverifikasi';
            $row[] = $user->level == 'admin' || $user->is_verified == 'n' ? ''  : anchor("user/cetak_kartu_anggota/$user->id_user",'<i class="material-icons">print</i>',['class' => 'btn btn-info waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Cetak Kartu','target' => '_blank','onClick'=>"window.open('user/cetak_kartu_anggota/$user->id_user','pagename','resizable,height=600,width=400'); return false;"]);
            $row[] = anchor("user/edit/$user->id_user",'<i class="material-icons">edit</i>', ['class' => 'btn btn-warning waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Edit']);
            $row[] = form_open("user/delete/$user->id_user").form_hidden('id_user',"$user->id_user").form_button(['type' => 'submit','content' => '<i class="material-icons">delete</i>', 'class' => 'btn btn-danger waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Delete','onclick' => "return confirm('Anda yakin akan menghapus user ini?')"]).form_close();
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->user->count_all(),
            "recordsFiltered" => $this->user->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    //Menambahkan Data User
    public function create()
    {
        if (!$_POST) {
            $input = (object) $this->user->getDefaultValues();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        // Harus melampirkan gambar--------------------------------------------------------------------------------------
        if ($_POST && empty($_FILES['foto']['name'])) {
            $this->form_validation->add_to_error_array('foto', 'Foto harus diupload');
        }
        // --------------------------------------------------------------------------------------

        if (!empty($_FILES) && $_FILES['foto']['size'] > 0) {

            $no_induk = $this->input->post('no_induk');
            $fotoFileName = $no_induk.'-'.date('YmdHis'); //Cover file name
            $upload = $this->user->uploadFoto('foto',$fotoFileName);

            if ($upload) {
                $input->foto = "$fotoFileName.jpg";
//                Data for column "foto"
                $this->user->fotoResize('foto',"./foto/$fotoFileName.jpg",700,700);
            }
        }

        $data['autonumber'] = $this->user->autoNumber('user', 'no_anggota', 4, date("Ym"));


        if (!$this->user->validate() ||
            $this->form_validation->error_array()) {
            $main_view      = 'user/form';
            $form_action    = 'user/create';
            $heading    = 'Tambah User';

            $this->load->view('template',compact('main_view', 'form_action', 'heading', 'input','data'));
            return;
        }

        // Hash password
        $input->password = md5($input->password);

        if ($this->user->insert($input)) {
            $this->session->set_flashdata('success','Data user berhasil disimpan');
        } else {
            $this->session->set_flashdata('error','Data user gagal disimpan');
        }

        redirect('user');
    }
    ///////////////////////////////////////////////////////////

    //Callback
    public function alpha_space($str)
    {
        if (!preg_match('/^[a-zA-Z \-]+$/i',$str) )
        {
            $this->form_validation->set_message('alpha_space', 'Hanya boleh berisi huruf dan spasi');
            return false;
        }
    }

    public function no_induk_unik()
    {
        $no_induk = $this->input->post('no_induk');
        $id_user = $this->input->post('id_user');

        $this->user->where('no_induk',$no_induk);
        !$id_user || $this->user->where('id_user!=',$id_user);
        $user = $this->user->get();

        if (count($user)) {
            $this->form_validation->set_message('no_induk_unik','%s sudah digunakan');
            return false;
        }
        return true;
    }

    public function is_password_required()
    {
        $edit = $this->uri->segment(2);

        if ($edit != 'edit') {
            $password = $this->input->post('password', true);
            if (empty($password)) {
                $this->form_validation->set_message('is_password_required', '%s harus diisi');
                return false;
            }
        }
        return true;
    }

}