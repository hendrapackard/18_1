<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Approve_pinjam_model extends MY_Model
{
    //Server side
    protected $table = 'peminjaman';
    protected $column_order = array('tanggal_pinjam','kode_pinjam','no_induk','nama','nama_kelas','label_buku','judul_buku',null,null); //set column field database for datatable orderable
    protected $column_search = array('tanggal_pinjam','kode_pinjam','no_induk','nama','nama_kelas','label_buku','judul_buku'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    protected $order = array('tanggal_pinjam' => 'desc'); // default order

    protected function _get_datatables_query()
    {
        $this->db->select('id_pinjam,kode_pinjam,tanggal_pinjam,no_induk,nama,nama_kelas,label_buku,judul_buku')
                 ->from($this->table)
                 ->join('user','peminjaman.id_user = user.id_user')
                 ->join('kelas','user.id_kelas = kelas.id_kelas')
                 ->join('buku','buku.id_buku = peminjaman.id_buku')
                 ->join('judul','buku.id_judul = judul.id_judul')
                 ->where('status','1');

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
        $this->db->from($this->table)->where('status','1');
        return $this->db->count_all_results();
    }
    ////////////////////////////////////

    //mengubah status pinjam menjadi 2
    public function ubahStatusPinjam($id_pinjam, $status)
    {
        $this->db->where('id_pinjam',$id_pinjam);
        $this->db->update('peminjaman',['status' => $status]);
    }

    //Mengubah status buku menjadi y
    public function ubahStatusBuku($id_buku, $status)
    {
        $this->db->where('id_buku',$id_buku);
        $this->db->update('buku',['is_ada' => $status]);
    }

}