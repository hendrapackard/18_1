<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends MY_Model
{
    public function grafikKelas()
    {
        return $this->db->select('nama_kelas AS kelas',false)
                        ->select('tanggal_pinjam')
                        ->select('COUNT(nama_kelas) AS jumlah',false)
                        ->join('user','peminjaman.id_user = user.id_user')
                        ->join('kelas','user.id_kelas = kelas.id_kelas')
                        ->where("year(tanggal_pinjam) = year(curdate())")
                        ->group_by('nama_kelas')
                        ->get('peminjaman')
                        ->result();
    }

    public function grafikBuku()
    {
        return $this->db->select('judul_buku AS judul',false)
                        ->select('COUNT(judul_buku) AS jumlah',false)
                        ->join('user','peminjaman.id_user = user.id_user')
                        ->join('kelas','user.id_kelas = kelas.id_kelas')
                        ->join('buku','buku.id_buku = peminjaman.id_buku')
                        ->join('judul','buku.id_judul = judul.id_judul')
                        ->where("year(tanggal_pinjam) = year(curdate())")
                        ->group_by('judul_buku')
                        ->order_by('jumlah','DESC')
                        ->limit(10)
                        ->get('peminjaman')
                        ->result();
    }

    public function getAllAnggotaCount()
    {
        return $this->db->select('COUNT(user.id_user) AS jmlAnggota',false)
                        ->where('user.level','anggota')
                        ->where('user.is_verified','y')
                        ->get('user')
                        ->row();
    }

    public function getAllJudulCount()
    {
        return $this->db->select('count(judul.id_judul) as jmlJudul',false)
                        ->get('judul')
                        ->row();
    }

    public function getAllBukuCount()
    {
        return $this->db->select('count(buku.id_judul) as jmlBuku',false)
                        ->get('buku')
                        ->row();
    }

    public function getAllKembaliCount()
    {
        return $this->db->select('count(peminjaman.id_pinjam) as jmlKembali',false)
                        ->where('peminjaman.status','2')
                        ->or_where('peminjaman.status','3')
                        ->get('peminjaman')
                        ->row();
    }
}