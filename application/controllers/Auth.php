<?php

class Auth extends CI_Controller {

  public function __constructor() {
    parent::__constructor();
    $this->load->database();
  }

  public function login() {
    $this->load->model('user_model');
    $this->load->library('form_validation');
    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');

    if ($this->form_validation->run() === FALSE) {
      $this->session->set_flashdata('errorMessage', "Please input valid data");
      $this->load->view('authPage');
    }
    else {
      if (!$this->user_model->authentication($this->input->post('email'), $this->input->post('password'))) {
        $this->session->set_flashdata('errorMessage', "Fail to login");
        $this->load->view('authPage');
      }
      else {
        $user = $this->user_model->get_user($this->input->post('email'));
        $data = array(
          'email' => $user->email,
          'nickname' => $user->nickname,
          'is_login' => true
        );
        $this->session->set_userdata($data);
        redirect('/');
      }
    }
  }

  public function logout() {
    $this->session->sess_destroy();
    redirect('/');
  }

  public function signup() {
    $this->load->model('user_model');
    $this->load->library('form_validation');
    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');
    $this->form_validation->set_rules('nickname', 'Nickname', 'required');

    if ($this->form_validation->run() === FALSE) {
      $this->session->set_flashdata('errorMessage', "Please input valid data");
      $this->load->view('authPage', array('signup' => true));
    }
    else {
      if ($this->user_model->get_user($this->input->post('email'))) {
        $this->session->set_flashdata('errorMessage', "Duplicated email.");
        $this->load->view('authPage', array('signup' => true));
      }
      else if ($this->user_model->get_user_by_nickname($this->input->post('nickname'))) {
        $this->session->set_flashdata('errorMessage', "Duplicated nickname.");
        $this->load->view('authPage', array('signup' => true));
      }
      else {
        $data = array(
          'email' => $this->input->post('email'),
          'nickname' => $this->input->post('nickname'),
          'password' => $this->input->post('password')
        );
        $this->user_model->set_user($data);
        
        $data = array(
          'email' => $this->input->post('email'),
          'nickname' => $this->input->post('nickname'),
          'is_login' => true
        );
        $this->session->set_userdata($data);
        redirect('/');
      }
    }
  }
}
