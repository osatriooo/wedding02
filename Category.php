<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Category_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $category = $this->Category_model->get_all();

        $data = array(
            'category_data' => $category
        );

		 $this->template->load('template','category/category_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Category_model->get_by_id('category','id_category',$id);
        if ($row) {
            $data = array(
		'id_category' => $row->id_category,
		'category' => $row->category,
	    );
            $this->template->load('template','category/category_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('category'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Save',
            'action' => site_url('category/create_action'),
	    'id_category' => set_value('id_category'),
	    'category' => set_value('category'),
	);
        $this->template->load('template','category/category_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'category' => $this->input->post('category',TRUE),
	    );

            $this->Category_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('category'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Category_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('category/update_action'),
		'id_category' => set_value('id_category', $row->id_category),
		'category' => set_value('category', $row->category),
	    );
            $this->template->load('template','category/category_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('category'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_category', TRUE));
        } else {
            $data = array(
		'category' => $this->input->post('category',TRUE),
	    );

            $this->Category_model->update($this->input->post('id_category', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('category'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Category_model->get_by_id($id);

        if ($row) {
            $this->Category_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('category'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('category'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('category', 'category', 'trim|required');

	$this->form_validation->set_rules('id_category', 'id_category', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Category.php */
/* Location: ./application/controllers/Category.php */
/* Please DO NOT modify this information : */
/* Created 2017-07-19 03:15:27 */
