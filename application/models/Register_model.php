<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Register_model extends MY_Model
{
    protected $table        = 'user';

    //Mendapatkan aturan validasi
    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'no_induk',
                'label' => 'No Induk',
                'rules' => 'trim|required|numeric|max_length[20]|callback_no_induk_unik'
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|callback_is_password_required|min_length[4]|max_length[50]'
            ],
            [
                'field' => 'level',
                'label' => 'Level',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'nama',
                'label' => 'Nama',
                'rules' => 'trim|required|max_length[30]|callback_alpha_space'
            ],
            [
                'field' => 'jenis_kelamin',
                'label' => 'Jenis Kelamin',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'no_hp',
                'label' => 'No Handphone',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'id_kelas',
                'label' => 'Kelas',
                'rules' => 'trim|required'
            ],
        ];

        return $validationRules;
    }

    //Memberikan nilai default ketika pertama kali ditampilkan
    public function getDefaultValues()
    {
        $data['autonumber'] = $this->autoNumber('user', 'no_anggota', 4, date("Ym"));

        return [
            'no_anggota' => $data['autonumber'],
            'no_induk' => '',
            'password' => '',
            'level' => '',
            'nama' => '',
            'jenis_kelamin' => '',
            'no_hp' => '',
            'id_kelas' => ''
        ];
    }

    //Konfigurasi upload foto
    public function uploadFoto($fieldname, $filename)
    {
        $config = [
            'upload_path' => './foto/',
            'file_name' => $filename,
            'allowed_types' => 'jpg', //Hanya jpg saja
            'max_size' => 5120, //5MB
            'max_width' => 0,
            'max_height' => 0,
            'overwrite' => true,
            'file_ext_tolower' => true,
        ];

        $this->load->library('upload',$config);
        if ($this->upload->do_upload($fieldname)) {
            // Upload OK, return uploaded file info
            return $this->upload->data();
        }else {
            //Add error to $_error_array
            $this->form_validation->add_to_error_array($fieldname,$this->upload->display_errors('',''));
            return false;
        }
    }

    //Mengubah ukuran foto
    public function fotoResize($fieldname, $source_path, $width, $height)
    {
        $config = [
            'image_library' => 'gd2',
            'source_image' => $source_path,
            'maintain_ratio' => true,
            'width' => $width,
            'height' => $height,
        ];

        $this->load->library('image_lib',$config);

        if ($this->image_lib->resize()) {
            return true;
        } else {
            $this->form_validation->add_to_error_array($fieldname, $this->image_lib->display_errors('',''));
            return false;
        }
    }

    //Menghapus Foto
    public function deleteFoto($imgFile)
    {
        if (file_exists("./foto/$imgFile")) {
            unlink("./foto/$imgFile");
        }
    }

    //membuat otomatis nomor anggota
    public function autoNumber($table, $kolom, $lebar=0, $awalan=null)
    {
        $query = $this->db->select($kolom)
                          ->limit(1)
                          ->order_by($kolom, 'desc')
                          ->from($table)
                          ->get();

        $row = $query->result_array();
        $cek = $query->num_rows();

        if ($cek == 0)
            $nomor = 1;
        else
        {
            $nomor = intval(substr($row[0][$kolom], strlen($awalan)))+1;
        }

        if ($lebar > 0)
        {
            $result = $awalan.str_pad($nomor, $lebar, "0", STR_PAD_LEFT);
        }
        else
        {
            $result = $awalan.$nomor;
        }

        return $result;
    }

}