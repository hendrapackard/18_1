<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Admin_Controller
{
    //Menampilkan data user
    public function index()
    {
        $main_view  = 'user/index';
        $this->load->view('template',compact('main_view'));
    }

    //Datatable serverside
    public function ajax_list()
    {
        $list = $this->user->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $user) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $user->no_anggota;
            $row[] = $user->level;
            $row[] = $user->no_induk;
            $row[] = $user->nama;
            $row[] = $user->nama_kelas;
            $row[] = $user->is_verified == 'n' ? '<span class="label label-danger">Belum Terverifikasi' : '<span class="label label-success">Terverifikasi';
            $row[] = $user->level == 'admin' || $user->is_verified == 'n' ? ''  : anchor("user/cetak_kartu_anggota/$user->id_user",'<i class="material-icons">print</i>',['class' => 'btn btn-info waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Cetak Kartu','target' => '_blank','onClick'=>"window.open('user/cetak_kartu_anggota/$user->id_user','pagename','resizable,height=600,width=400'); return false;"]);
            $row[] = anchor("user/edit/$user->id_user",'<i class="material-icons">edit</i>', ['class' => 'btn btn-warning waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Edit']);
            $row[] = form_open("user/delete/$user->id_user").form_hidden('id_user',"$user->id_user").form_button(['type' => 'submit','content' => '<i class="material-icons">delete</i>', 'class' => 'btn btn-danger waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Delete','onclick' => "return confirm('Anda yakin akan menghapus user ini?')"]).form_close();
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->user->count_all(),
            "recordsFiltered" => $this->user->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

}