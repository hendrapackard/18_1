<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Peminjaman_anggota extends Anggota_Controller
{
    //Menampilkan Data Peminjaman Buku
    public function index()
    {
        $main_view  = 'peminjaman_anggota/index';
        $this->load->view('template',compact( 'main_view', 'peminjaman'));
    }

    //Datatable serverside
    public function ajax_list()
    {
        $id_user = $this->session->userdata('id_user');
        $list = $this->peminjaman_anggota->get_datatables_a($id_user);
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
            "recordsTotal" => $this->peminjaman_anggota->count_all(),
            "recordsFiltered" => $this->peminjaman_anggota->count_filtered_a($id_user),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    //Menambahkan Transaksi Peminjaman Buku
    public function create()
    {
        if (!$_POST){
            $input = (object) $this->peminjaman_anggota->getDefaultValues();
        } else {
            $input = (object) $this->input->post(null,true);
        }

        //validasi
        if (!$this->peminjaman_anggota->validate()) {
            $main_view = 'peminjaman_anggota/form';
            $form_action = 'peminjaman_anggota/create';

            $this->load->view('template',compact( 'main_view', 'form_action', 'input'));
            return;
        }

        //Cek, melebihi jumlah maksimum
        $id_user = $this->input->post('id_user');
        if (!$this->peminjaman_anggota->cekMaxItem($id_user)) {
            $this->session->set_flashdata('error','Tidak boleh meminjam lebih dari 2 buku!');
            redirect('peminjaman-anggota');
            return;
        }

        //Jika validasi, unset search_user andsearch_buku
        //Tidak membutuhkan item2 tersebut untuk disimpan ke database
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
                'id_user' => $input->id_user
            );
            $this->peminjaman_anggota->insert($record);
            $this->peminjaman_anggota->ubahStatusBuku($input->id_buku1, 'n');
            $this->session->set_flashdata('success', 'Berhasil mengajukan peminjaman');
        }

        //Cek, melebihi jumlah maksimum 2 input
        $id_user = $this->input->post('id_user');
        if (!$this->peminjaman_anggota->cekMaxItem2($id_user)) {
            $this->session->set_flashdata('error','Tidak boleh meminjam lebih dari 2 buku!');
            redirect('peminjaman-anggota');
            return;
        }

        //konfigurasi insert data jika judul pertama dan judul kedua yang diisi
        elseif ($this->peminjaman_anggota->insert2($input)) {

            //Ubah status "is_ada" -> n
            $this->peminjaman_anggota->ubahStatusBuku($input->id_buku1, 'n');
            $this->peminjaman_anggota->ubahStatusBuku($input->id_buku2, 'n');


            $this->session->set_flashdata('success', 'Berhasil mengajukan peminjaman');
        } else {
        $this->session->set_flashdata('error', 'Gagal mengajukan peminjaman');
        }

        redirect('peminjaman-anggota');
    }

    //Live search for buku
    public function buku_auto_complete()
    {
        $keywords = $this->input->post('keywords');
        $bukus = $this->peminjaman_anggota->liveSearchBuku($keywords);

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
        $bukus = $this->peminjaman_anggota->liveSearchBuku($keywords);

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
