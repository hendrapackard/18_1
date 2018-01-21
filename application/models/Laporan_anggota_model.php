<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_anggota_model extends MY_Model
{
    //Server side
    protected $table = 'user';
    protected $column_order = array(null,'nama','no_induk','jenis_kelamin','no_hp','nama_kelas'); //set column field database for datatable orderable
    protected $column_search = array('nama','no_induk','jenis_kelamin','no_hp','nama_kelas'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    protected $order = array('nama' => 'asc'); // default order

    protected function _get_datatables_query()
    {

        $this->db->select('id_user,nama,no_induk,jenis_kelamin,no_hp,nama_kelas')
                ->from($this->table)
                ->join('kelas','user.id_kelas = kelas.id_kelas')
                ->where('level','anggota')
                ->where('is_verified','y');

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

    //query mendapatkan laporan anggota
    public function laporanAnggota()
    {
        return $this->db->select('id_user,nama,no_induk,jenis_kelamin,no_hp,nama_kelas')
                        ->from($this->table)
                        ->join('kelas','user.id_kelas = kelas.id_kelas')
                        ->where('level','anggota')
                        ->where('is_verified','y')
                        ->order_by('nama')
                        ->get()
                        ->result();
    }

}
