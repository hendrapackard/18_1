<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Approve_pinjam extends Admin_Controller
{

    //Menampilkan Data Approve Pinjam
    public function index()
    {
        $main_view  = 'approve_pinjam/index';
        $this->load->view('template',compact( 'main_view'));
    }

    //Datatable serverside
    public function ajax_list()
    {
        $list = $this->approve_pinjam->get_datatables();
        $data = array();
        foreach ($list as $a_pinjam) {
            $row = array();
            $row[] = $a_pinjam->tanggal_pinjam;
            $row[] = $a_pinjam->kode_pinjam;
            $row[] = $a_pinjam->no_induk;
            $row[] = ucfirst($a_pinjam->nama);
            $row[] = $a_pinjam->nama_kelas;
            $row[] = $a_pinjam->label_buku;
            $row[] = $a_pinjam->judul_buku;
            $row[] = form_open("approve_pinjam/approve/$a_pinjam->id_pinjam").form_hidden('id_pinjam',$a_pinjam->id_pinjam).form_button(['type' => 'submit','content' => '<i class="material-icons">send</i>', 'class' => 'btn btn-primary waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Approve','onclick' => "return confirm('Anda yakin ?')"]).form_close();
            $row[] = form_open("approve_pinjam/reject/$a_pinjam->id_pinjam").form_hidden('id_pinjam',$a_pinjam->id_pinjam).form_button(['type' => 'submit','content' => '<i class="material-icons">clear</i>', 'class' => 'btn btn-danger waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Reject','onclick' => "return confirm('Anda yakin ?')"]).form_close();
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->approve_pinjam->count_all(),
            "recordsFiltered" => $this->approve_pinjam->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    //Untuk approve pinjam
    public function approve($id = null)
    {
        $approve = $this->approve_pinjam->where('id_pinjam',$id)->get();
        if (!$approve) {
            $this->session->set_flashdata('warning','Data peminjaman tidak ada');
            redirect('approve-pinjam');
        }

        $this->approve_pinjam->ubahStatusPinjam($approve->id_pinjam, '2');


        $this->session->set_flashdata('success','Data peminjaman berhasil diapprove');

        redirect('approve-pinjam');
    }

    //Untuk Reject pinjam
    public function reject($id = null)
    {
        $approve = $this->approve_pinjam->where('id_pinjam',$id)->get();
        if (!$approve) {
            $this->session->set_flashdata('warning','Data peminjaman tidak ada');
            redirect('approve-pinjam');
        }

        $this->approve_pinjam->where('id_pinjam',$id)->delete();
        $this->approve_pinjam->ubahStatusBuku($approve->id_buku, 'y');


        $this->session->set_flashdata('error','Data peminjaman berhasil direject');

        redirect('approve-pinjam');
    }

}
