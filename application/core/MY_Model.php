<?php
class MY_Model extends CI_Model
{
    protected $table = ''; // nama tabel yang berhubungan dengan database

    public function __construct()
    {
        parent::__construct();

        if (!$this->table) {
            $this->table = strtolower(str_replace('_model','',get_class($this))); //fungsi untuk menentukan nama tabel secara otomatis berdasarkan nama model jika tidak dideklarasikan variabel $table di child class
        }
    }

    public function get()
    {
        return $this->db->get($this->table)->row();//untuk mendapatkan query yang menghasilkan satu baris data
    }

    public function where($column, $condition)//untuk menambahkan where pada query
    {
        $this->db->where($column, $condition);
        return $this;
    }

    public function validate()//untuk menjalankan form validasi
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="form-error">', '</p>');
        $validationRules = $this->getValidationRules();
        $this->form_validation->set_rules($validationRules);
        return $this->form_validation->run();
    }

    public function insert($data)//untuk menyimpan data ke tabel database
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($data)//untuk mengupdate data
    {
        return $this->db->update($this->table, $data);
    }

    public function delete()//untuk menghapus data
    {
        $this->db->delete($this->table);
        return $this->db->affected_rows();
    }

    //Datatable Serverside
    public function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
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
    //////////////////

}