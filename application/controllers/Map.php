<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Map extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Map_Model');
        $this->load->library('form_validation');
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
}
