<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Judul_model extends MY_Model
{
    //Server side
    var $column_order = array(null,'isbn','judul_buku','penulis','penerbit',null,null,'letak'); //set column field database for datatable orderable
    var $column_search = array('isbn','judul_buku','penulis','penerbit','letak'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('id_judul' => 'asc'); // default order

    private function _get_datatables_query()
    {

        $this->db->select('judul.id_judul, judul.judul_buku, judul.isbn, judul.penulis, judul.penerbit, judul.klasifikasi, judul.cover, judul.letak')
            ->select("IFNULL((SELECT COUNT(buku.id_buku) FROM buku WHERE buku.id_judul = judul.id_judul GROUP BY buku.id_judul),0) AS jumlah_total", false)
            ->select("IFNULL((SELECT COUNT(buku.id_buku) FROM buku WHERE buku.id_judul = judul.id_judul AND buku.is_ada = 'y' GROUP BY buku.id_judul),0) AS jumlah_ada", false)
            ->select("IFNULL((SELECT COUNT(buku.id_buku) FROM buku WHERE buku.id_judul = judul.id_judul AND buku.is_ada = 'n' GROUP BY buku.id_judul),0) AS jumlah_dipinjam", false)
            ->from('judul')
            ->group_by('judul.id_judul')
            ->order_by('judul.id_judul', 'DESC');

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

}