<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pengembalian extends Admin_Controller
{
    //Menampilkan Data Peminjaman Buku
    public function index()
    {
        $main_view  = 'pengembalian/index';
        $form_action = 'pengembalian';
        $this->load->view('template',compact('main_view','form_action'));
    }

    //Datatable serverside
    public function ajax_list()
    {
        $list = $this->pengembalian->get_datatables();
        $data = array();
        foreach ($list as $pengembalian) {
            $row = array();
            $row[] = date('d-m-Y', strtotime($pengembalian->tanggal_pinjam));
            $row[] = date('d-m-Y', strtotime($pengembalian->jadwal_kembali));
            $row[] = $pengembalian->no_anggota;
            $row[] = $pengembalian->nama;
            $row[] = $pengembalian->nama_kelas;
            $row[] = $pengembalian->label_buku;
            $row[] = 'Rp. '.number_format($pengembalian->denda,0,',','.');
            $row[] = form_open("pengembalian/kembalikan")
                    .form_hidden('id_pinjam',$pengembalian->id_pinjam)
                    .form_hidden('denda',$pengembalian->denda)
                    .form_button(['type' => 'submit','content' => 'Kembalikan', 'class' => 'btn btn-warning waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'bottom' ,'title' => 'Kembalikan','onclick' => "return confirm('Anda yakin akan mengembalikan buku?')"])
                    .form_close();
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->pengembalian->count_all(),
            "recordsFiltered" => $this->pengembalian->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    //Untuk mengembalikan buku
    public function kembalikan()
    {
        $id_pinjam = $this->input->post('id_pinjam');
        $denda      = $this->input->post('denda');

        //Kembalikan
        $this->pengembalian->kembalikan($id_pinjam,$denda);

        //Set buku is ada =y
        $peminjaman = $this->pengembalian->where('id_pinjam',$id_pinjam)->get();
        $this->pengembalian->ubahStatusBuku($peminjaman->id_buku);

        $this->session->set_flashdata('success','Buku sudah dikembalikan');
        redirect('pengembalian');
    }

}