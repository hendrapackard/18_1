<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas_model extends MY_Model
{
    //Server side
    protected $column_order = array(null,'nama_kelas',null,null); //set column field database for datatable orderable
    protected $column_search = array('nama_kelas'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    protected $order = array('id_kelas' => 'asc'); // default order

    protected function _get_datatables_query()
    {

        $this->db->from($this->table);

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
                'field' => 'nama_kelas',
                'label' => 'Nama Kelas',
                'rules' => 'trim|required|min_length[1]|max_length[20]|callback_alpha_numeric_coma_dash_dot_space|callback_nama_kelas_unik'
            ],
        ];

        return $validationRules;
    }

    //Memberikan nilai default ketika pertama kali ditampilkan
    public function getDefaultValues()
    {
        return [
            'nama_kelas' => ''
        ];
    }

}