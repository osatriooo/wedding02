<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paket_item extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Paket_item_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $paket_item = $this->Paket_item_model->get_all();

        $data = array(
            'paket_item_data' => $paket_item
        );

		 $this->template->load('template','paket_item/paket_item_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Paket_item_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_paket_layanan' => $row->id_paket_layanan,
		'kd_paket' => $row->kd_paket,
		'id_layanan' => $row->id_layanan,
	    );
            $this->template->load('template','paket_item/paket_item_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('paket_item'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Save',
            'action' => site_url('paket_item/create_action'),
	    'id_paket_layanan' => set_value('id_paket_layanan'),
	    'kd_paket' => set_value('kd_paket'),
	    'id_layanan' => set_value('id_layanan'),
	);
        $this->template->load('template','paket_item/paket_item_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'kd_paket' => $this->input->post('kd_paket',TRUE),
		'id_layanan' => $this->input->post('id_layanan',TRUE),
	    );

            $this->Paket_item_model->insert('paket_item',$data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('paket_item'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Paket_item_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('paket_item/update_action'),
		'id_paket_layanan' => set_value('id_paket_layanan', $row->id_paket_layanan),
		'kd_paket' => set_value('kd_paket', $row->kd_paket),
		'id_layanan' => set_value('id_layanan', $row->id_layanan),
	    );
            $this->template->load('template','paket_item/paket_item_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('paket_item'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_paket_layanan', TRUE));
        } else {
            $data = array(
		'kd_paket' => $this->input->post('kd_paket',TRUE),
		'id_layanan' => $this->input->post('id_layanan',TRUE),
	    );

            $this->Paket_item_model->update('paket_item','id_paket_layanan',$this->input->post('id_paket_layanan', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('paket_item'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Paket_item_model->get_by_id($id);

        if ($row) {
            $this->Paket_item_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('paket_item'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('paket_item'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kd_paket', 'kd paket', 'trim|required');
	$this->form_validation->set_rules('id_layanan', 'id layanan', 'trim|required');

	$this->form_validation->set_rules('id_paket_layanan', 'id_paket_layanan', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Paket_item.php */
/* Location: ./application/controllers/Paket_item.php */
/* Please DO NOT modify this information : */
/* Created 2017-07-19 03:15:28 */
