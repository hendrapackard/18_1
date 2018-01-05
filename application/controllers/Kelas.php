<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends Admin_Controller
{
    //////////////////////////////CRUD//////////////////////////////

    //Menampilkan data kelas
    public function index()
    {
        $main_view = 'kelas/index';
        $this->load->view('template',compact('main_view','kelass'));
    }
    
    //Datatable serverside
    public function ajax_list()
    {
        $list = $this->kelas->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $kelas) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $kelas->nama_kelas;
            $row[] = anchor("kelas/edit/$kelas->id_kelas",'<i class="material-icons">edit</i>', ['class' => 'btn btn-warning waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Edit']);
            $row[] = form_open("kelas/delete/$1").form_hidden('id_kelas',"$1").form_button(['type' => 'submit','content' => '<i class="material-icons">delete</i>', 'class' => 'btn btn-danger waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Delete','onclick' => "return confirm('Anda yakin akan menghapus kelas ini?')"]).form_close();
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->kelas->count_all(),
            "recordsFiltered" => $this->kelas->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    ////////////////////////////////////////////////////////////////

}