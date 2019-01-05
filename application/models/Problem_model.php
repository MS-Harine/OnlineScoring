<?php

class Problem_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('group_model');
        $this->load->model('user_model');
    }

    public function set_problem($email, $name, $data) {
        $user = $this->user_model->get_user($email);
        $group = $this->group_model->get_group($name);
        if ($group == NULL or $user == NULL)
            return false;

        return $this->db->insert('group_member', array(
            'group_id' => $group["id"],
            'profile_id' => $user["id"],
            'title' => $data['title'],
            'content' => $data['content'],
            'level' => $data['level']
        ));
    }

    public function get_problems($name) {
        $group = $this->group_model->get_group($name);
        if ($group == NULL)
            return NULL;

        $query = $this->db->get_where('problem', array('group_id' => $group['id']));
        $problems = $query->result_array();
        return $problems;
    }

    public function get_problem($id) {
        $query = $this->db->get_where('problem', array('id' => $id));
        return $query->result_array()[0];
    }

}