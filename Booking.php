<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Booking extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Booking_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $booking = $this->Booking_model->get_all();

        $data = array(
            'booking_data' => $booking
        );

		 $this->template->load('template','booking/booking_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Booking_model->get_by_id($id);
        if ($row) {
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
	    );
            $this->template->load('template','booking/booking_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('booking'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Save',
            'action' => site_url('booking/create_action'),
	    'no_booking' => set_value('no_booking'),
	    'id_booking' => set_value('id_booking'),
	    'tgl_booking' => set_value('tgl_booking'),
	    'tema_kegiatan' => set_value('tema_kegiatan'),
	    'rincian_kegiatan' => set_value('rincian_kegiatan'),
	    'lokasi_kegiatan' => set_value('lokasi_kegiatan'),
	    'tgl_kegiatan' => set_value('tgl_kegiatan'),
	    'jam_mulai' => set_value('jam_mulai'),
	    'jam_selesai' => set_value('jam_selesai'),
	    'status_booking' => set_value('status_booking'),
	);
        $this->template->load('template','booking/booking_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'id_booking' => $this->input->post('id_booking',TRUE),
		'tgl_booking' => $this->input->post('tgl_booking',TRUE),
		'tema_kegiatan' => $this->input->post('tema_kegiatan',TRUE),
		'rincian_kegiatan' => $this->input->post('rincian_kegiatan',TRUE),
		'lokasi_kegiatan' => $this->input->post('lokasi_kegiatan',TRUE),
		'tgl_kegiatan' => $this->input->post('tgl_kegiatan',TRUE),
		'jam_mulai' => $this->input->post('jam_mulai',TRUE),
		'jam_selesai' => $this->input->post('jam_selesai',TRUE),
		'status_booking' => $this->input->post('status_booking',TRUE),
	    );

            $this->Booking_model->insert('booking',$data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('booking'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Booking_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('booking/update_action'),
		'no_booking' => set_value('no_booking', $row->no_booking),
		'id_booking' => set_value('id_booking', $row->id_booking),
		'tgl_booking' => set_value('tgl_booking', $row->tgl_booking),
		'tema_kegiatan' => set_value('tema_kegiatan', $row->tema_kegiatan),
		'rincian_kegiatan' => set_value('rincian_kegiatan', $row->rincian_kegiatan),
		'lokasi_kegiatan' => set_value('lokasi_kegiatan', $row->lokasi_kegiatan),
		'tgl_kegiatan' => set_value('tgl_kegiatan', $row->tgl_kegiatan),
		'jam_mulai' => set_value('jam_mulai', $row->jam_mulai),
		'jam_selesai' => set_value('jam_selesai', $row->jam_selesai),
		'status_booking' => set_value('status_booking', $row->status_booking),
	    );
            $this->template->load('template','booking/booking_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('booking'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('no_booking', TRUE));
        } else {
            $data = array(
		/*
		'tgl_booking' => $this->input->post('tgl_booking',TRUE),
		'tema_kegiatan' => $this->input->post('tema_kegiatan',TRUE),
		'rincian_kegiatan' => $this->input->post('rincian_kegiatan',TRUE),
		'lokasi_kegiatan' => $this->input->post('lokasi_kegiatan',TRUE),
		'tgl_kegiatan' => $this->input->post('tgl_kegiatan',TRUE),
		'jam_mulai' => $this->input->post('jam_mulai',TRUE),
		'jam_selesai' => $this->input->post('jam_selesai',TRUE),
		*/
		'status_booking' => $this->input->post('status_booking',TRUE),
	    );

            $this->Booking_model->update($this->input->post('no_booking', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('booking'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Booking_model->get_by_id($id);

        if ($row) {
            $this->Booking_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('booking'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('booking'));
        }
    }

    public function _rules() 
    {
	/*$this->form_validation->set_rules('id_booking', 'id booking', 'trim|required');
	$this->form_validation->set_rules('tgl_booking', 'tgl booking', 'trim|required');
	$this->form_validation->set_rules('tema_kegiatan', 'tema kegiatan', 'trim|required');
	$this->form_validation->set_rules('rincian_kegiatan', 'rincian kegiatan', 'trim|required');
	$this->form_validation->set_rules('lokasi_kegiatan', 'lokasi kegiatan', 'trim|required');
	$this->form_validation->set_rules('tgl_kegiatan', 'tgl kegiatan', 'trim|required');
	$this->form_validation->set_rules('jam_mulai', 'jam mulai', 'trim|required');
	$this->form_validation->set_rules('jam_selesai', 'jam selesai', 'trim|required');
	*/
	$this->form_validation->set_rules('status_booking', 'status booking', 'trim|required');

	$this->form_validation->set_rules('no_booking', 'no_booking', 'trim');
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

/* End of file Booking.php */
/* Location: ./application/controllers/Booking.php */
/* Please DO NOT modify this information : */
/* Created 2017-07-19 03:15:27 */
