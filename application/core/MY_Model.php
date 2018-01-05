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

    public function query($sql)
    {
        return $this->db->query($sql);//method untuk menjalankan query biasa
    }

    public function get()
    {
        return $this->db->get($this->table)->row();//untuk mendapatkan query yang menghasilkan satu baris data
    }

    public function getAll()
    {
        return $this->db->get($this->table)->result();//untuk mendapatkan query yang menghasilkan multiple record
    }


    public function select($columns)//untuk memilih kolom pada tabel yang ingin ditampilkan datanya
    {
        $this->db->select($columns);
        return $this;
    }

    public function where($column, $condition)//untuk menambahkan where pada query
    {
        $this->db->where($column, $condition);
        return $this;
    }

    public function orLike($column, $condition)//untuk menambahkan OR... LIKE pada query
    {
        $this->db->or_like($column,$condition);
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

    public function join($table, $type = 'left')//untuk melakukan join dengan tabel lain
    {
        $this->db->join($table, "$this->table.id_$table = $table.id_$table", $type);
        return $this;
    }

    public function orderBy($kolom, $order = 'asc')//untuk mengurutkan hasil query
    {
        $this->db->order_by($kolom, $order);
        return $this;
    }

}