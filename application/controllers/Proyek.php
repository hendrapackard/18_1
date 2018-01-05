<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Proyek extends Admin_Controller
{
    //////////////////////////////CRUD//////////////////////////////

    public function index($page = null)
    {
        $proyeks = $this->proyek->orderBy('id_proyek')->getAll('');
        $main_view = 'proyek/index';
        $this->load->view('template',compact('main_view','proyeks'));
    }

    public function create()
    {
        if (!$_POST) {
            $input = (object)$this->proyek->getDefaultValues();
        } else {
            $input = (object)$this->input->post(null, true);
        }

        if (!$this->proyek->validate()) {


            $main_view = 'proyek/form';
            $form_action = 'proyek/create';


            $this->load->view('template', compact('main_view', 'form_action', 'input'));
            return;
        }

        if ($this->proyek->insert($input)) {
            $this->session->set_flashdata('success', 'Data proyek berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error', 'Data proyek gagal disimpan.');
        }

        redirect('proyek');

    }

    public function edit($id = null)
    {
        $proyek = $this->proyek->where('id_proyek',$id)->get();
        if (!$proyek) {
            $this->session->set_flashdata('warning', 'Data proyek tidak ada.');
            redirect('proyek');
        }

        if (!$_POST) {
            $input =(object) $proyek;
        } else {
            $input = (object) $this->input->post(null,true);
        }

        if (!$this->proyek->validate()) {

            $main_view = 'proyek/form';
            $form_action = "proyek/edit/$id";

            $this->load->view('template',compact('main_view','form_action','input'));
            return;
        }

        if ($this->proyek->where('id_proyek',$id)->update($input)) {
            $this->session->set_flashdata('success','Data proyek berhasil diupdate');
        }
        redirect('proyek');
    }

    public function delete($id = null)
    {
        $proyek = $this->proyek->where('id_proyek',$id)->get();
        if (!$proyek) {
            $this->session->set_flashdata('warning','Data proyek tidak ada');
            redirect('proyek');
        }

        if ($this->proyek->where('id_proyek',$id)->delete())
        {
            $this->session->set_flashdata('success','Data proyek berhasil dihapus');
        }else {
            $this->session->set_flashdata('error','Data proyek gagal dihapus');
        }
        redirect('proyek');
    }
    ////////////////////////////////////////////////////////////////

}