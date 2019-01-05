<?php

class Problem extends CI_Controller {
   
    public function __construct() {
        parent::__construct();
        $this->load->model('problem_model');
    }

    public function show($group) {
        $problems = $this->problem_model->get_problems($group);
        
        header('Content-Type: application/json');
        echo json_encode($problems);
    }

    public function make($group_name) {
        if (!$this->session->userdata('is_login'))
            redirect('/auth/login');

        $this->load->model('user_model');
        $this->load->model('group_model');
        $this->load->database();
        $user = $this->user_model->get_user($this->session->userdata('email'));
        $group = $this->group_model->get_group($group_name);
        $result = $this->db->get_where('group_member', array('group_id' => $group['id'], 'profile_id' => $user['id']))->result_array();
        if (empty($result) || $result[0]['status'] != 2) {
            echo '<script>alert("Forbidden");window.location.href="/";</script>';
            exit;
        }

        if ($this->input->post('title') == NULL || $this->input->post('content') == NULL || $this->input->post('level') == NULL) {
            echo '<script>alert("Forbidden");window.location.href="/";</script>';
            exit;
        }

        if (!isset($_FILES['inputfiles']) || !isset($_FILES['outputfiles'])) { 
            echo '<script>alert("Please upload files");</script>';
            exit;
        }

        if (count($_FILES['inputfiles']['name']) != count($_FILES['outputfiles']['name'])) {
            echo '<script>alert("Number of input files and number of output files are different.");window.location.href="/";</script>';
            exit;
        }
        
        // Save Content
        $data['title'] = $this->input->post('title');
        $data['content'] = $this->input->post('content');
        $data['level'] = $this->input->post('level');
        
        if ($this->problem_model->set_problem($this->session->userdata('email'), $group_name, $data) == false) {
            echo '<script>alert("Failed to insert problem into db");window.location.href="/";</script>';
            exit;
        }
        $problem_id = $this->db->insert_id();

        // Upload input files
        $this->load->library('upload');

        $count = count($_FILES['inputfiles']['name']);
        $filename = array();
        for ($i = 1; $i <= $count; $i++)
            array_push($filename, "input".$i.".txt");

        $path = './uploads/'.$problem_id.'/input/';
        if (!file_exists($path))
            mkdir($path, 0777, true);

        $config['upload_path'] = $path;
        $config['allowed_types'] = 'txt';
        $config['file_name'] = $filename;
        $this->upload->initialize($config);
        if (!$this->upload->do_multi_upload('inputfiles')) {
            echo '<script>alert("Error while uploading input files!\nError: ".$this->upload->display_errors());window.location.href="/";</script>';
            exit;
        }
        
        // Upload output files
        $count = count($_FILES['outputfiles']['name']);
        $filename = array();
        for ($i = 1; $i <= $count; $i++)
            array_push($filename, "output".$i.".txt");

        $path = './uploads/'.$problem_id.'/output/';
        if (!file_exists($path))
            mkdir($path, 0777, true);

        $config['upload_path'] = $path;
        $config['file_name'] = $filename;
        $this->upload->initialize($config);
        if (!$this->upload->do_multi_upload('outputfiles')) {
            echo '<script>alert("Error while uploading output files!\nError: ".$this->upload->display_errors());window.location.href="/";</script>';
            exit;
        }
        
        redirect('/');
    }
}
