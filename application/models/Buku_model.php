<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Buku_model extends MY_Model
{
    //Mendapatkan aturan validasi
    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'jumlah_buku',
                'label' => 'Jumlah Buku',
                'rules' => "trim|required|is_natural_no_zero|max_length[2]|numeric"
            ]
        ];

        return $validationRules;
    }

    //Memberikan nilai default ketika pertama kali ditampilkan
    public function getDefaultValues()
    {
        return[
            'jumlah_buku' => ''
        ];
    }

    //Query mendapatkan data judul
    public function getJudul($id_judul)
    {
        return $this->db->select('judul.isbn,label_buku,judul_buku,penulis,penerbit,klasifikasi,letak,cover')
            ->join('buku','buku.id_judul=judul.id_judul')
            ->where('judul.id_judul',$id_judul)
            ->order_by('label_buku','DESC')
            ->get('judul')
            ->row();
    }

    //Memasukkan data copy buku
    public function insert2($input,$label)
    {
        $jumlah = $input->jumlah_buku;
        $id_judul = $input->id_judul;
        $label_buku = $this->db->select("IFNULL(MAX(label_buku),\"$label\") AS labels", false)
                    ->where('id_judul',$id_judul)
                    ->get($this->table)->row();

        $prefix = substr($label_buku->labels,'0','15');// 500 Nun B 0001-
        $no_urut = (int) substr($label_buku->labels,'-4','4'); // 0
        $label_bukus = $this->createLabel($no_urut,$jumlah,$prefix);// 0,3,500 Nun B 0001-
        $data  = $this->prepData($label_bukus, $id_judul);

        $this->db->insert_batch('buku', $data);
        return $this->db->affected_rows();
    }

    //Membuat array label buku
    private function createLabel($no_urut,$jumlah,$prefix){
        $data =[];
        for ($i=($no_urut+1) ;$i<=($no_urut+$jumlah);$i++)
        {
            $data [] =  $prefix.sprintf("%04s", $i);//500 Nun B 0001-0003
        }
        return $data;
    }

    //Prepare data sebelum di insert
    private function prepData($label_bukus, $id_judul)
    {
        $data = [];
        foreach($label_bukus as $label_buku) {

            $data[] = [
                'label_buku' => $label_buku,
                'id_judul'       => $id_judul
            ];
        }
        return $data;
    }

    //query menampikan total buku
    public function total($id_judul)
    {
        return $this->db->select('id_buku,label_buku,judul_buku,penulis,penerbit,is_ada')
            ->join('judul','buku.id_judul = judul.id_judul')
            ->where("buku.id_judul = $id_judul")
            ->get('buku')
            ->result();
    }

    //query menampikan buku yang tersedia
    public function ada($id_judul)
    {
        return $this->db->select('id_buku,label_buku,judul_buku,penulis,penerbit')
            ->join('judul','buku.id_judul = judul.id_judul')
            ->where("buku.id_judul = $id_judul")
            ->where("is_ada",'y')
            ->get('buku')
            ->result();
    }

    //query menampikan buku yang dipinjam
    public function dipinjam($id_judul)
    {
        return $this->db->select('buku.id_buku,label_buku,judul_buku,penulis,penerbit,nama_kelas')
            ->select('nama AS peminjam',false)
            ->join('judul','buku.id_judul = judul.id_judul')
            ->join('peminjaman','peminjaman.id_buku = buku.id_buku')
            ->join('user','user.id_user = peminjaman.id_user')
            ->join('kelas','kelas.id_kelas = user.id_kelas')
            ->where("buku.id_judul = $id_judul")
            ->where("is_ada",'n')
            ->where("peminjaman.status !=",'4')
            ->get('buku')
            ->result();
    }
}