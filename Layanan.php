<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Layanan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Layanan_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $layanan = $this->Layanan_model->get_all();

        $data = array(
            'layanan_data' => $layanan
        );

		 $this->template->load('template','layanan/layanan_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Layanan_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_layanan' => $row->id_layanan,
		'id_kategori' => $row->id_kategori,
		'nama_layanan' => $row->nama_layanan,
		'harga' => $row->harga,
		'keterangan' => $row->keterangan,
		'gambar' => $row->gambar,
	    );
            $this->template->load('template','layanan/layanan_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('layanan'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Save',
            'action' => site_url('layanan/create_action'),
	    'id_layanan' => set_value('id_layanan'),
	    'id_kategori' => set_value('id_kategori'),
	    'nama_layanan' => set_value('nama_layanan'),
	    'harga' => set_value('harga'),
	    'keterangan' => set_value('keterangan'),
	    'gambar' => set_value('gambar'),
	);
        $this->template->load('template','layanan/layanan_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
			
 $gambar0=strip_tags($_POST["gambar0"]);
	if ($_FILES["gambar"]["name"] != "") {
		@copy($_FILES["gambar"]["tmp_name"],"uploads/".$_FILES["gambar"]["name"]);
		$gambar=$_FILES["gambar"]["name"];
		} 
	else {$gambar=$gambar0;}
	if(strlen($gambar)<1){$gambar=$gambar0;}
            $data = array(
		'id_kategori' => $this->input->post('id_kategori',TRUE),
		'nama_layanan' => $this->input->post('nama_layanan',TRUE),
		'harga' => $this->input->post('harga',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		'gambar' => $gambar,
	    );

            $this->Layanan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('layanan'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Layanan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('layanan/update_action'),
		'id_layanan' => set_value('id_layanan', $row->id_layanan),
		'id_kategori' => set_value('id_kategori', $row->id_kategori),
		'nama_layanan' => set_value('nama_layanan', $row->nama_layanan),
		'harga' => set_value('harga', $row->harga),
		'keterangan' => set_value('keterangan', $row->keterangan),
		'gambar' => set_value('gambar', $row->gambar),
	    );
            $this->template->load('template','layanan/layanan_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('layanan'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_layanan', TRUE));
        } else {
			$gambar0=strip_tags($_POST["gambar0"]);
	if ($_FILES["gambar"]["name"] != "") {
		@copy($_FILES["gambar"]["tmp_name"],"uploads/".$_FILES["gambar"]["name"]);
		$gambar=$_FILES["gambar"]["name"];
		} 
	else {$gambar=$gambar0;}
	if(strlen($gambar)<1){$gambar=$gambar0;}
            $data = array(
		'id_kategori' => $this->input->post('id_kategori',TRUE),
		'nama_layanan' => $this->input->post('nama_layanan',TRUE),
		'harga' => $this->input->post('harga',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		'gambar' => $gambar,
	    );

            $this->Layanan_model->update($this->input->post('id_layanan', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('layanan'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Layanan_model->get_by_id($id);

        if ($row) {
            $this->Layanan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('layanan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('layanan'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_kategori', 'id kategori', 'trim|required');
	$this->form_validation->set_rules('nama_layanan', 'nama layanan', 'trim|required');
	$this->form_validation->set_rules('harga', 'harga', 'trim|required');
	///$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
	//$this->form_validation->set_rules('gambar', 'gambar', 'trim|required');

	$this->form_validation->set_rules('id_layanan', 'id_layanan', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
/* LAPORAN */

	public function excel()
	{
		
			$filename = 'Laporan_Layanan';
			header("Content-type: application/x-msdownload");
			header("Content-Disposition: attachment; filename=".$filename.".xls");

			echo "
				<h4>Laporan Layanan</h4>
				<table border='1' width='100%'>
					<thead>
						<tr>
							<th>No</th>
							<th>Kategori</th>
							<th>Nama Layanan</th>
						</tr>
					</thead>
					<tbody>
			";

			$no = 1;
			$layanan = $this->Layanan_model->get_all();
			foreach($layanan as $p)
			{
				echo "
					<tr>
						<td>".$no."</td>
						<td>".$p->id_kategori."</td>
						<td>".$p->nama_layanan."</td>
					</tr>
				";

				
				$no++;
			}

			echo "
				
			</tbody>
			</table>
			";
	
	}

	public function pdf()
	{
		$this->load->library('cfpdf');
					
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',10);

		$pdf->SetFont('Arial','',10);
		$pdf->Cell(0, 8, "Laporan Layanan", 0, 1, 'L'); 

		$pdf->Cell(15, 7, 'No', 1, 0, 'L'); 
		$pdf->Cell(85, 7, 'Kategori', 1, 0, 'L');
		$pdf->Cell(85, 7, 'Nama Layanan', 1, 0, 'L'); 
		$pdf->Ln();

		
		$no = 1;
		$layanan = $this->Layanan_model->get_all();
		foreach($layanan as $p)
		{
			$pdf->Cell(15, 7, $no, 1, 0, 'L'); 
			$pdf->Cell(85, 7, $p->id_kategori, 1, 0, 'L');
			$pdf->Cell(85, 7, $p->nama_layanan, 1, 0, 'L');
			$pdf->Ln();

			
			$no++;
		}

		
		$pdf->Ln();

		$pdf->Output();
	}
	
	//END LAPORAN
	
}

/* End of file Layanan.php */
/* Location: ./application/controllers/Layanan.php */
/* Please DO NOT modify this information : */
/* Created 2017-07-19 03:15:28 */
