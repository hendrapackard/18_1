<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Approve_anggota extends Admin_Controller
{

    //Menampilkan Data Approve Anggota
    public function index()
    {
        $main_view  = 'approve_anggota/index';
        $this->load->view('template',compact( 'main_view'));
    }

    //Datatable serverside
    public function ajax_list()
    {
        $list = $this->approve_anggota->get_datatables();
        $data = array();
        foreach ($list as $a_anggota) {
            $row = array();
            $row[] = $a_anggota->no_anggota;
            $row[] = $a_anggota->no_induk;
            $row[] = ucfirst($a_anggota->nama);
            $row[] = $a_anggota->jenis_kelamin == 'p' ? 'Perempuan' : 'Laki - Laki';
            $row[] = $a_anggota->no_hp;
            $row[] = $a_anggota->nama_kelas;
            $row[] = form_open("approve_anggota/approve/$a_anggota->id_user").form_hidden('id_user',$a_anggota->id_user).form_button(['type' => 'submit','content' => '<i class="material-icons">send</i>', 'class' => 'btn btn-primary waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Approve','onclick' => "return confirm('Anda yakin ?')"]).form_close();
            $row[] = form_open("approve_anggota/reject/$a_anggota->id_user").form_hidden('id_user',$a_anggota->id_user).form_button(['type' => 'submit','content' => '<i class="material-icons">clear</i>', 'class' => 'btn btn-danger waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Reject','onclick' => "return confirm('Anda yakin ?')"]).form_close();
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->approve_anggota->count_all(),
            "recordsFiltered" => $this->approve_anggota->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    //Untuk approve anggota
    public function approve($id = null)
    {
        $approve = $this->approve_anggota->where('id_user',$id)->get();
        if (!$approve) {
            $this->session->set_flashdata('warning','Data anggota tidak ada');
            redirect('approve-anggota');
        }

        //ubah status
        $this->approve_anggota->ubahStatus($approve->id_user, 'y');


        $this->session->set_flashdata('success','Data anggota baru berhasil diapprove');

        redirect('approve-anggota');
    }

    //Untuk Reject anggota
    public function reject($id = null)
    {
        $approve = $this->approve_anggota->where('id_user',$id)->get();
        if (!$approve) {
            $this->session->set_flashdata('warning','Data anggota tidak ada');
            redirect('approve-anggota');
        }

        //Hapus foto difolder dan hapus data didatabase
        $this->approve_anggota->deleteFoto($approve->foto);
        if  ($this->approve_anggota->where('id_user',$id)->delete()){

            $this->session->set_flashdata('success','Data anggota baru berhasil direject');
        } else  {
            $this->session->set_flashdata('error','Data user gagal dihapus');
        }

        redirect('approve-anggota');
    }

}
