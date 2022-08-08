<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Map extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Map_Model');
        $this->load->library('form_validation');
        $this->load->library('pdf');
    }

    public function index()
    {
        $data['location'] = $this->Map_Model->get_all_location();

        $this->load->view('header', $data);
        $this->load->view('navbar');
        $this->load->view('sidebar');
        $this->load->view('map', $data);
        $this->load->view('footer');
    }

    public function add()
    {
        $this->form_validation->set_rules('location', 'Location', 'required|trim');
        $this->form_validation->set_rules('latitude', 'Latitude', 'required|trim');
        $this->form_validation->set_rules('longitude', 'Longitude', 'required|trim');

        $check = $this->input->post('is_active');
        if ($check !== 'Active') {
            $check = 'Not Active';
        }

        if ($this->form_validation->run() == true) {
            $location = array(
                'location' => $this->input->post('location'),
                'latitude' => $this->input->post('latitude'),
                'longitude' => $this->input->post('longitude'),
                'is_active' => $check
            );
            $this->db->insert('location', $location);
            $this->session->set_flashdata('notification_berhasil', 'Location berhasil ditambahkan!');
            redirect('Map');
        } else {
            $this->session->set_flashdata('notification_gagal', 'Penulis gagal ditambahkan');
            redirect('Map');
        }
    }

    function edit()
    {
        $id = $this->input->post('id');

        $this->form_validation->set_rules('location', 'Location', 'required|trim');
        $this->form_validation->set_rules('latitude', 'Latitude', 'required|trim');
        $this->form_validation->set_rules('longitude', 'Longitude', 'required|trim');

        $check = $this->input->post('is_active');
        if ($check !== 'Active') {
            $check = 'Not Active';
        }

        $data_update = array(
            'location' => $this->input->post('location'),
            'latitude' => $this->input->post('latitude'),
            'longitude' => $this->input->post('longitude'),
            'is_active' => $check
        );
        $this->db->update('location', $data_update, array('id' => $id));
        $this->session->set_flashdata('notification_berhasil', 'Location berhasil diubah');
        redirect('Map');
    }

    public function delete()
    {
        $id = $_POST['id'];

        $this->Map_Model->delete_location($id);
    }

    public function pdf()
    {
        // Instanciation of inherited class
        $pdf = new FPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times', '', 12);

        // header
        // Logo
        $pdf->Image(base_url('asset/image/kb_insurance_logo.png'), 10, 6, 60);
        // Arial bold 15
        $pdf->SetFont('Arial', 'B', 15);
        // Line break
        $pdf->Ln(20);
        // Move to the right
        $pdf->Cell(80);
        // Title
        $pdf->Cell(30, 10, 'Data Lokasi', 0, 0, 'C');
        // Line break
        $pdf->Ln(20);

        // column header
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 6, 'No', 1, 0, 'C');
        $pdf->Cell(65, 6, 'Nama Lokasi', 1, 0, 'C');
        $pdf->Cell(45, 6, 'Latitude', 1, 0, 'C');
        $pdf->Cell(45, 6, 'Longitude', 1, 0, 'C');
        $pdf->Cell(25, 6, 'Status', 1, 1, 'C');

        // column body 
        $pdf->SetFont('Arial', '', 10);
        $location = $this->Map_Model->get_all_location();
        $no = 0;
        foreach ($location as $item) {
            $no++;
            $pdf->Cell(10, 6, $no, 1, 0, 'C');
            $pdf->Cell(65, 6, $item['location'], 1, 0);
            $pdf->Cell(45, 6, $item['latitude'], 1, 0, 'L');
            $pdf->Cell(45, 6, $item['longitude'], 1, 0, 'L');
            $pdf->Cell(25, 6, $item['is_active'], 1, 1, 'C');
        }

        // footer
        // Position at 1.5 cm from bottom
        $pdf->SetY(0);
        // Arial italic 8
        $pdf->SetFont('Arial', 'I', 8);
        // Page number
        $pdf->Cell(0, 10, 'Page ' . $pdf->PageNo() . '/{nb}', 0, 0, 'R');

        $pdf->Output();
    }

    public function pdf_not_active()
    {
        // Instanciation of inherited class
        $pdf = new FPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times', '', 12);

        // header
        // Logo
        $pdf->Image(base_url('asset/image/kb_insurance_logo.png'), 10, 6, 60);
        // Arial bold 15
        $pdf->SetFont('Arial', 'B', 15);
        // Line break
        $pdf->Ln(20);
        // Move to the right
        $pdf->Cell(80);
        // Title
        $pdf->Cell(30, 10, 'Data Lokasi Aktif', 0, 0, 'C');
        // Line break
        $pdf->Ln(20);

        // column header
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 6, 'No', 1, 0, 'C');
        $pdf->Cell(65, 6, 'Nama Lokasi', 1, 0, 'C');
        $pdf->Cell(45, 6, 'Latitude', 1, 0, 'C');
        $pdf->Cell(45, 6, 'Longitude', 1, 0, 'C');
        $pdf->Cell(25, 6, 'Status', 1, 1, 'C');

        // column body 
        $pdf->SetFont('Arial', '', 10);
        $location = $this->Map_Model->get_all_location();
        $no = 0;
        foreach ($location as $item) {
            if ($item['is_active'] === "Not Active") {
                $no++;
                $pdf->Cell(10, 6, $no, 1, 0, 'C');
                $pdf->Cell(65, 6, $item['location'], 1, 0);
                $pdf->Cell(45, 6, $item['latitude'], 1, 0, 'L');
                $pdf->Cell(45, 6, $item['longitude'], 1, 0, 'L');
                $pdf->Cell(25, 6, $item['is_active'], 1, 1, 'C');
            }
        }

        // footer
        // Position at 1.5 cm from bottom
        $pdf->SetY(0);
        // Arial italic 8
        $pdf->SetFont('Arial', 'I', 8);
        // Page number
        $pdf->Cell(0, 10, 'Page ' . $pdf->PageNo() . '/{nb}', 0, 0, 'R');

        $pdf->Output();
    }
    public function pdf_active()
    {
        // Instanciation of inherited class
        $pdf = new FPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times', '', 12);

        // header
        // Logo
        $pdf->Image(base_url('asset/image/kb_insurance_logo.png'), 10, 6, 60);
        // Arial bold 15
        $pdf->SetFont('Arial', 'B', 15);
        // Line break
        $pdf->Ln(20);
        // Move to the right
        $pdf->Cell(80);
        // Title
        $pdf->Cell(30, 10, 'Data Lokasi Aktif', 0, 0, 'C');
        // Line break
        $pdf->Ln(20);

        // column header
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 6, 'No', 1, 0, 'C');
        $pdf->Cell(65, 6, 'Nama Lokasi', 1, 0, 'C');
        $pdf->Cell(45, 6, 'Latitude', 1, 0, 'C');
        $pdf->Cell(45, 6, 'Longitude', 1, 0, 'C');
        $pdf->Cell(25, 6, 'Status', 1, 1, 'C');

        // column body 
        $pdf->SetFont('Arial', '', 10);
        $location = $this->Map_Model->get_all_location();
        $no = 0;
        foreach ($location as $item) {
            if ($item['is_active'] === "Active") {
                $no++;
                $pdf->Cell(10, 6, $no, 1, 0, 'C');
                $pdf->Cell(65, 6, $item['location'], 1, 0);
                $pdf->Cell(45, 6, $item['latitude'], 1, 0, 'L');
                $pdf->Cell(45, 6, $item['longitude'], 1, 0, 'L');
                $pdf->Cell(25, 6, $item['is_active'], 1, 1, 'C');
            }
        }

        // footer
        // Position at 1.5 cm from bottom
        $pdf->SetY(0);
        // Arial italic 8
        $pdf->SetFont('Arial', 'I', 8);
        // Page number
        $pdf->Cell(0, 10, 'Page ' . $pdf->PageNo() . '/{nb}', 0, 0, 'R');

        $pdf->Output();
    }
}
