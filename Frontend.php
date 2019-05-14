<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Frontend extends CI_Controller
{
    function __construct()
    {
		
        parent::__construct();
        $this->load->model('Layanan_model');
		 $this->load->model('Booking_model');
		$this->load->model('Member_model');
		 $this->load->model('Konfirmasi_model');
		 $this->load->library('form_validation');

     }
     
     public function index()
     {
     	 $this->load->view('frontend/template/header');
     	 $this->load->view('frontend/catalog');
     	 $this->load->view('frontend/template/footer');
     } 
	 public function termandcondition(){
		 $this->load->view('frontend/template/header');
     	 $this->load->view('frontend/termandcondition');
     	 $this->load->view('frontend/template/footer');
	 }
	 	 public function topvendor(){
		 $this->load->view('frontend/template/header');
     	 $this->load->view('frontend/topvendor');
     	 $this->load->view('frontend/template/footer');
	 }
	 
	  public function register()
     {
		  $data = array(
            'button' => 'Save',
            'action' => site_url('Frontend/register_action'),
	    'id_member' => set_value('id_member'),
	    'nama_member' => set_value('nama_member'),
	    'alamat' => set_value('alamat'),
	    'telepon' => set_value('telepon'),
	    'email' => set_value('email'),
	    'password' => set_value('password'),
	);
     	 $this->load->view('frontend/template/header');
     	 $this->load->view('frontend/register',$data);
     	 $this->load->view('frontend/template/footer');
     }   
	  public function register_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->register();
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
           redirect('Frontend/login');
        }
    }
 public function _rules() 
    {
	$this->form_validation->set_rules('nama_member', 'nama member', 'trim|required');
	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
	$this->form_validation->set_rules('telepon', 'telepon', 'trim|required');
	$this->form_validation->set_rules('email', 'email', 'trim|required');
	$this->form_validation->set_rules('password', 'password', 'trim|required');

	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

     public function login()
     {
     	 $data = array(
            'button' => 'Login',
            'action' => site_url('Frontend/login_action'),
	    'email' => set_value('email'),
	    'password' => set_value('password'),
	);
     	 $this->load->view('frontend/template/header');
     	 $this->load->view('frontend/login',$data);
     	 $this->load->view('frontend/template/footer');
     }   
	 
	   public function login_action() 
    {
        $this->_rules_login();

        if ($this->form_validation->run() == FALSE) {
            $this->login();
        } else {
			$username=$this->input->post('email',TRUE);
			$password=$this->input->post('password',TRUE);
			$query_data=$this->db->query("select * from member where  email='" . $username . "' and password='".$password."'");
		if (count($query_data->result_array())>0){
			foreach($query_data->result() as $items){
				
				$nama=$items->nama_member;
				$id=$items->id_member;
				
				$sess_data['ses_nama']=$nama;
				$sess_data['ses_id']=$id;
				$sess_data['logged'] =true;
				
				$this->session->set_userdata($sess_data);
				
			} redirect('Frontend');
            
		}else{

            $this->session->set_flashdata('message', 'Username atau password salah');
           redirect('Frontend/login');
        }
		}
    }
	 public function _rules_login() 
    {

	$this->form_validation->set_rules('email', 'email', 'trim|required');
	$this->form_validation->set_rules('password', 'password', 'trim|required');

	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
	   public function category()
     {
     	 $this->load->view('frontend/template/header');
     	 $this->load->view('frontend/category');
     	 $this->load->view('frontend/template/footer');
     }   
	public function logout()
	{	
	$sess_data['ses_nama']=NULL;
				$sess_data['ses_id']=NULL;
				$sess_data['logged'] =false;
			
		$this->session->unset_userdata($sess_data);
		session_destroy();
		redirect('/','location');exit;
	}
 	public function layanan()
     {
        $layanan = $this->Layanan_model->get_all();

        $data = array(
            'layanan_data' => $layanan
        );
     	 $this->load->view('frontend/template/header');
     	 $this->load->view('frontend/layanan',$data);
     	 $this->load->view('frontend/template/footer');
     }   
	 public function detail_kategori($id)
     {
        $layanan = $this->db->get_where("layanan",array('id_kategori'=>$id))->result();

        $data = array(
            'layanan_data' => $layanan
        );
     	 $this->load->view('frontend/template/header');
     	 $this->load->view('frontend/layanan',$data);
     	 $this->load->view('frontend/template/footer');
     }   
	 public function layanan_detail($id)
     {
       $layanan = $this->db->get_where("layanan",array('id_layanan'=>$id))->row();

        $data = array(
            'layanan' => $layanan
        );
     	 $this->load->view('frontend/template/header');
     	 $this->load->view('frontend/layanan_detail',$data);
     	 $this->load->view('frontend/template/footer');
     }   
	public function konfirmasi()
     {
		  $data = array(
            'button' => 'Save',
            'action' => site_url('frontend/konfirmasi_action'),
	    'kd_konfirmasi' => set_value('kd_konfirmasi'),
	    'no_booking' => set_value('no_booking'),
	    'pembayaran' => set_value('pembayaran'),
	    'jumlah_pembayaran' => set_value('jumlah_pembayaran'),
	    'bukti_pembayaran' => set_value('bukti_pembayaran'),
	    'bank_asal' => set_value('bank_asal'),
	    'an_asal' => set_value('an_asal'),
	    'bank_tujuan' => set_value('bank_tujuan'),
	    'an_tujuan' => set_value('an_tujuan'),
	    'tgl_transfer' => set_value('tgl_transfer'),
	);
     	 $this->load->view('frontend/template/header');
     	 $this->load->view('frontend/konfirmasi',$data);
     	 $this->load->view('frontend/template/footer');
     }   
 public function konfirmasi_action() 
    {
        $this->_ruleskonfirmasi();

        if ($this->form_validation->run() == FALSE) {
            $this->konfirmasi();
        } else {
			
			$id=$this->input->post('no_booking',TRUE);
			
			 $row = $this->db->get_where("booking",array('no_booking'=>$id))->row();
			 if($row){
				 
	if ($_FILES["gambar"]["name"] != "") {
		@copy($_FILES["gambar"]["tmp_name"],"uploads/konfirmasi/".$_FILES["gambar"]["name"]);
		$gambar=$_FILES["gambar"]["name"];
		} 
	else {$gambar=$gambar0;}
	if(strlen($gambar)<1){$gambar=$gambar0;}
            $data = array(
		'no_booking' => $this->input->post('no_booking',TRUE),
		'pembayaran' => $this->input->post('pembayaran',TRUE),
		'jumlah_pembayaran' => $this->input->post('jumlah_pembayaran',TRUE),
		'bukti_pembayaran' => $gambar,
		'bank_asal' => $this->input->post('bank_asal',TRUE),
		'an_asal' => $this->input->post('an_asal',TRUE),
		'bank_tujuan' => $this->input->post('bank_tujuan',TRUE),
		'an_tujuan' => $this->input->post('an_tujuan',TRUE),
		'tgl_transfer' => $this->input->post('tgl_transfer',TRUE),
	    );

            $this->Konfirmasi_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect('Frontend/');
			 }else{
				 echo "<script>alert('No Booking Tidak Terdaftar');document.location.href='konfirmasi';</script>";
			 }
        }
    }
	
	 public function _ruleskonfirmasi() 
    {
	$this->form_validation->set_rules('no_booking', 'no booking', 'trim|required');
	
	$this->form_validation->set_rules('jumlah_pembayaran', 'jumlah pembayaran', 'trim|required');
	
	$this->form_validation->set_rules('bank_asal', 'bank asal', 'trim|required');
	$this->form_validation->set_rules('an_asal', 'an asal', 'trim|required');
	$this->form_validation->set_rules('bank_tujuan', 'bank tujuan', 'trim|required');
	$this->form_validation->set_rules('an_tujuan', 'an tujuan', 'trim|required');
	$this->form_validation->set_rules('tgl_transfer', 'tgl transfer', 'trim|required');

	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
     public function contact()
     {
     	 $this->load->view('frontend/template/header');
     	 $this->load->view('frontend/contact');
     	 $this->load->view('frontend/template/footer');
     }
      public function artikel()
     {
         $this->load->view('frontend/template/header');
         $this->load->view('frontend/artikel');
         $this->load->view('frontend/template/footer');
     }
	  public function price()
     {
		 if($_POST){
			 $harga1=$this->input->post('harga1');
			 $harga2=$this->input->post('harga2');
			 
		 }else{
			 $harga1='';
			 $harga2='';
		 }
		 
		 $data["harga1"]=$harga1;
		  $data["harga2"]=$harga2;
         $this->load->view('frontend/template/header');
         $this->load->view('frontend/price',$data);
         $this->load->view('frontend/template/footer');
     }
	 
	 	  public function rating()
     {
		 if($_POST){
			 $rating=$this->input->post('rating');
		 }else{
			 $rating='';
		 }
		 $data["rating"]=$rating;
         $this->load->view('frontend/template/header');
         $this->load->view('frontend/rating',$data);
         $this->load->view('frontend/template/footer');
     }
	 
	    public function history()
     {
		 $id=$this->session->userdata('ses_id');
		 $booking = $this->db->get_where("booking",array('id_member'=>$id))->result();

        $data = array(
            'booking_data' => $booking
        );
         $this->load->view('frontend/template/header');
         $this->load->view('frontend/history',$data);
         $this->load->view('frontend/template/footer');
     }
	    public function history_detail($id)
     {
		$row = $this->Booking_model->get_by_id($id);
            $data = array(
		'no_booking' => $row->no_booking,
		
		'tgl_booking' => $row->tgl_booking,
		'tema_kegiatan' => $row->tema_kegiatan,
		'rincian_kegiatan' => $row->rincian_kegiatan,
		'lokasi_kegiatan' => $row->lokasi_kegiatan,
		'tgl_kegiatan' => $row->tgl_kegiatan,
		'jam_mulai' => $row->jam_mulai,
		'jam_selesai' => $row->jam_selesai,
		'status_booking' => $row->status_booking,
	    ); //$id=$this->session->userdata('ses_id');
		 $booking = $this->db->get_where("booking_item",array('no_booking'=>$id))->result();

		$data["booking_item_data"]=$booking;
         $this->load->view('frontend/template/header');
         $this->load->view('frontend/history_detail',$data);
         $this->load->view('frontend/template/footer');
     }
	 function add_rating(){
		 $query =$this->db->query("UPDATE layanan SET rating='" . $_POST["rating"] . "' WHERE id_layanan='" . $_POST["id"] . "'");

	 }
	 
	 function search_keyword() 
    { 
        $keyword = $this->input->post('keyword'); 
        $data['layanan_data'] = $this->Layanan_model->searchLayanan($keyword); 
        $this->load->view('frontend/template/header');
        $this->load->view('frontend/layanan',$data);
       $this->load->view('frontend/template/footer');
    }
     }  

     

     

