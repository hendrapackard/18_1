<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Approve_kembali extends Admin_Controller
{

    //Menampilkan Data Approve Kembali
    public function index()
    {
        $main_view  = 'approve_kembali/index';
        $this->load->view('template',compact( 'main_view'));
    }

    //Datatable serverside
    public function ajax_list()
    {
        $list = $this->approve_kembali->get_datatables();
        $data = array();
        foreach ($list as $a_kembali) {
            $row = array();
            $row[] = date('d-m-Y', strtotime($a_kembali->tanggal_pinjam));
            $row[] = date('d-m-Y', strtotime($a_kembali->jadwal_kembali));
            $row[] = $a_kembali->no_anggota;
            $row[] = $a_kembali->nama;
            $row[] = $a_kembali->nama_kelas;
            $row[] = $a_kembali->label_buku;
            $row[] = 'Rp. '.number_format($a_kembali->denda,0,',','.');
            $row[] = form_open("pengembalian/kembalikan")
                    .form_hidden('id_pinjam',$a_kembali->id_pinjam)
                    .form_hidden('denda',$a_kembali->denda)
                    .form_button(['type' => 'submit','content' => 'Kembalikan', 'class' => 'btn btn-warning waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'bottom' ,'title' => 'Kembalikan','onclick' => "return confirm('Anda yakin akan mengembalikan buku?')"])
                    .form_close();
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->approve_kembali->count_all(),
            "recordsFiltered" => $this->approve_kembali->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    //Untuk approve kembali
    public function kembalikan()
    {
        $id_pinjam = $this->input->post('id_pinjam');
        $denda      = $this->input->post('denda');

        //Kembalikan
        $this->approve_kembali->kembalikan($id_pinjam,$denda);

        // Set buku is ada =y
        $peminjaman = $this->approve_kembali->where('id_pinjam',$id_pinjam)->get();
        $this->approve_kembali->ubahStatusBuku($peminjaman->id_buku);

        $this->session->set_flashdata('success','Buku sudah dikembalikan');
        redirect('approve-kembali');
    }

}
