<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function __construct()
    {
		
        parent::__construct();
		 must_login();
		         $this->load->model('Crud_model');

		
		 
    }

    public function index()
    {
		
          $this->template->load('template','welcome_message');
		
    }

   

}

/* End of file Inbox.php */
/* Location: ./application/controllers/Inbox.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-03-07 21:43:47 */
/* http://harviacode.com */