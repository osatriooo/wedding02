<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Booking_item extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Booking_item_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $booking_item = $this->Booking_item_model->get_all('booking_item');

        $data = array(
            'booking_item_data' => $booking_item
        );

		 $this->template->load('template','booking_item/booking_item_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Booking_item_model->get_by_id($id);
        if ($row) {
            $data = array(
		'no_booking' => $row->no_booking,
		'id_layanan' => $row->id_layanan,
		'harga_layanan' => $row->harga_layanan,
	    );
            $this->template->load('template','booking_item/booking_item_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('booking_item'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Save',
            'action' => site_url('booking_item/create_action'),
	    'no_booking' => set_value('no_booking'),
	    'id_layanan' => set_value('id_layanan'),
	    'harga_layanan' => set_value('harga_layanan'),
	);
        $this->template->load('template','booking_item/booking_item_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'no_booking' => $this->input->post('no_booking',TRUE),
		'id_layanan' => $this->input->post('id_layanan',TRUE),
		'harga_layanan' => $this->input->post('harga_layanan',TRUE),
	    );

            $this->Booking_item_model->insert('booking_item',$data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('booking_item'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Booking_item_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('booking_item/update_action'),
		'no_booking' => set_value('no_booking', $row->no_booking),
		'id_layanan' => set_value('id_layanan', $row->id_layanan),
		'harga_layanan' => set_value('harga_layanan', $row->harga_layanan),
	    );
            $this->template->load('template','booking_item/booking_item_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('booking_item'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('', TRUE));
        } else {
            $data = array(
		'no_booking' => $this->input->post('no_booking',TRUE),
		'id_layanan' => $this->input->post('id_layanan',TRUE),
		'harga_layanan' => $this->input->post('harga_layanan',TRUE),
	    );

            $this->Booking_item_model->update('booking_item','',$this->input->post('', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('booking_item'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Booking_item_model->get_by_id($id);

        if ($row) {
            $this->Booking_item_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('booking_item'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('booking_item'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('no_booking', 'no booking', 'trim|required');
	$this->form_validation->set_rules('id_layanan', 'id layanan', 'trim|required');
	$this->form_validation->set_rules('harga_layanan', 'harga layanan', 'trim|required');

	$this->form_validation->set_rules('', '', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Booking_item.php */
/* Location: ./application/controllers/Booking_item.php */
/* Please DO NOT modify this information : */
/* Created 2017-07-19 03:15:27 */
