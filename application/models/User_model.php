<?php

class User_model extends CI_Model {

  public function __construct() {
    parent::__construct();
    $this->load->database();
  }

  public function authentication($email, $pw) {
    $user = $this->get_user($email);
    if ($user == NULL)
      return false;

    $password = hash("sha256", $pw);
    if ($password != $user['password'])
      return false;

    return true;
  }

  public function get_user($email) {
    $query = $this->db->get_where('profile', array('email' => $email));
    $query = $query->result_array();
    if (empty($query))
      return NULL;

    return $query[0];
  }

  public function get_user_by_nickname($nickname) {
    $query = $this->db->get_where('profile', array('nickname' => $nickname));
    if ($query->num_rows() != 1)
      return NULL;

    return $query->result_array()[0];
  }

  public function set_user($data) {
    $password = hash("sha256", $data['password']);
    return $this->db->insert('profile', array(
      'email' => $data['email'],
      'password' => $password,
      'nickname' => $data['nickname']
    ));
  }
}
