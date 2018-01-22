<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_peminjaman_model extends MY_Model
{
    protected $table = 'peminjaman';

    public function laporanPeminjaman($tanggal_awal, $tanggal_akhir)
    {
        return $this->db->select('peminjaman.id_pinjam,peminjaman.tanggal_pinjam,user.no_induk,user.nama,buku.label_buku,judul.judul_buku')
            ->join('buku','peminjaman.id_buku = buku.id_buku')
            ->join('judul','buku.id_judul = judul.id_judul')
            ->join('user','peminjaman.id_user = user.id_user')
            ->where('peminjaman.tanggal_pinjam >',$tanggal_awal)
            ->where('peminjaman.tanggal_pinjam <',$tanggal_akhir)
            ->get($this->table)
            ->result();
    }

}
