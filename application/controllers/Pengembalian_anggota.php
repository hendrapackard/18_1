<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pengembalian_anggota extends Anggota_Controller
{
    //Menampilkan Data Pengembalian Buku
    public function index()
    {
        $main_view  = 'pengembalian_anggota/index';
        $this->load->view('template',compact('main_view'));
    }

    //Datatable serverside
    public function ajax_list()
    {
        $id_user = $this->session->userdata('id_user');
        $list = $this->pengembalian_anggota->get_datatables_a($id_user);
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
            $row[] = form_open("pengembalian_anggota/kembalikan")
                    .form_hidden('id_pinjam',$pengembalian->id_pinjam)
                    .form_button(['type' => 'submit','content' => 'Kembalikan', 'class' => 'btn btn-warning waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'bottom' ,'title' => 'Kembalikan','onclick' => "return confirm('Anda yakin akan mengembalikan buku?')"])
                    .form_close();
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->pengembalian_anggota->count_all_kembali($id_user),
            "recordsFiltered" => $this->pengembalian_anggota->count_filtered_a($id_user),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    //////////////////////////

    //Untuk mengembalikan buku
    public function kembalikan()
    {
        $id_pinjam = $this->input->post('id_pinjam');

        //Kembalikan
        $this->pengembalian_anggota->kembalikan($id_pinjam);

        $this->session->set_flashdata('success','Pengembalian Buku Berhasil Diajukan');
        redirect('pengembalian-anggota');
    }

}