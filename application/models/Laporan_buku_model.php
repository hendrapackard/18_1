<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_buku_model extends MY_Model
{
    //Server side
    protected $table = 'judul';
    protected $column_order = array(null,'isbn','judul_buku','penulis','penerbit','jumlah'); //set column field database for datatable orderable
    protected $column_search = array('isbn','judul_buku','penulis','penerbit'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    protected $order = array('judul_buku' => 'asc'); // default order

    protected function _get_datatables_query()
    {

        $this->db->select('id_judul,judul_buku,isbn,penulis,penerbit')
                ->select("IFNULL((SELECT COUNT(buku.id_buku) FROM buku WHERE buku.id_judul = judul.id_judul GROUP BY buku.id_judul), 0) AS jumlah",false)
                ->from($this->table)
                ->group_by('id_judul');

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

    //query mendapatkan laporan buku
    public function laporanBuku()
    {
        return $this->db->select('id_judul,judul_buku,isbn,penulis,penerbit')
                        ->select("IFNULL((SELECT COUNT(buku.id_buku) FROM buku WHERE buku.id_judul = judul.id_judul GROUP BY buku.id_judul), 0) AS jumlah",false)
                        ->group_by('id_judul')
                        ->order_by('judul_buku')
                        ->get('judul')
                        ->result();
    }

    //query mendapatkan jumlah Buku
    public function getAllBukuCount()
    {
        return $this->db->select('count(buku.id_judul) as jmlBuku',false)
                        ->get('buku')
                        ->row();
    }
}
