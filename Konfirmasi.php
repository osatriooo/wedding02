<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Konfirmasi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Konfirmasi_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $konfirmasi = $this->Konfirmasi_model->get_all();

        $data = array(
            'konfirmasi_data' => $konfirmasi
        );

		 $this->template->load('template','konfirmasi/konfirmasi_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Konfirmasi_model->get_by_id($id);
        if ($row) {
            $data = array(
		'kd_konfirmasi' => $row->kd_konfirmasi,
		'no_booking' => $row->no_booking,
		'pembayaran' => $row->pembayaran,
		'jumlah_pembayaran' => $row->jumlah_pembayaran,
		'bukti_pembayaran' => $row->bukti_pembayaran,
		'bank_asal' => $row->bank_asal,
		'an_asal' => $row->an_asal,
		'bank_tujuan' => $row->bank_tujuan,
		'an_tujuan' => $row->an_tujuan,
		'tgl_transfer' => $row->tgl_transfer,
	    );
            $this->template->load('template','konfirmasi/konfirmasi_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('konfirmasi'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Save',
            'action' => site_url('konfirmasi/create_action'),
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
        $this->template->load('template','konfirmasi/konfirmasi_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'no_booking' => $this->input->post('no_booking',TRUE),
		'pembayaran' => $this->input->post('pembayaran',TRUE),
		'jumlah_pembayaran' => $this->input->post('jumlah_pembayaran',TRUE),
		'bukti_pembayaran' => $this->input->post('bukti_pembayaran',TRUE),
		'bank_asal' => $this->input->post('bank_asal',TRUE),
		'an_asal' => $this->input->post('an_asal',TRUE),
		'bank_tujuan' => $this->input->post('bank_tujuan',TRUE),
		'an_tujuan' => $this->input->post('an_tujuan',TRUE),
		'tgl_transfer' => $this->input->post('tgl_transfer',TRUE),
	    );

            $this->Konfirmasi_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('konfirmasi'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Konfirmasi_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('konfirmasi/update_action'),
		'kd_konfirmasi' => set_value('kd_konfirmasi', $row->kd_konfirmasi),
		'no_booking' => set_value('no_booking', $row->no_booking),
		'pembayaran' => set_value('pembayaran', $row->pembayaran),
		'jumlah_pembayaran' => set_value('jumlah_pembayaran', $row->jumlah_pembayaran),
		'bukti_pembayaran' => set_value('bukti_pembayaran', $row->bukti_pembayaran),
		'bank_asal' => set_value('bank_asal', $row->bank_asal),
		'an_asal' => set_value('an_asal', $row->an_asal),
		'bank_tujuan' => set_value('bank_tujuan', $row->bank_tujuan),
		'an_tujuan' => set_value('an_tujuan', $row->an_tujuan),
		'tgl_transfer' => set_value('tgl_transfer', $row->tgl_transfer),
	    );
            $this->template->load('template','konfirmasi/konfirmasi_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('konfirmasi'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('kd_konfirmasi', TRUE));
        } else {
            $data = array(
		'no_booking' => $this->input->post('no_booking',TRUE),
		'pembayaran' => $this->input->post('pembayaran',TRUE),
		'jumlah_pembayaran' => $this->input->post('jumlah_pembayaran',TRUE),
		'bukti_pembayaran' => $this->input->post('bukti_pembayaran',TRUE),
		'bank_asal' => $this->input->post('bank_asal',TRUE),
		'an_asal' => $this->input->post('an_asal',TRUE),
		'bank_tujuan' => $this->input->post('bank_tujuan',TRUE),
		'an_tujuan' => $this->input->post('an_tujuan',TRUE),
		'tgl_transfer' => $this->input->post('tgl_transfer',TRUE),
	    );

            $this->Konfirmasi_model->update($this->input->post('kd_konfirmasi', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('konfirmasi'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Konfirmasi_model->get_by_id($id);

        if ($row) {
            $this->Konfirmasi_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('konfirmasi'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('konfirmasi'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('no_booking', 'no booking', 'trim|required');
	$this->form_validation->set_rules('pembayaran', 'pembayaran', 'trim|required');
	$this->form_validation->set_rules('jumlah_pembayaran', 'jumlah pembayaran', 'trim|required');
	$this->form_validation->set_rules('bukti_pembayaran', 'bukti pembayaran', 'trim|required');
	$this->form_validation->set_rules('bank_asal', 'bank asal', 'trim|required');
	$this->form_validation->set_rules('an_asal', 'an asal', 'trim|required');
	$this->form_validation->set_rules('bank_tujuan', 'bank tujuan', 'trim|required');
	$this->form_validation->set_rules('an_tujuan', 'an tujuan', 'trim|required');
	$this->form_validation->set_rules('tgl_transfer', 'tgl transfer', 'trim|required');

	$this->form_validation->set_rules('kd_konfirmasi', 'kd_konfirmasi', 'trim');
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
						<td>".$p->nama_konfirmasi."</td>
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

/* End of file Konfirmasi.php */
/* Location: ./application/controllers/Konfirmasi.php */
/* Please DO NOT modify this information : */
/* Created 2017-07-19 03:15:28 */
