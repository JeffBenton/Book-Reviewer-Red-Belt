<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// $this->output->enable_profiler();
	}

	public function index(){
		$this->load->view('login');
	}

	public function login(){
		$this->load->model('validate');
		$errors = $this->validate->login($this->input->post());
		if(gettype($errors) == 'string'){
			$this->session->set_flashdata('login_errors', $errors);
			redirect('/');
		}
		elseif($errors == TRUE){
			$user = $errors;
			$user['logged_in'] = TRUE;
			$this->session->set_userdata('current_user', $user);
			redirect('home');
		}
		else{
			$this->session->set_flashdata('failure', 'Login failed, please try again later');
			redirect('/');
		}
	}

	public function register(){
		$this->load->model('validate');
		$errors = $this->validate->register($this->input->post());
		if(is_array($errors)){
			$this->session->set_flashdata('registration_errors', $errors);
			redirect('/');
		}
		elseif(gettype($errors) == 'integer'){
			$post = $this->input->post();
			$current_user = array(
				'id' => $errors,
				'first_name' => ucfirst($post['first_name']),
				'last_name' => ucfirst($post['last_name']),
				'alias' => ucfirst($post['alias']),
				'email' => $post['email'],
				'logged_in' => TRUE);
			$this->session->set_userdata('current_user', $current_user);
			redirect('home');
		}
		else{
			$this->session->set_flashdata('failure', 'Registration failed, please try again later');
			redirect('/');
		}
	}

	public function logoff(){
		$current_user = $this->session->userdata('current_user');
		$current_user['logged_in'] = FALSE;
		$this->session->sess_destroy();
		redirect('/');
	}
}

//end of main controller