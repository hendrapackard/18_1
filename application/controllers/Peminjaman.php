<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Peminjaman extends Admin_Controller
{
    //Menampilkan Data Peminjaman Buku
    public function index()
    {
        $main_view  = 'peminjaman/index';
        $this->load->view('template',compact( 'main_view', 'peminjaman'));
    }

    //Datatable serverside
    public function ajax_list()
    {
        $list = $this->peminjaman->get_datatables();
        $data = array();
        foreach ($list as $peminjaman) {
            $row = array();
            $row[] = $peminjaman->tanggal_pinjam;
            $row[] = $peminjaman->jadwal_kembali;
            $row[] = $peminjaman->kode_pinjam;
            $row[] = $peminjaman->no_induk;
            $row[] = $peminjaman->nama;
            $row[] = $peminjaman->nama_kelas;
            $row[] = $peminjaman->label_buku;
            $row[] = $peminjaman->judul_buku;
            $row[] = $peminjaman->status == '1' ? '<span class="label label-danger">Pengajuan Peminjaman' : ($peminjaman->status == '2' ? '<span class="label label-info">Berhasil Meminjam': ($peminjaman->status == '3' ? '<span class="label label-warning">Pengajuan Pengembalian':  '<span class="label label-success">Berhasil Dikembalikan'));
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->peminjaman->count_all(),
            "recordsFiltered" => $this->peminjaman->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

}
