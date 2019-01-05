<?php

class Group extends CI_Controller {
    
    public function __constructor() {
        parent::__constructor();
        $this->load->database();
    }

    public function index() {
        if (!$this->session->userdata('is_login'))
            redirect('/auth/login');

        $this->load->model('group_model');
        $groups = $this->group_model->get_group($this->session->userdata('email'));
        
        header('Content-Type: application/json');
        echo json_encode($groups);
    }

    public function new() {
        if (!$this->session->userdata('is_login'))
            redirect('/auth/login');
        
        $this->load->model('group_model');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required');
        if ($this->form_validation->run()) {
            $this->group_model->set_group($this->input->post('name'), $this->session->userdata('email'));
            redirect('/');
        }
        else {
            $this->load->view('newGroup');
        }
    }

    public function find() {
        if (empty($this->input->get('word')))
            redirect('/');
            
        $this->db->like('name', $this->input->get('word'));
        $result = $this->db->get('group');
        header('Content-Type: application/json');
        echo json_encode($result->result_array());
    }
}