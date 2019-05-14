<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Booking_paket extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Booking_paket_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $booking_paket = $this->Booking_paket_model->get_all();

        $data = array(
            'booking_paket_data' => $booking_paket
        );

		 $this->template->load('template','booking_paket/booking_paket_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Booking_paket_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_booking_paket' => $row->id_booking_paket,
		'no_booking' => $row->no_booking,
		'kd_paket' => $row->kd_paket,
		'harga' => $row->harga,
	    );
            $this->template->load('template','booking_paket/booking_paket_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('booking_paket'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Save',
            'action' => site_url('booking_paket/create_action'),
	    'id_booking_paket' => set_value('id_booking_paket'),
	    'no_booking' => set_value('no_booking'),
	    'kd_paket' => set_value('kd_paket'),
	    'harga' => set_value('harga'),
	);
        $this->template->load('template','booking_paket/booking_paket_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'no_booking' => $this->input->post('no_booking',TRUE),
		'kd_paket' => $this->input->post('kd_paket',TRUE),
		'harga' => $this->input->post('harga',TRUE),
	    );

            $this->Booking_paket_model->insert('booking_paket',$data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('booking_paket'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Booking_paket_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('booking_paket/update_action'),
		'id_booking_paket' => set_value('id_booking_paket', $row->id_booking_paket),
		'no_booking' => set_value('no_booking', $row->no_booking),
		'kd_paket' => set_value('kd_paket', $row->kd_paket),
		'harga' => set_value('harga', $row->harga),
	    );
            $this->template->load('template','booking_paket/booking_paket_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('booking_paket'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_booking_paket', TRUE));
        } else {
            $data = array(
		'no_booking' => $this->input->post('no_booking',TRUE),
		'kd_paket' => $this->input->post('kd_paket',TRUE),
		'harga' => $this->input->post('harga',TRUE),
	    );

            $this->Booking_paket_model->update('booking_paket','id_booking_paket',$this->input->post('id_booking_paket', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('booking_paket'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Booking_paket_model->get_by_id($id);

        if ($row) {
            $this->Booking_paket_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('booking_paket'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('booking_paket'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('no_booking', 'no booking', 'trim|required');
	$this->form_validation->set_rules('kd_paket', 'kd paket', 'trim|required');
	$this->form_validation->set_rules('harga', 'harga', 'trim|required');

	$this->form_validation->set_rules('id_booking_paket', 'id_booking_paket', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Booking_paket.php */
/* Location: ./application/controllers/Booking_paket.php */
/* Please DO NOT modify this information : */
/* Created 2017-07-19 03:15:27 */
