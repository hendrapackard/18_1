<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Peminjaman_model extends MY_Model
{
    protected $maxItem = 2; //Jumlah maksimum buku

    //Server side
    protected $column_order = array('tanggal_pinjam','jadwal_kembali','kode_pinjam','no_induk','nama','nama_kelas','label_buku','judul_buku',null); //set column field database for datatable orderable
    protected $column_search = array('kode_pinjam','no_induk','nama','nama_kelas','label_buku','judul_buku'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    protected $order = array('id_pinjam' => 'desc'); // default order

    protected function _get_datatables_query()
    {

        $this->db->select('id_pinjam,kode_pinjam,tanggal_pinjam,jadwal_kembali,no_induk,nama,nama_kelas,label_buku,judul_buku,status')
            ->from('peminjaman')
            ->join('user','peminjaman.id_user=user.id_user')
            ->join('kelas','user.id_kelas = kelas.id_kelas')
            ->join('buku','buku.id_buku = peminjaman.id_buku')
            ->join('judul','buku.id_judul = judul.id_judul');

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

    //Mendapatkan aturan validasi
    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'kode_pinjam',
                'label' => 'Kode_pinjam',
                'rules' => 'trim|required|numeric'
            ],
            [
                'field' => 'tanggal_pinjam',
                'label' => 'Tanggal_pinjam',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'search_user',
                'label' => 'User',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'id_user',
                'label' => 'ID User',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'search_buku',
                'label' => 'Judul Buku',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'id_buku1',
                'label' => 'ID Buku',
                'rules' => 'trim|required'
            ],
        ];

        return $validationRules;
    }

    //Memberikan nilai default ketika pertama kali ditampilkan
    public function getDefaultValues()
    {
        return [
            'kode_pinjam' => '',
            'tanggal_pinjam' => '',
            'jadwal_kembali' => '',
            'id_user' => '',
            'id_buku1' => '',
            'id_buku2' => '',
            'search_user' => '',
            'search_buku' => '',
            'search_buku2' => '',
        ];
    }

    //Mengecheck jumlah peminjaman
    public function cekMaxItem($id_user)
    {
        $sql = "SELECT COUNT(id_pinjam) AS jumlah_item
                FROM peminjaman
                WHERE id_user = '$id_user'
                AND status != '4'";
        $item = $this->db->query($sql)->row()->jumlah_item;

        if ($item < $this->maxItem) {
            return true;
        }

        return false;
    }

    //Mengecheck jumlah peminjaman untuk 2 input
    public function cekMaxItem2($id_user)
    {
        $sql = "SELECT COUNT(id_pinjam) AS jumlah_item
                FROM peminjaman
                WHERE id_user = '$id_user'
                AND status != '4'";
        $item = $this->db->query($sql)->row()->jumlah_item;

        if ($item+1 < $this->maxItem) {
            return true;
        }

        return false;
    }

    //Mencari data user
    public function liveSearchUser($keywords)
    {
        return $this->db->select('id_user,no_induk,nama')
            ->like('no_induk',$keywords)
            ->or_like('nama', $keywords)
            ->where('is_verified','y')
            ->limit(10)
            ->get('user')
            ->result();
    }

    //Mencari data buku
    public function liveSearchBuku($keywords)
    {
        return $this->db->select('id_buku,label_buku,judul_buku')
                        ->join('judul','judul.id_judul = buku.id_judul')
                        ->where('is_ada','y')
                        ->like('judul_buku',"$keywords")
                        ->or_like('label_buku',"$keywords")
                        ->limit(10)
                        ->get('buku')
                        ->result();
    }

    //Memasukkan data ke database
    public function insert2($input)
    {
        $kode_pinjam = $input->kode_pinjam;
        $tanggal_pinjam  = $input->tanggal_pinjam;
        $jadwal_kembali  = $input->jadwal_kembali;
        $id_user  = $input->id_user;
        $id_bukus = $this->arrayID($input);
        $status  = $input->status;
        $data  = $this->prepData($kode_pinjam,$tanggal_pinjam,$jadwal_kembali,$id_user,$id_bukus,$status);

        $this->db->insert_batch('peminjaman', $data);
        return $this->db->affected_rows();
    }

    //Membuat array id buku
    private function arrayID($input)
    {
        return [
            'id_buku1' => $input->id_buku1,
            'id_buku2' => $input->id_buku2,
        ];
    }

    //Persiapan data sebelum di insert
    private function prepData($kode_pinjam,$tanggal_pinjam,$jadwal_kembali,$id_user,$id_bukus,$status)
    {
        $i = 0;
        $data = [];
        foreach($id_bukus as $id_buku) {

            $data[] = [
                'kode_pinjam'       => $kode_pinjam,
                'tanggal_pinjam'    => $tanggal_pinjam,
                'jadwal_kembali'    => $jadwal_kembali,
                'id_user'           => $id_user,
                'id_buku'           => $id_buku,
                'status'            => $status,
            ];
        }
        return $data;
    }

    //Ubah Status buku
    public function ubahStatusBuku($id_buku, $status)
    {
        $this->db->where('id_buku',$id_buku);
        $this->db->update('buku',['is_ada' => $status]);
    }

}