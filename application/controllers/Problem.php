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
        
        // Save Content
        $data['title'] = $this->input->post('title');
        $data['content'] = $this->input->post('content');
        $data['level'] = $this->input->post('level');
        
        if ($this->problem_model->set_problem($this->session->userdata('email'), $group_name, $data) == false) {
            alert("Failed to insert problem into db");
            redirect('/');
        }
        $problem_id = $this->db->insert_id();

        // Upload input files
        $this->load->library('upload');
        
        if (count($_FILES['inputfiles']['name']) != count($_FILES['outputfiles']['name'])) {
            alert("Number of input files and number of output files are different.");
            redirect('/');
        }

        $count = count($_FILES['inputfiles']['name']);
        $filename = array();
        for ($i = 1; i <= $count; $i++)
            array_push($filename, "input".$i.".txt");

        $path = './uploads/'.$problem_id.'/input/';
        if (!file_exists($path))
            mkdir($path, 0777, true);

        $config['upload_path'] = $path;
        $config['allowed_types'] = 'txt';
        $config['file_name'] = $filename;
        $this->upload->initialize($config);
        if (!$this->upload->do_multi_upload('inputfiles')) {
            alert("Error while uploading input files!\nError: ".$this->upload->display_errors());
            redirect('/');
        }
        
        // Upload output files
        $count = count($_FILES['outputfiles']['name']);
        $filename = array();
        for ($i = 1; i <= $count; $i++)
            array_push($filename, "output".$i.".txt");

        $path = './uploads/'.$problem_id.'/output/';
        if (!file_exists($path))
            mkdir($path, 0777, true);

        $config['upload_path'] = $path;
        $config['file_name'] = $filename;
        $this->upload->initialize($config);
        if (!$this->upload->do_multi_upload('outputfiles')) {
            alert("Error while uploading output files!\nError: ".$this->upload->display_errors());
            redirect('/');
        }
        
        alert('Success');
        redirect('/');
    }
}
