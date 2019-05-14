<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Album extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Album_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $album = $this->Album_model->get_all();

        $data = array(
            'album_data' => $album
        );

		 $this->template->load('template','album/album_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Album_model->get_by_id($id);
        if ($row) {
            $data = array(
		'Id_album' => $row->Id_album,
		'nama_album' => $row->nama_album,
	    );
            $this->template->load('template','album/album_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('album'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Save',
            'action' => site_url('album/create_action'),
	    'Id_album' => set_value('Id_album'),
	    'nama_album' => set_value('nama_album'),
	);
        $this->template->load('template','album/album_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_album' => $this->input->post('nama_album',TRUE),
	    );

            $this->Album_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('album'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Album_model->get_by_id('album','Id_album',$id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('album/update_action'),
		'Id_album' => set_value('Id_album', $row->Id_album),
		'nama_album' => set_value('nama_album', $row->nama_album),
	    );
            $this->template->load('template','album/album_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('album'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('Id_album', TRUE));
        } else {
            $data = array(
		'nama_album' => $this->input->post('nama_album',TRUE),
	    );

            $this->Album_model->update('album','Id_album',$this->input->post('Id_album', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('album'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Album_model->get_by_id($id);

        if ($row) {
            $this->Album_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('album'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('album'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_album', 'nama album', 'trim|required');

	$this->form_validation->set_rules('Id_album', 'Id_album', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Album.php */
/* Location: ./application/controllers/Album.php */
/* Please DO NOT modify this information : */
/* Created 2017-07-19 03:15:27 */
