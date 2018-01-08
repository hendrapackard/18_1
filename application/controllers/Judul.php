<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Judul extends MY_Controller
{
    //////////////////////////////CRUD//////////////////////////////

    //Menampilkan Data Judul Buku
    public function index()
    {
        $main_view = 'judul/index';
        $this->load->view('template',compact( 'main_view'));
    }

    //Datatable serverside
    public function ajax_list()
    {
        $level = $this->session->userdata('level');
        $list = $this->judul->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $judul) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $judul->isbn;
            $row[] = $judul->judul_buku;
            $row[] = $judul->penulis;
            $row[] = $judul->penerbit;
            $row[] = $judul->jumlah_total != 0 ? anchor("buku/total/$judul->id_judul",$judul->jumlah_total) : $judul->jumlah_total;
            $row[] = $judul->jumlah_ada != 0 ? anchor("buku/ada/$judul->id_judul",$judul->jumlah_ada) : $judul->jumlah_ada;
            $row[] = $judul->jumlah_dipinjam != 0 ? anchor("buku/dipinjam/$judul->id_judul",$judul->jumlah_dipinjam) : $judul->jumlah_dipinjam ;

            if($judul->cover)
                $row[] = '<a href="'.base_url('cover/'.$judul->cover).'" target="_blank"><img src="'.base_url('cover/'.$judul->cover).'" style="border: 1px solid #aaaaaa; padding: 2px; width: 100px;" class="cover img-responsive" /></a>';
            else
                $row[] = '<img src="'.base_url('cover/no_cover.jpg').'" style="border: 1px solid #aaaaaa; padding: 2px; width: 100px;" class="cover img-responsive" />';

            $row[] = $judul->letak ;

            if ($level === 'admin')
            $row[] = form_open("buku/create").form_hidden('id_judul',$judul->id_judul).form_hidden('first_load',true).form_button(['type' => 'submit','content' => '<i class="material-icons">add</i>', 'class' => 'btn btn-success waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Tambah Copy Buku']).form_close();
            $row[] = anchor("judul/edit/$judul->id_judul",'<i class="material-icons">edit</i>', ['class' => 'btn btn-warning waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Edit']);
            $row[] = form_open("judul/delete/$judul->id_judul").form_hidden('id_judul',"$judul->id_judul").form_button(['type' => 'submit','content' => '<i class="material-icons">delete</i>', 'class' => 'btn btn-danger waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Delete','onclick' => "return confirm('Anda yakin akan menghapus judul ini?')"]).form_close();
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->judul->count_all(),
            "recordsFiltered" => $this->judul->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    ///////////////////////////////////////////////////////////


}