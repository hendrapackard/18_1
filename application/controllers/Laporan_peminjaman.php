<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_peminjaman extends Admin_Controller
{
    //Menampilkan data laporan peminjaman
    public function index()
    {
        if (!$_POST) {
            $input      = (object) ['tanggal_awal' => '', 'tanggal_akhir' => ''];
            $first_load = true;
        } else {
            $input         = (object) $this->input->post(null, true);
            $first_load    = false;
        }

        $peminjamans  = $this->laporan_peminjaman->laporanPeminjaman($input->tanggal_awal, $input->tanggal_akhir);
        $main_view    = 'laporan_peminjaman/index';
        $form_action  = 'laporan-peminjaman';
        $this->load->view('template', compact( 'main_view', 'input', 'peminjamans', 'first_load', 'form_action'));
    }

    public function cetak_laporan_peminjaman($tanggal_awal, $tanggal_akhir)
    {
        $peminjamans  = $this->laporan_peminjaman->laporanPeminjaman($tanggal_awal, $tanggal_akhir);
        $jumlah_total = count($peminjamans);

        // Template, return as string.
        $html = $this->load->view('laporan_peminjaman/peminjaman_pdf', compact('peminjamans', 'jumlah_total'), true);

        // Cetak dengan html2pdf
        require(APPPATH."/third_party/html2pdf_4_03/html2pdf.class.php");
        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array('20', '5', '20', '5'));
            $html2pdf->WriteHTML($html);
            $html2pdf->Output('laporan_peminjaman_'.date('Ymd').'.pdf');
        } catch (HTML2PDF_exception $e) {
            // echo $e;
            $this->session->set_flashdata('error', 'Maaf, kami mengalami kendala teknis.');
            redirect('laporan-peminjaman');
        }
    }

}
