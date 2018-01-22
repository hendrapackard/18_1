<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_pengembalian_model extends MY_Model
{
    protected $table = 'peminjaman';

    //Query Laporan Pengembalian
    public function laporanPengembalian($tanggal_awal, $tanggal_akhir)
    {
        return $this->db->select('peminjaman.id_pinjam,peminjaman.tanggal_kembali,user.no_induk,user.nama,buku.label_buku,judul.judul_buku')
            ->join('buku','peminjaman.id_buku = buku.id_buku')
            ->join('judul','buku.id_judul = judul.id_judul')
            ->join('user','peminjaman.id_user = user.id_user')
            ->where('peminjaman.tanggal_kembali >',$tanggal_awal)
            ->where('peminjaman.tanggal_kembali <',$tanggal_akhir)
            ->where('status','4')
            ->order_by('peminjaman.tanggal_kembali','ASC')
            ->get($this->table)
            ->result();
    }

}
