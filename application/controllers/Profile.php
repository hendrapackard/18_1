<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends Anggota_Controller
{
    //Menampilkan halaman Profile
    public function index()
    {
        $id     = $this->session->userdata('id_user');
        $profiles = $this->profile->getProfile($id);

        if (!$profiles) {
            redirect('profile');
        }

        $main_view  = 'profile/index';
        $this->load->view('template',compact('main_view', 'profiles'));
    }

    //Mengubah data profile
    public function edit()
    {
        $id = $this->session->userdata('id_user');
        $profiles = $this->profile->where('id_user', $id)->get();

        if (!$profiles) {
            redirect('profile');
        }

        $input = (object)$this->input->post(null, true);
        $input->foto = $profiles->foto;

        if (!$_POST) {
            $input = (object)$profiles;
            $input->password = '';
        }

        //validasi
        if (!$this->profile->validate() ||
            $this->form_validation->error_array()) {
            $main_view = 'profile/form';
            $form_action = "profile/edit";

            $this->load->view('template', compact('main_view', 'form_action', 'input'));
            return;
        }

        //upload new cover (if any)
        if(!empty($_FILES) && $_FILES['foto'] ['size'] > 0) {
            //upload new cover (if any)
            $no_induk = $this->input->post('no_induk');
            $fotoFileName = $no_induk.'-'.date('YmdHis'); //Cover file name
            $upload = $this->profile->uploadFoto('foto', $fotoFileName);

            if ($upload) {
                $input->foto = "$fotoFileName.jpg";
                $this->profile->fotoResize('foto', "./foto/$fotoFileName.jpg",400,400);

            //Delete old foto
                if ($profiles->foto) {
                    $this->profile->deleteFoto($profiles->foto);
                }
            }
        }

        //Passwordstring
        if (!empty($input->password)) {
            $input->password = md5($input->password);
        } else {
            unset($input->password);
        }

        //hapus passconf, tidak perlu disimpan ke database
        unset($input->passConf);

        if ($this->profile->where('id_user',$id)->update($input)) {
            $this->session->set_flashdata('success','Data profile berhasil diupdate');
            $this->session->set_userdata('no_induk',$input->no_induk);
        } else {
            $this->session->set_flashdata('error','Data profile gagal diupdate');
        }

        redirect('profile');

    }

    //callback
    public function no_induk_unik()
    {
        $no_induk = $this->input->post('no_induk');
        $id_user = $this->input->post('id_user');

        $this->profile->where('no_induk',$no_induk);
        !$id_user || $this->profile->where('id_user!=',$id_user);
        $user = $this->profile->get();

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

    public function alpha_space($str)
    {
        if (!preg_match('/^[a-zA-Z \-]+$/i',$str) )
        {
            $this->form_validation->set_message('alpha_space', 'Hanya boleh berisi huruf dan spasi');
            return false;
        }
        return true;
    }
}