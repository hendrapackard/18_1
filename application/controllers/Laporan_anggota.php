<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_anggota extends Admin_Controller
{
    //Menampilkan data laporan anggota
    public function index()
    {
        $main_view = 'laporan_anggota/index';
        $this->load->view('template', compact( 'main_view'));
    }

    //Datatable serverside
    public function ajax_list()
    {
        $list = $this->laporan_anggota->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $laporan_anggota) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = ucfirst($laporan_anggota->nama);
            $row[] = $laporan_anggota->no_induk;
            $row[] = $laporan_anggota->jenis_kelamin  == 'p' ? 'Perempuan' : 'Laki - Laki';
            $row[] = $laporan_anggota->no_hp;
            $row[] = $laporan_anggota->nama_kelas;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->laporan_anggota->count_all(),
            "recordsFiltered" => $this->laporan_anggota->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    //Mencetak laporan Buku
    public function cetak_laporan_anggota()
    {
        $anggotas = $this->laporan_anggota->laporanAnggota();
        $jumlah_total = count($anggotas);

        // Template, return as string.
        $html = $this->load->view('laporan_anggota/anggota_pdf', compact('anggotas', 'jumlah_total'), true);

        // Cetak dengan html2pdf
        require(APPPATH."/third_party/html2pdf_4_03/html2pdf.class.php");
        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array('20', '5', '20', '5'));
            $html2pdf->WriteHTML($html);
            $html2pdf->Output('laporan_anggota_'.date('Ymd').'.pdf');
        } catch (HTML2PDF_exception $e) {
            // echo $e;
            $this->session->set_flashdata('error', 'Maaf, kami mengalami kendala teknis.');
            redirect('laporan-anggota');
        }
    }

}
