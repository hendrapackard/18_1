<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Approve_anggota_model extends MY_Model
{
    //Server side
    protected $table = 'user';
    protected $column_order = array('no_anggota','no_induk','nama','jenis_kelamin','no_hp','nama_kelas',null,null); //set column field database for datatable orderable
    protected $column_search = array('no_anggota','no_induk','nama','jenis_kelamin','no_hp','nama_kelas'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    protected $order = array('no_anggota' => 'asc'); // default order

    protected function _get_datatables_query()
    {
        $this->db->select('id_user,no_anggota,no_induk,nama,jenis_kelamin,no_hp,nama_kelas')
                 ->from($this->table)
                 ->join('kelas','user.id_kelas = kelas.id_kelas')
                 ->where('is_verified','n');

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

    public function count_all()
    {
        $this->db->from($this->table)->where('is_verified','n');
        return $this->db->count_all_results();
    }
    ////////////////////////////////////

    //Mengubah status Menjadi terverifikasi
    public function ubahStatus($id_user, $status)
    {
        $this->db->where('id_user',$id_user);
        $this->db->update('user',['is_verified' => $status]);
    }

    //Menghapus Foto
    public function deleteFoto($imgFile)
    {
        if (file_exists("./foto/$imgFile")) {
            unlink("./foto/$imgFile");
        }
    }
}