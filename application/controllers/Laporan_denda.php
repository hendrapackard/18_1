<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_denda extends Admin_Controller
{
    //Menampilkan data laporan denda
    public function index()
    {
        if (!$_POST) {
            $input      = (object) ['tanggal_awal' => '', 'tanggal_akhir' => ''];
            $first_load = true;
        } else {
            $input         = (object) $this->input->post(null, true);
            $first_load    = false;
        }

        $dendas = $this->laporan_denda->laporanDenda($input->tanggal_awal, $input->tanggal_akhir);
        $main_view    = 'laporan_denda/index';
        $form_action  = 'laporan-denda';
        $this->load->view('template', compact('main_view', 'input', 'dendas','first_load', 'form_action'));
    }

    //Cetak Laporan Denda
    public function cetak_laporan_denda($tanggal_awal, $tanggal_akhir)
    {
        $dendas = $this->laporan_denda->laporanDenda($tanggal_awal, $tanggal_akhir);
        $jumlah_total = $this->laporan_denda->laporanDendaTotal($tanggal_awal, $tanggal_akhir)->jumlah_total;

        // Template, return as string.
        $html = $this->load->view('laporan_denda/denda_pdf', compact('dendas', 'jumlah_total'), true);

        // Cetak dengan html2pdf
        require(APPPATH . "/third_party/html2pdf_4_03/html2pdf.class.php");
        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array('20', '5', '20', '5'));
            $html2pdf->WriteHTML($html);
            $html2pdf->Output('laporan_denda_' . date('Ymd') . '.pdf');
        } catch (HTML2PDF_exception $e) {
            // echo $e;
            $this->session->set_flashdata('error', 'Maaf, kami mengalami kendala teknis.');
            redirect('laporan-denda');
        }
    }

}
