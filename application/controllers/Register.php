<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Register extends MY_Controller
{
    //Menampilkan Form Register
    public function index()
    {
        $input = (object)$this->register->getDefaultValues();
        $this->load->view('register_form',compact('input'));
    }

    //Menambahkan Create Register
    public function create()
    {
        if (!$_POST) {
            $input = (object)$this->register->getDefaultValues();

        } else {
            $input = (object)$this->input->post(null, true);
        }

        // Harus melampirkan gambar--------------------------------------------------------------------------------------
        if ($_POST && empty($_FILES['foto']['name'])) {
            $this->form_validation->add_to_error_array('foto', 'Foto harus diupload');
        }
        // --------------------------------------------------------------------------------------

        //Mendapatkan no anggota otomatis
        $data['autonumber'] = $this->register->autoNumber('user', 'no_anggota', 4, date("Ym"));

        //validasi
        if (!$this->register->validate() ||
            $this->form_validation->error_array()) {


            $this->load->view('register_form',compact(  'input','data'));
            return;
        }

        // Upload new foto (if any)
        if (!empty($_FILES) && $_FILES['foto']['size'] > 0) {

            $no_induk = $this->input->post('no_induk');
            $fotoFileName = $no_induk; //Cover file name
            $upload = $this->register->uploadFoto('foto',$fotoFileName);

            // Resize to 400x400px
            if ($upload) {
                $input->foto = "$fotoFileName.jpg";

                //Data for column "foto"
                $this->register->fotoResize('foto',"./foto/$fotoFileName.jpg",400,400);
            }
        }

        // Hash password
        $input->password = md5($input->password);

        if ($this->register->insert($input)) {
            $this->session->set_flashdata('success','Data user berhasil disimpan');
        } else {
            $this->session->set_flashdata('error','Data user gagal disimpan');
        }

        redirect('login');
    }

    //Callback
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

        $this->register->where('no_induk',$no_induk);
        !$id_user || $this->register->where('id_user!=',$id_user);
        $user = $this->register->get();

        if (count($user)) {
            $this->form_validation->set_message('no_induk_unik','%s sudah digunakan');
            return false;
        }
        return true;
    }
    /////////////////
}