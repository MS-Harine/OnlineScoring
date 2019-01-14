<?php

class Visual extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function index($type = null, $id = null) {
        $data = array('problems'=>array(), 'problem_result'=>array(), 'users'=>array(), 'user_result'=>array() );
        if ($type == "problem") {
            if ($id == null) {
                $query = $this->db->get("problem");
                $data['problems'] = $query->result_array();
            }
            else {
                $this->db->select("nickname, date_try")
                        ->from('try_log')
                        ->join('profile', "profile.id = try_log.profile_id")
                        ->where("try_log.solve = 1")
                        ->where("try_log.problem_id", $id)
                        ->order_by("date_try")
                        ->group_by('nickname');
                $data['problem_result'] = $this->db->get()->result_array();
            }
        }
        else if ($type == "user") {
            if ($id == null) {
                $this->db->select("id, nickname")
                        ->from("profile")
                        ->order_by("id");
                $data['users'] = $this->db->get()->result_array();
            }
            else {
                $this->db->select("problem.title, try_log.date_try, try_log.solve")
                        ->from("try_log")
                        ->join("problem", "problem.id = try_log.problem_id")
                        ->where("try_log.profile_id", $id);
                $data['user_result'] = $this->db->get()->result_array();
            }
        }
        else {
            echo "FORBIDDEN";
        }
        $this->load->view('visual', $data);
    }
}