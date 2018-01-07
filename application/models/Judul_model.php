<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Judul_model extends MY_Model
{
    public function getAllJudul()
    {
        $sql = "SELECT judul.id_judul,
                        judul.judul_buku,
                        judul.isbn,
                        judul.penulis,
                        judul.penerbit,
                        judul.klasifikasi,
                        judul.cover,
                        judul.letak,
                        
                        /*jumlah total*/
                        IFNULL((SELECT COUNT(buku.id_buku)
                        FROM buku
                        WHERE buku.id_judul = judul.id_judul
                        GROUP BY buku.id_judul),0) AS jumlah_total,
                        
                        /*jumlah ada*/
                        IFNULL((SELECT COUNT(buku.id_buku)
                        FROM buku
                        WHERE buku.id_judul = judul.id_judul
                        AND buku.is_ada = 'y'
                        GROUP BY buku.id_judul),0) AS jumlah_ada,
                        
                        /*jumlah keluar*/
                        IFNULL((SELECT COUNT(buku.id_buku)
                        FROM buku
                        WHERE buku.id_judul = judul.id_judul
                        AND buku.is_ada = 'n'
                        GROUP BY buku.id_judul),0) AS jumlah_dipinjam
                        
                        FROM judul
                        GROUP BY judul.id_judul
                        ORDER BY judul.id_judul DESC";

        return $this->db->query($sql)->result();
    }

}