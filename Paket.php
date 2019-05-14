<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paket extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Paket_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $paket = $this->Paket_model->get_all();

        $data = array(
            'paket_data' => $paket
        );

		 $this->template->load('template','paket/paket_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Paket_model->get_by_id($id);
        if ($row) {
            $data = array(
		'kd_paket' => $row->kd_paket,
		'nama_paket' => $row->nama_paket,
		'harga' => $row->harga,
		'keterangan' => $row->keterangan,
	    );
            $this->template->load('template','paket/paket_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('paket'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Save',
            'action' => site_url('paket/create_action'),
	    'kd_paket' => set_value('kd_paket'),
	    'nama_paket' => set_value('nama_paket'),
	    'harga' => set_value('harga'),
	    'keterangan' => set_value('keterangan'),
	);
        $this->template->load('template','paket/paket_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_paket' => $this->input->post('nama_paket',TRUE),
		'harga' => $this->input->post('harga',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
	    );

            $this->Paket_model->insert('paket',$data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('paket'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Paket_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('paket/update_action'),
		'kd_paket' => set_value('kd_paket', $row->kd_paket),
		'nama_paket' => set_value('nama_paket', $row->nama_paket),
		'harga' => set_value('harga', $row->harga),
		'keterangan' => set_value('keterangan', $row->keterangan),
	    );
            $this->template->load('template','paket/paket_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('paket'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('kd_paket', TRUE));
        } else {
            $data = array(
		'nama_paket' => $this->input->post('nama_paket',TRUE),
		'harga' => $this->input->post('harga',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
	    );

            $this->Paket_model->update('paket','kd_paket',$this->input->post('kd_paket', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('paket'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Paket_model->get_by_id($id);

        if ($row) {
            $this->Paket_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('paket'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('paket'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_paket', 'nama paket', 'trim|required');
	$this->form_validation->set_rules('harga', 'harga', 'trim|required');
	$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');

	$this->form_validation->set_rules('kd_paket', 'kd_paket', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
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
}

/* End of file Paket.php */
/* Location: ./application/controllers/Paket.php */
/* Please DO NOT modify this information : */
/* Created 2017-07-19 03:15:28 */
