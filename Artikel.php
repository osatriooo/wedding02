<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Artikel extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Artikel_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $artikel = $this->Artikel_model->get_all();

        $data = array(
            'artikel_data' => $artikel
        );

		 $this->template->load('template','artikel/artikel_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Artikel_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_artikel' => $row->id_artikel,
		'tgl_artikel' => $row->tgl_artikel,
		'judul_artikel' => $row->judul_artikel,
		'isi_artikel' => $row->isi_artikel,
		'gambar' => $row->gambar,
	    );
            $this->template->load('template','artikel/artikel_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('artikel'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Save',
            'action' => site_url('artikel/create_action'),
	    'id_artikel' => set_value('id_artikel'),
	    'tgl_artikel' => set_value('tgl_artikel'),
	    'judul_artikel' => set_value('judul_artikel'),
	    'isi_artikel' => set_value('isi_artikel'),
	    'gambar' => set_value('gambar'),
	);
        $this->template->load('template','artikel/artikel_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'tgl_artikel' => $this->input->post('tgl_artikel',TRUE),
		'judul_artikel' => $this->input->post('judul_artikel',TRUE),
		'isi_artikel' => $this->input->post('isi_artikel',TRUE),
		'gambar' => $this->input->post('gambar',TRUE),
	    );

            $this->Artikel_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('artikel'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Artikel_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('artikel/update_action'),
		'id_artikel' => set_value('id_artikel', $row->id_artikel),
		'tgl_artikel' => set_value('tgl_artikel', $row->tgl_artikel),
		'judul_artikel' => set_value('judul_artikel', $row->judul_artikel),
		'isi_artikel' => set_value('isi_artikel', $row->isi_artikel),
		'gambar' => set_value('gambar', $row->gambar),
	    );
            $this->template->load('template','artikel/artikel_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('artikel'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_artikel', TRUE));
        } else {
            $data = array(
		'tgl_artikel' => $this->input->post('tgl_artikel',TRUE),
		'judul_artikel' => $this->input->post('judul_artikel',TRUE),
		'isi_artikel' => $this->input->post('isi_artikel',TRUE),
		'gambar' => $this->input->post('gambar',TRUE),
	    );

            $this->Artikel_model->update('artikel','id_artikel',$this->input->post('id_artikel', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('artikel'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Artikel_model->get_by_id($id);

        if ($row) {
            $this->Artikel_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('artikel'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('artikel'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('tgl_artikel', 'tgl artikel', 'trim|required');
	$this->form_validation->set_rules('judul_artikel', 'judul artikel', 'trim|required');
	$this->form_validation->set_rules('isi_artikel', 'isi artikel', 'trim|required');
	$this->form_validation->set_rules('gambar', 'gambar', 'trim|required');

	$this->form_validation->set_rules('id_artikel', 'id_artikel', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Artikel.php */
/* Location: ./application/controllers/Artikel.php */
/* Please DO NOT modify this information : */
/* Created 2017-07-19 03:15:27 */
