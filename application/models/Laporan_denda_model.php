<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_denda_model extends MY_Model
{
    protected $table = 'user';

    //Query Laporan Denda
    public function laporanDenda($tanggal_awal, $tanggal_akhir)
    {
        return $this->db->select('no_induk,nama,jumlah,tanggal_pembayaran')
            ->join('peminjaman','peminjaman.id_user = user.id_user')
            ->join('denda','denda.id_pinjam = peminjaman.id_pinjam')
            ->where('denda.tanggal_pembayaran >',$tanggal_awal)
            ->where('denda.tanggal_pembayaran <',$tanggal_akhir)
            ->where('denda.is_dibayar','y')
            ->order_by('denda.id_pinjam','ASC')
            ->get($this->table)
            ->result();
    }

    //Query Menghitung Jumlah Denda
    public function laporanDendaTotal($tanggal_awal, $tanggal_akhir)
    {
        return $this->db->select('SUM(jumlah) AS jumlah_total',false)
                        ->where('denda.tanggal_pembayaran >',$tanggal_awal)
                        ->where('denda.tanggal_pembayaran <',$tanggal_akhir)
                        ->where('is_dibayar','y')
                        ->get('denda')
                        ->row();
    }

}
