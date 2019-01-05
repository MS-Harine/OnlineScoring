<?php

class Group_model extends CI_Model {

  public function __construct() {
    parent::__construct();
    $this->load->database();
    $this->load->model('user_model');
  }

  public function set_group($name, $email) {
    $this->db->insert('group', array(
      'name' => $name
    ));
    $this->join_group($email, $name, True);
  }

  public function get_group_by_user($email) {
    $user = $this->user_model->get_user($email);
    if ($user == NULL)
      return NULL;

    $this->db->select('name, status');
    $this->db->from('group');
    $this->db->join('group_member', 'group.id = group_member.group_id');
    $this->db->where('group_member.profile_id = '.$user['id']);
    $query = $this->db->get();

    return $query->result_array();
  }

  public function get_group($name) {
    $query = $this->db->get_where('group', array('name' => $name));
    $group = $query->result_array();
    if (empty($group))
      return NULL;
    $group = $group[0];

    return $group;
  }

  public function join_group($email, $name, $maker = False) {
    $user = $this->user_model->get_user($email);
    $group = $this->get_group($name);
    if ($user == NULL or $group == NULL)
      return false;

    return $this->db->insert('group_member', array(
      'group_id' => $group["id"],
      'profile_id' => $user["id"],
      'status' => ($maker) ? 2 : 0
    ));
  }
}
