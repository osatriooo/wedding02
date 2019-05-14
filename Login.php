<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller {
function __construct()
    {
        parent::__construct();
        $this->load->model('Crud_model');
        $this->load->library('form_validation');
    }
	public function index()
	{			
		if($this->session->userdata('logged_insurat')==true){
			redirect('dashboard','location');exit;
		}
		
		$this->load->view('login');
	}
	
	public function changes()
	{			
		 $data = array(
		 'action' => site_url('login/changes_action'),
		 );
		        $this->template->load('template','changes_password',$data);

	}
	public function changes_action(){
		$passwordword0 = $this->input->post('passwordword0');
		$passwordword1 = $this->input->post('passwordword1');
		$passwordword2 = $this->input->post('passwordword2');
			 
			  $query_data=$this->db->query("select * from admin where username='" . $_SESSION["ses_username"] . "' and password='".$passwordword0."'");
		if (count($query_data->result_array())==0){
			echo "<script>alert('passwordword Tidak Ditemukan!');</script>";
				die("<script>location.href='".base_url()."/login/changes';</script>");	
	  }else{
if($passwordword1!=$passwordword2){
			echo "<script>alert('passwordword Harus Sama!');</script>";
				die("<script>location.href='".base_url()."/login/changes';</script>");	

}else{
	 $query_data=$this->db->query("UPDATE admin set password='".$passwordword2."' where username='" . $_SESSION["ses_username"] . "' ");
	 echo "<script>alert('passwordword Berhasil Dirubah, Silahkan Login dengan passwordword  Baru!');</script>";
				die("<script>location.href='".base_url()."/login/mlogout';</script>");	
}
	  }
	}
	public function mlogout()
	{	
	
				$sess_data['ses_id']=NULL;
				$sess_data['ses_username'] = NULL;
				$sess_data['logged_inltsa'] =false;
			
		$this->session->unset_userdata($sess_data);
		session_destroy();
		redirect('/','location');exit;
	}
	
	public function mlogin()
	{		
		$username = $this->input->post('username',TRUE);
			$password = $this->input->post('password',TRUE);
			//$password=enc_password($passwordword);
		
			$query_data=$this->db->query("select * from admin where  username='" . $username . "' and password='".$password."'");
		if (count($query_data->result_array())>0){
			foreach($query_data->result() as $items){
				
				$nama=$items->nama;
				
				$sess_data['ses_nama']=$nama;
								$sess_data['logged_insurat'] =true;
				
				$this->session->set_userdata($sess_data);
				$this->session->set_userdata($sess_data);
				
			}
		//	if($username=="admin"){
							            redirect(site_url('Dashboard'));

				die('OK');

			}else{
				echo 'Username atau passwordword tidak Sesuai';
			}
				
	}	
}

/* End of file dashboard.php */
/* Location: ./sikdaapplication/controllers/login.php */