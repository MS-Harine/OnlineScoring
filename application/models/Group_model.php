<?php

class Group_model extends CI_Model {

  public function __constructor() {
    parent::__constructor();
    $this->load->database();
  }

  public function set_group($name, $email) {
    $this->db->insert('group', array(
      'name' => $name
    ));
    $this->join_group($email, $name, True);
  }

  public function get_group($email) {
    $query = $this->db->get_where('profile', array('email' => $email));
    $user = $query->result_array();
    if (empty($user))
      return False;
    $user = $user[0];

    $result = array();
    
    $query = $this->db->get_where('group_manager', array('profile_id' => $user["id"]));
    foreach ($query->result_array() as $row) {
      $q = $this->db->get_where('group', array('id' => $row['group_id']));
      array_push($result, $q->result_array());
    }

    return $result[0];
  }

  public function join_group($email, $name, $maker) {
    $query = $this->db->get_where('profile', array('email' => $email));
    $user = $query->result_array();
    if (empty($user))
      return False;
    $user = $user[0];
    
    $query = $this->db->get_where('group', array('name' => $name));
    $group = $query->result_array();
    if (empty($group))
      return False;
    $group = $group[0];

    return $this->db->insert('group_manager', array(
      'group_id' => $group["id"],
      'profile_id' => $user["id"],
      'permissions' => ($maker) ? 2 : 0
    ));
  }
}
