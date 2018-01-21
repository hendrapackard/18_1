<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_buku extends Admin_Controller
{
    //Menampilkan data laporan buku
    public function index()
    {
        $main_view = 'laporan_buku/index';
        $this->load->view('template', compact( 'main_view'));
    }

    //Datatable serverside
    public function ajax_list()
    {
        $list = $this->laporan_buku->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $laporan_buku) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $laporan_buku->isbn;
            $row[] = $laporan_buku->judul_buku;
            $row[] = $laporan_buku->penulis;
            $row[] = $laporan_buku->penerbit;
            $row[] = $laporan_buku->jumlah;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->laporan_buku->count_all(),
            "recordsFiltered" => $this->laporan_buku->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    //Mencetak laporan Buku
    public function cetak_laporan_buku()
    {
        $bukus = $this->laporan_buku->laporanBuku();
        $total_buku = (object) $this->laporan_buku->getAllBukuCount();
        $jumlah_total = count($bukus);

        // Template, return as string.
        $html = $this->load->view('laporan_buku/buku_pdf', compact('bukus', 'jumlah_total','total_buku'), true);

        // Cetak dengan html2pdf
        require(APPPATH."/third_party/html2pdf_4_03/html2pdf.class.php");
        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array('20', '5', '20', '5'));
            $html2pdf->WriteHTML($html);
            $html2pdf->Output('laporan_buku_'.date('Ymd').'.pdf');
        } catch (HTML2PDF_exception $e) {
            // echo $e;
            $this->session->set_flashdata('error', 'Maaf, kami mengalami kendala teknis.');
            redirect('laporan-buku');
        }
    }

}
