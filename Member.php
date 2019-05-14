<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Member extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Member_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $member = $this->Member_model->get_all();

        $data = array(
            'member_data' => $member
        );

		 $this->template->load('template','member/member_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Member_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_member' => $row->id_member,
		'nama_member' => $row->nama_member,
		'alamat' => $row->alamat,
		'telepon' => $row->telepon,
		'email' => $row->email,
		'password' => $row->password,
	    );
            $this->template->load('template','member/member_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('member'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Save',
            'action' => site_url('member/create_action'),
	    'id_member' => set_value('id_member'),
	    'nama_member' => set_value('nama_member'),
	    'alamat' => set_value('alamat'),
	    'telepon' => set_value('telepon'),
	    'email' => set_value('email'),
	    'password' => set_value('password'),
	);
        $this->template->load('template','member/member_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_member' => $this->input->post('nama_member',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
		'telepon' => $this->input->post('telepon',TRUE),
		'email' => $this->input->post('email',TRUE),
		'password' => $this->input->post('password',TRUE),
	    );

            $this->Member_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('member'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Member_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('member/update_action'),
		'id_member' => set_value('id_member', $row->id_member),
		'nama_member' => set_value('nama_member', $row->nama_member),
		'alamat' => set_value('alamat', $row->alamat),
		'telepon' => set_value('telepon', $row->telepon),
		'email' => set_value('email', $row->email),
		'password' => set_value('password', $row->password),
	    );
            $this->template->load('template','member/member_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('member'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_member', TRUE));
        } else {
            $data = array(
		'nama_member' => $this->input->post('nama_member',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
		'telepon' => $this->input->post('telepon',TRUE),
		'email' => $this->input->post('email',TRUE),
		'password' => $this->input->post('password',TRUE),
	    );

            $this->Member_model->update('member','id_member',$this->input->post('id_member', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('member'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Member_model->get_by_id($id);

        if ($row) {
            $this->Member_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('member'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('member'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_member', 'nama member', 'trim|required');
	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
	$this->form_validation->set_rules('telepon', 'telepon', 'trim|required');
	$this->form_validation->set_rules('email', 'email', 'trim|required');
	$this->form_validation->set_rules('password', 'password', 'trim|required');

	$this->form_validation->set_rules('id_member', 'id_member', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Member.php */
/* Location: ./application/controllers/Member.php */
/* Please DO NOT modify this information : */
/* Created 2017-07-19 03:15:28 */
