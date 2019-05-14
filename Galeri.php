<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Galeri extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Galeri_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $galeri = $this->Galeri_model->get_all();

        $data = array(
            'galeri_data' => $galeri
        );

		 $this->template->load('template','galeri/galeri_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Galeri_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_galery' => $row->id_galery,
		'id_album' => $row->id_album,
		'judul' => $row->judul,
		'gambar' => $row->gambar,
		'keterangan_gambar' => $row->keterangan_gambar,
	    );
            $this->template->load('template','galeri/galeri_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('galeri'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Save',
            'action' => site_url('galeri/create_action'),
	    'id_galery' => set_value('id_galery'),
	    'id_album' => set_value('id_album'),
	    'judul' => set_value('judul'),
	    'gambar' => set_value('gambar'),
	    'keterangan_gambar' => set_value('keterangan_gambar'),
	);
        $this->template->load('template','galeri/galeri_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'id_album' => $this->input->post('id_album',TRUE),
		'judul' => $this->input->post('judul',TRUE),
		'gambar' => $this->input->post('gambar',TRUE),
		'keterangan_gambar' => $this->input->post('keterangan_gambar',TRUE),
	    );

            $this->Galeri_model->insert('galeri',$data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('galeri'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Galeri_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('galeri/update_action'),
		'id_galery' => set_value('id_galery', $row->id_galery),
		'id_album' => set_value('id_album', $row->id_album),
		'judul' => set_value('judul', $row->judul),
		'gambar' => set_value('gambar', $row->gambar),
		'keterangan_gambar' => set_value('keterangan_gambar', $row->keterangan_gambar),
	    );
            $this->template->load('template','galeri/galeri_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('galeri'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_galery', TRUE));
        } else {
            $data = array(
		'id_album' => $this->input->post('id_album',TRUE),
		'judul' => $this->input->post('judul',TRUE),
		'gambar' => $this->input->post('gambar',TRUE),
		'keterangan_gambar' => $this->input->post('keterangan_gambar',TRUE),
	    );

            $this->Galeri_model->update('galeri','id_galery',$this->input->post('id_galery', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('galeri'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Galeri_model->get_by_id($id);

        if ($row) {
            $this->Galeri_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('galeri'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('galeri'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_album', 'id album', 'trim|required');
	$this->form_validation->set_rules('judul', 'judul', 'trim|required');
	$this->form_validation->set_rules('gambar', 'gambar', 'trim|required');
	$this->form_validation->set_rules('keterangan_gambar', 'keterangan gambar', 'trim|required');

	$this->form_validation->set_rules('id_galery', 'id_galery', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Galeri.php */
/* Location: ./application/controllers/Galeri.php */
/* Please DO NOT modify this information : */
/* Created 2017-07-19 03:15:27 */
