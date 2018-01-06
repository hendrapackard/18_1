<?php


class User_model extends MY_Model
{
    //Server side
    var $column_order = array(null,'no_anggota','level','no_induk','nama','kelas.nama_kelas',null,null,null,null); //set column field database for datatable orderable
    var $column_search = array('no_anggota','no_induk','level','nama','kelas.nama_kelas'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('id_user' => 'asc'); // default order

    private function _get_datatables_query()
    {

        $this->db->from($this->table)
                 ->join('kelas', "$this->table.id_kelas = kelas.id_kelas", 'left');

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {

                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    ////////////////////////////////////

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
                'field' => 'is_verified',
                'label' => 'Verified ?',
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
                'rules' => 'trim|required|max_length[15]|numeric'
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
        return [
            'no_induk' => '',
            'password' => '',
            'level' => '',
            'is_verified' => '',
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
        $this->db->select($kolom);
        $this->db->limit(1);
        $this->db->order_by($kolom, 'desc');
        $this->db->from($table);
        $query = $this->db->get();

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