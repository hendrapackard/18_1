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
            $row[] = date('d-m-Y', strtotime($peminjaman->tanggal_pinjam));
            $row[] = date('d-m-Y', strtotime($peminjaman->jadwal_kembali));
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

    //Menambahkan Transaksi Peminjaman Buku
    public function create()
    {
        if (!$_POST){
            $input = (object) $this->peminjaman->getDefaultValues();
        } else {
            $input = (object) $this->input->post(null,true);
        }

        //validasi
        if (!$this->peminjaman->validate()) {
            $main_view = 'peminjaman/form';
            $form_action = 'peminjaman/create';

            $this->load->view('template',compact( 'main_view', 'form_action', 'input'));
            return;
        }

        //Cek, melebihi jumlah maksimum
        $id_user = $this->input->post('id_user');
        if (!$this->peminjaman->cekMaxItem($id_user)) {
            $this->session->set_flashdata('error','Tidak boleh meminjam lebih dari 2 buku!');
            redirect('peminjaman');
            return;
        }

        //Jika validasi, unset search_user andsearch_buku
        //Tidak membutuhkan item2 tersebut untuk disimpan ke database
        unset($input->search_user);
        unset($input->search_buku);
        unset($input->search_buku2);

        $id_buku2 = $input->id_buku2;

        //konfigurasi insert data jika judul pertama yang diisi
        if ($_POST && empty($id_buku2)){
            $record = array(
                'kode_pinjam' => $input->kode_pinjam,
                'id_buku' => $input->id_buku1,
                'tanggal_pinjam' => $input->tanggal_pinjam,
                'jadwal_kembali' => $input->jadwal_kembali,
                'status' => $input->status,
                'id_user' => $input->id_user
            );
            $this->peminjaman->insert($record);
            $this->peminjaman->ubahStatusBuku($input->id_buku1, 'n');
            $this->session->set_flashdata('success', 'Berhasil meminjam buku');

        }

        //Cek, melebihi jumlah maksimum input 2 buku
        $id_user = $this->input->post('id_user');
        if (!$this->peminjaman->cekMaxItem2($id_user)) {
            $this->session->set_flashdata('error','Tidak boleh meminjam lebih dari 2 buku!');
            redirect('peminjaman');
            return;
        }

        //konfigurasi insert data jika judul pertama dan judul kedua yang diisi
        elseif ($this->peminjaman->insert2($input)) {

            //Ubah status "is_ada" -> n
            $this->peminjaman->ubahStatusBuku($input->id_buku1, 'n');
            $this->peminjaman->ubahStatusBuku($input->id_buku2, 'n');


            $this->session->set_flashdata('success', 'Data peminjaman berhasil disimpan');
        } else {
        $this->session->set_flashdata('error', 'Data peminjaman gagal disimpan.');
        }

        redirect('peminjaman/index');
    }

    //Live search for user
    public function user_auto_complete()
    {
        $keywords = $this->input->post('keywords');
        $users = $this->peminjaman->liveSearchUser($keywords);

        foreach ($users as $user) {
            // Put in bold the written text.
            $no_induk    = str_replace($keywords, '<strong>'.$keywords.'</strong>', $user->no_induk);
            $nama_user = preg_replace("#($keywords)#i", "<strong>$1</strong>", $user->nama);

            //Add new option
            $str = '<li onclick="setItemUser(\''.$user->nama.'\'); makeHiddenIdUser(\''.$user->id_user.'\')">';
            $str .= "$no_induk - $nama_user";
            $str .= "</li>";

            echo $str;
        }
    }

    //Live search for buku
    public function buku_auto_complete()
    {
        $keywords = $this->input->post('keywords');
        $bukus = $this->peminjaman->liveSearchBuku($keywords);

        foreach ($bukus as $buku) {
            //Put in bold the written text
            $label_buku = preg_replace("#($keywords)#i", "<strong>$1</strong>", $buku->label_buku);
            $judul_buku = preg_replace("#($keywords)#i", "<strong>$1</strong>", $buku->judul_buku);

            // Add new option
            $str = '<li onclick="setItemBuku(\''.$buku->judul_buku.' - ( '.$buku->label_buku.' ) '.'\'); makeHiddenIdBuku(\''.$buku->id_buku.'\')">';
            $str .= "$judul_buku - $label_buku";
            $str .= '</li>';

            echo $str;
        }
    }

    //Live search for buku, input kedua
    public function buku_auto_complete2()
    {
        $keywords = $this->input->post('keywords');
        $bukus = $this->peminjaman->liveSearchBuku($keywords);

        foreach ($bukus as $buku) {
            //Put in bold the written text
            $label_buku = preg_replace("#($keywords)#i", "<strong>$1</strong>", $buku->label_buku);
            $judul_buku = preg_replace("#($keywords)#i", "<strong>$1</strong>", $buku->judul_buku);

            // Add new option
            $str = '<li onclick="setItemBuku2(\''.$buku->judul_buku.' - ( '.$buku->label_buku.' ) '.'\'); makeHiddenIdBuku2(\''.$buku->id_buku.'\')">';
            $str .= "$judul_buku - $label_buku";
            $str .= '</li>';

            echo $str;
        }
    }

}
