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

    public function insert2($input,$label)
    {
        $jumlah = $input->jumlah_buku;
        $id_judul = $input->id_judul;
        $label_buku = $this->db->select("IFNULL(MAX(label_buku),$label) AS labels", false)
                    ->where('id_judul',$id_judul)
                    ->get($this->table)->row();

        $prefix = substr($label_buku->labels,'0','9');// 500 Nun B
        $no_urut = (int) substr($label_buku->labels,'-4','4'); // 0
        $label_bukus = $this->createLabel($no_urut,$jumlah,$prefix);// 0,3,500 Nun B
        $data  = $this->prepData($label_bukus, $id_judul);

        $this->db->insert_batch('buku', $data);
        return $this->db->affected_rows();
    }

    private function createLabel($no_urut,$jumlah,$prefix){
        $data =[];
        for ($i=$no_urut ;$i<$no_urut+$jumlah;$i++)
        {
            $data [] =  $prefix.' '.sprintf("%04s", $i);//500 Nun B 0001-0003
        }
        return $data;
    }

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

    public function total($id_judul)
    {
        $sql = "    SELECT id_buku,
                           label_buku,
                           judul_buku,
                           penulis,
                           penerbit,
                           is_ada
                    FROM buku
                    INNER JOIN judul
                            ON (judul.id_judul = buku.id_judul)
                            WHERE buku.id_judul = $id_judul";

        return $this->db->query($sql)->result();
    }

    public function ada($id_judul)
    {
        $sql = "    SELECT id_buku,
                           label_buku,
                           judul_buku,
                           penulis,
                           penerbit
                    FROM   buku
                    INNER JOIN judul
                    ON         (judul.id_judul = buku.id_judul)
                    WHERE      buku.id_judul = $id_judul
                    AND is_ada = 'y' ";

        return $this->db->query($sql)->result();

    }
}