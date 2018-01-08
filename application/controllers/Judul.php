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

    //Harus Login terlebih dahulu
    protected function isLogin()
    {
        $isLogin = $this->session->userdata('is_login');
        if(!$isLogin) {
            redirect(base_url());
        }
    }

    // Menambahkan Judul Buku
    public function create()
    {
        $this->isLogin();

        if(!$_POST) {
            $input = (object)$this->judul->getDefaultValues();
        } else {
            $input = (object) $this->input->post(null,true);
        }

        if (!empty($_FILES) && $_FILES['cover']['size'] > 0) {
            $coverFileName = date('YmdHis'); //Cover file name
            $upload = $this->judul->uploadCover('cover',$coverFileName);

            if ($upload) {
                $input->cover = "$coverFileName.jpg";

                //Data for column "cover"
                $this->judul->coverResize('cover',"./cover/$coverFileName.jpg",100,150);
            }
        }

        if (!$this->judul->validate() ||
            $this->form_validation->error_array()) {
            $main_view  = 'judul/form';
            $form_action = 'judul/create';
            $heading = 'Tambah Judul Buku';
            $this->load->view('template',compact( 'main_view', 'form_action','heading','input'));
            return;

        }

        if ($this->judul->insert($input)) {
            $this->session->set_flashdata('success','Data judul berhasil disimpan');
        } else {
            $this->session->set_flashdata('error','Data judul gagal disimpan');
        }
        redirect('judul');
    }

    //Mengedit Data Judul Buku
    public function edit($id = null)
    {
        $this->isLogin();

        $judul = $this->judul->where('id_judul', $id)->get();
        if (!$judul) {
            $this->session->set_flashdata('warning','Data judul tidak ada');
            redirect('judul');
        }

        if (!$_POST) {
            $input = (object) $judul;
        } else {
            $input = (object) $this->input->post(null, true);
            $input->cover = $judul->cover;
            //set cover untuk preview
        }

        //upload new cover (if any)
        if(!empty($_FILES) && $_FILES['cover'] ['size'] > 0) {
            //upload new cover (if any)
            $coverFileName = date('YmdHis'); //Cover file name
            $upload = $this->judul->uploadCover('cover', $coverFileName);

            //Resize to 100x150px
            if ($upload) {
                $input->cover = "$coverFileName.jpg";
                $this->judul->coverResize('cover', "./cover/$coverFileName.jpg", 100, 150);

                //            Delete old cover
                if ($judul->cover) {
                    $this->judul->deleteCover($judul->cover);
                }
            }
        }

        // Something Wrong
        if(!$this->judul->validate() ||
            $this->form_validation->error_array()) {
            $main_view = 'judul/form';
            $form_action = "judul/edit/$id";
            $heading = "Edit Judul Buku";
            $this->load->view('template', compact('main_view','form_action','heading','input'));
            return;
        }

        // Update data
        if ($this->judul->where('id_judul',$id)->update($input)) {
            $this->session->set_flashdata('success','Data judul berhasil diupdate');
        } else {
            $this->session->set_flashdata('error','Data judul gagal diupdate');
        }
        redirect('judul');
    }

    //Menghapus Judul Buku
    public function delete($id = null)
    {
        $this->isLogin();

        $judul = $this->judul->where('id_judul',$id)->get();
        if (!$judul) {
            $this->session->set_flashdata('warning', 'Data judul tidak ada.');
            redirect('judul');
        }

        if ($this->judul->where('id_judul',$id)->delete()) {
//            Delete cover
            $this->judul->deleteCover($judul->cover);
            $this->session->set_flashdata('success', 'Data judul berhasil dihapus');
        } else {
            $this->session->set_flashdata('error','Data judul gagal dihapus');
        }

        redirect('judul');
    }

    ///////////////////////////////////////////////////////////

    //Callback
    public function isbn_unik()
    {
        $isbn   = $this->input->post('isbn',true);
        $id_judul = $this->input->post('id_judul',true);

        $this->judul->where('isbn',$isbn);
        !$id_judul || $this->judul->where('id_judul !=', $id_judul);
        $judul = $this->judul->get();

        if (count($judul)) {
            $this->form_validation->set_message('isbn_unik', '%s sudah digunakan');
            return false;
        }

        return true;
    }

    public function alpha_space($str)
    {
        if (!preg_match('/^[a-zA-Z \-]+$/i',$str) )
        {
            $this->form_validation->set_message('alpha_space', 'Hanya boleh berisi huruf dan spasi');
            return false;
        }
    }

}