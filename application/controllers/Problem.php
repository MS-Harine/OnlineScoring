<?php

class Problem extends CI_Controller {
   
    public function __construct() {
        parent::__construct();
        $this->load->model('problem_model');
        $this->load->model('user_model');
    }

    public function show($group) {
        $problems = $this->problem_model->get_problems($group);
        
        header('Content-Type: application/json');
        echo json_encode($problems);
    }

    public function make($group_name) {
        if (!$this->session->userdata('is_login'))
            redirect('/auth/login');

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

    public function enrollment($p_id) {
        if (!$this->session->userdata('is_login'))
            redirect('/auth/login');

        $user = $this->user_model->get_user($this->session->userdata('email'));

        $path = "./uploads/".$p_id."/try/".$user['id'];
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'c';

        if (!file_exists($path))
            mkdir($path, 0777, true);

        $config['file_name'] = "try".sprintf("%03d", count(scandir($path)) - 2).".c";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload("assignment"))
            echo $this->upload->display_errors();
    }

    public function try($p_id) {
        if (!$this->session->userdata('is_login'))
            redirect('/auth/login');
        
        $is_compile = $this->input->get('compile');
        $user = $this->user_model->get_user($this->session->userdata('email'));
        $max_count = count(scandir("./uploads/".$p_id."/input")) - 2;
        
        $path = "./uploads/".$p_id."/try/".$user['id']."/";
        $this->load->database();

        if ($is_compile == true) {
            $file = $path."try".sprintf("%03d", count(scandir($path)) - 3).".c";
            $file = str_replace("/", "\\", $file);

            $result_msg = "";
            $result = 0;
            exec("echo %PATH% && gcc ".$file." -o ".str_replace('/', '\\', $path)."a.out 2>&1", $result_msg, $result);

            if ($result != 0) {
                echo 0;
                $this->db->insert('try_log', array(
                    'problem_id' => $p_id,
                    'profile_id' => $user['id']
                ));
            }
            else
                echo 1;
        }
        else {
            $file = $path."a.out";
            $file = str_replace("/", "\\", $file);
            
            $result = array();
            for ($i = 1; $i <= $max_count; $i++) {
                $result_msg = "";
                exec($file." < ./uploads/".$p_id."/input/input".$i.".txt 2>&1", $result_msg);
                $label = file_get_contents("./uploads/".$p_id."/output/output".$i.".txt");

                if (strcmp(preg_replace('/\r\n|\r|\n/','',implode('', $result_msg)), preg_replace('/\r\n|\r|\n/','',$label)) == 0) 
                    $result[(string)$i] = 1;
                else
                    $result[(string)$i] = 0;
            }
            
            header('Content-Type: application/json');
            echo json_encode($result);
            
            if (!in_array(0, $result)) {
                $this->db->insert('try_log', array(
                    'problem_id' => $p_id,
                    'profile_id' => $user['id'],
                    'solve' => 1
                ));
            }
            else {
                $this->db->insert('try_log', array(
                    'problem_id' => $p_id,
                    'profile_id' => $user['id'],
                    'solve' => 0
                ));
            }
        }
    }
}
