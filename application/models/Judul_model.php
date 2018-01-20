<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Judul_model extends MY_Model
{
    //Server side
    protected $column_order = array(null,'isbn','judul_buku','penulis','penerbit','jumlah_total','jumlah_ada','jumlah_dipinjam',null,'letak',null,null,null); //set column field database for datatable orderable
    protected $column_search = array('isbn','judul_buku','penulis','penerbit','letak'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    protected $order = array('id_judul' => 'asc'); // default order

    protected function _get_datatables_query()
    {

        $this->db->select('judul.id_judul, judul.judul_buku, judul.isbn, judul.penulis, judul.penerbit, judul.klasifikasi, judul.cover, judul.letak')
            ->select("IFNULL((SELECT COUNT(buku.id_buku) FROM buku WHERE buku.id_judul = judul.id_judul GROUP BY buku.id_judul),0) AS jumlah_total", false)
            ->select("IFNULL((SELECT COUNT(buku.id_buku) FROM buku WHERE buku.id_judul = judul.id_judul AND buku.is_ada = 'y' GROUP BY buku.id_judul),0) AS jumlah_ada", false)
            ->select("IFNULL((SELECT COUNT(buku.id_buku) FROM buku WHERE buku.id_judul = judul.id_judul AND buku.is_ada = 'n' GROUP BY buku.id_judul),0) AS jumlah_dipinjam", false)
            ->from('judul');

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
    ////////////////////////////////////

    //Mendapatkan aturan validasi
    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'isbn',
                'label' => 'ISBN',
                'rules' => 'trim|required|min_length[10]|numeric|callback_isbn_unik'
            ],
            [
                'field' => 'judul_buku',
                'label' => 'Judul Buku',
                'rules' => 'trim|required|max_length[100]'
            ],
            [
                'field' => 'penulis',
                'label' => 'Penulis',
                'rules' => 'trim|required|max_length[30]|callback_alpha_space'
            ],
            [
                'field' => 'penerbit',
                'label' => 'Penerbit',
                'rules' => 'trim|required|max_length[30]'
            ],
            [
                'field' => 'klasifikasi',
                'label' => 'Klasifikasi',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'letak',
                'label' => 'Letak',
                'rules' => 'trim|required|max_length[20]'
            ],
        ];

        return $validationRules;
    }

    //Memberikan nilai default ketika pertama kali ditampilkan
    public function getDefaultValues()
    {
        return [
            'isbn' => '',
            'judul_buku' => '',
            'penulis' => '',
            'penerbit' => '',
            'klasifikasi' => '',
            'letak' => '',
            'cover' => '',

        ];
    }

    //Upload cover
    public function uploadCover($fieldname, $filename)
    {
        $config = [
            'upload_path' => './cover/',
            'file_name' => $filename,
            'allowed_types' => 'jpg', //Hanya jpg saja
            'max_size' => 1024, //1MB
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

    //Mengubah ukuran cover
    public function coverResize($fieldname, $source_path, $width, $height)
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

    //Menghapus Cover Buku
    public function deleteCover($imgFile)
    {
        if (file_exists("./cover/$imgFile")) {
            unlink("./cover/$imgFile");
        }
    }

}