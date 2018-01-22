<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends MY_Model
{
    protected $table = 'user';

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'no_induk',
                'label' => 'No Induk',
                'rules' => 'trim|required|min_length[4]|max_length[30]|callback_no_induk_unik'
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|callback_is_password_required|min_length[4]|max_length[50]'
            ],
            [
                'field' => 'passConf',
                'label' => 'Konfirmasi Password',
                'rules' => 'trim|matches[password]|callback_is_password_required|min_length[4]|max_length[50]'
            ],
            [
                'field' => 'nama',
                'label' => 'Nama',
                'rules' => 'trim|required|max_length[30]|callback_alpha_space'
            ],
            [
                'field' => 'no_hp',
                'label' => 'No Handphone',
                'rules' => 'trim|required|max_length[15]|numeric'
            ],
        ];

        return $validationRules;
    }

    public function getDefaultValues()
    {
        return [
            'no_induk' => '',
            'password' => '',
            'nama' => '',
            'no_hp' => '',
        ];
    }

    //query menampilkan data profile
    public function getProfile($id)
    {
        return $this->db->where('id_user',$id)
                        ->join('kelas','kelas.id_kelas = user.id_kelas')
                        ->order_by('nama')
                        ->order_by('kelas.id_kelas')
                        ->get($this->table)
                        ->row();
    }

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

    public function deleteFoto($imgFile)
    {
        if (file_exists("./foto/$imgFile")) {
            unlink("./foto/$imgFile");
        }
    }


}