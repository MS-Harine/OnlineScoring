<?php

class Group extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('group_model');
        $this->load->library('form_validation');
    }

    public function index() {
        if (!$this->session->userdata('is_login'))
            redirect('/auth/login');

        $groups = $this->group_model->get_group_by_user($this->session->userdata('email'));
        
        header('Content-Type: application/json');
        echo json_encode($groups);
    }

    public function new() {
        if (!$this->session->userdata('is_login'))
            redirect('/auth/login');
        
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
            exit;
        
        $user = NULL;
        if ($this->session->userdata('is_login')) {
            $this->load->model('user_model');
            $user = $this->user_model->get_user($this->session->userdata('email'));
        }
            
        $this->load->database();

        // TODO: asdasdasdasd
        $query = "";
        if ($user == NULL) {
            $query = $this->db->select('name, status')
                        ->from('group')
                        ->join('group_member', 'group.id = group_member.group_id')
                        ->like('name', $this->input->get('word'))
                        ->get();
        }
        else {
            $query = $this->db->select('name, status')
                        ->from('group')
                        ->join('group_member', 'group.id = group_member.group_id')
                        ->group_start()
                            ->like('name', $this->input->get('word'))
                            ->where('group_member.profile_id != ', $user['id'])
                        ->group_end()
                        ->group_by('name')
                        ->get();
        }

        header('Content-Type: application/json');
        echo json_encode($query->result_array());
    }

    public function join() {
        if (!$this->session->userdata('is_login'))
            redirect('/auth/login');
        
        $group = $this->input->get('name');
        $this->group_model->join_group($this->session->userdata('email'), $group);
        redirect('/');
    }
}