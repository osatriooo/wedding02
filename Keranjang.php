<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Keranjang extends CI_Controller
{
    function __construct()
    {
		
        parent::__construct();
		$this->load->model('Booking_model');
		$this->load->model('Booking_item_model');
         $this->load->library('form_validation');

     }
     
	 function index(){
		if($_POST){
			$data=array(
				'rowid'=>$this->input->post('rowid'),
				'qty'=>0
			);
			$this->cart->update($data);
			redirect('keranjang');
		}
		$this->load->view('frontend/template/header');
     	 $this->load->view('frontend/keranjang');
     	 $this->load->view('frontend/template/footer');
	
	}
	
    function addcart($id){
		$row = $this->db->get_where("layanan",array('id_layanan'=>$id))->row();
		$data=array(
			'id'=>$id,
			'qty'=>1,
			'price'=>$row->harga,
			'name'=>$row->nama_layanan,
			'options'=>array('image'=>$row->gambar)
		);
		
		$this->cart->insert($data);
		redirect('keranjang');
	}
	
	function checkout(){
		 $data = array(
            'button' => 'Save',
            'action' => site_url('keranjang/checkout_action'),
	   'no_booking' => getNota('booking', 'no_booking', 'B'),
	    'tgl_booking' => set_value('tgl_booking'),
	    'tema_kegiatan' => set_value('tema_kegiatan'),
	    'rincian_kegiatan' => set_value('rincian_kegiatan'),
	    'lokasi_kegiatan' => set_value('lokasi_kegiatan'),
	    'tgl_kegiatan' => set_value('tgl_kegiatan'),
	    'jam_mulai' => set_value('jam_mulai'),
	    'jam_selesai' => set_value('jam_selesai'),
	    'status_booking' => set_value('status_booking'),
	);
		$this->load->view('frontend/template/header');
     	 $this->load->view('frontend/booking_form',$data);
     	 $this->load->view('frontend/template/footer');
	}
	
	  public function checkout_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->checkout();
        } else {
						date_default_timezone_set('Asia/Jakarta');
$no_booking=getNota('booking', 'no_booking', 'B');

            $data = array(
		'no_booking' => $no_booking,
		'id_member' =>$this->session->userdata('ses_id'),
		'tgl_booking' => date("Y-m-d"),
		'tema_kegiatan' => $this->input->post('tema_kegiatan',TRUE),
		'rincian_kegiatan' => $this->input->post('rincian_kegiatan',TRUE),
		'lokasi_kegiatan' => $this->input->post('lokasi_kegiatan',TRUE),
		'tgl_kegiatan' => $this->input->post('tgl_kegiatan',TRUE),
		'jam_mulai' => $this->input->post('jam_mulai',TRUE),
		'jam_selesai' => $this->input->post('jam_selesai',TRUE),
		'status_booking' =>'booking',
	    );

		if(!$this->input->post())
			redirect('keranjang');
		if($this->cart->total()==0){
			redirect('keranjang');
		}
	            $this->Booking_model->insert($data);

		
		foreach($this->cart->contents() as $key):
			$data = array(
				'no_booking'=>$no_booking,
				'id_layanan'=>$key['id'],
				'harga_layanan'=>$key['price']
			);
			
			 $this->Booking_item_model->insert($data);
			$x=array(
				'rowid'=>$key['rowid'],
				'qty'=>0
			);
			//print_r($x);die();
			$this->cart->update($x);
		endforeach;
		
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('keranjang/selesai'));
        }
		
		
    }

 public function _rules() 
    {
	$this->form_validation->set_rules('tema_kegiatan', 'tema kegiatan', 'trim|required');
	$this->form_validation->set_rules('rincian_kegiatan', 'rincian kegiatan', 'trim|required');
	$this->form_validation->set_rules('lokasi_kegiatan', 'lokasi kegiatan', 'trim|required');
	$this->form_validation->set_rules('tgl_kegiatan', 'tgl kegiatan', 'trim|required');
	$this->form_validation->set_rules('jam_mulai', 'jam mulai', 'trim|required');
	$this->form_validation->set_rules('jam_selesai', 'jam selesai', 'trim|required');
	

	$this->form_validation->set_rules('no_booking', 'no_booking', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
	
	function selesai(){
		$this->load->view('frontend/template/header');
     	 $this->load->view('frontend/selesai_booking');
     	 $this->load->view('frontend/template/footer');
	}
}  

     

     

