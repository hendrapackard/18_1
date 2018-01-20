<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pengembalian_model extends MY_Model
{
    protected $table        = 'peminjaman';
    protected $maxLama      = 3; // Lama maksimum peminjaman
    protected $dendaPerHari = 500;// Denda

    //Server side
    protected $column_order = array('tanggal_pinjam','jadwal_kembali','no_anggota','nama','nama_kelas','label_buku',null,null); //set column field database for datatable orderable
    protected $column_search = array('no_anggota','nama','nama_kelas','label_buku'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    protected $order = array('id_pinjam' => 'desc'); // default order

    protected function _get_datatables_query()
    {
        $currentDate = (string) date('Y-m-d');

        $this->db->select('id_pinjam,tanggal_pinjam,jadwal_kembali,no_anggota,nama,nama_kelas,label_buku')
            ->select("IF (DATEDIFF('$currentDate', tanggal_pinjam) > DATEDIFF(jadwal_kembali, tanggal_pinjam),
                     (DATEDIFF('$currentDate',tanggal_pinjam) - DATEDIFF(jadwal_kembali, tanggal_pinjam)) * $this->dendaPerHari,0) AS denda",false)
            ->from('peminjaman')
            ->join('user','peminjaman.id_user=user.id_user')
            ->join('kelas','user.id_kelas = kelas.id_kelas')
            ->join('buku','buku.id_buku = peminjaman.id_buku')
            ->join('judul','buku.id_judul = judul.id_judul')
            ->where('status','2');

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
    ////////////////////////////////


    //untuk mengembalikan buku
    public function kembalikan($id_pinjam, $denda)
    {
        // Insert denda
        if ((int) $denda > 0) {
            $this->db->insert('denda',[
                'id_pinjam'     => $id_pinjam,
                'jumlah'        => $denda,
                'tanggal_pembayaran' => date('Y-m-d'),
                'is_dibayar'         => 'y'
            ]);
        }

        //Set pengembalian
        $data = [
            'status' => '4',
            'tanggal_kembali' => date('Y-m-d')
        ];
        return $this->db->where('id_pinjam', $id_pinjam)->update($this->table, $data);
    }


    //Mengubah status buku
    public function ubahStatusBuku($id_buku)
    {
        return $this->db->where('id_buku',$id_buku)
            ->update('buku',['is_ada' => 'y']);
    }
}