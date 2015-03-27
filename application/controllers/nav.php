<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nav extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('bookreview');
		// $this->output->enable_profiler();
	}

	public function books(){
		$books = $this->bookreview->get_books();
		$this->load->view('books', $books);
	}

	public function add(){
		$authors = $this->bookreview->get_authors();
		$this->load->view('add', array('authors' => $authors));
	}

	public function create_review($book_id){
		$current_user = $this->session->userdata('current_user');
		$errors = $this->bookreview->create_review($book_id, $current_user['id'], $this->input->post());
		if(gettype($errors) == 'string'){
			$this->session->set_flashdata('errors', $errors);
			redirect('/nav/view/' . $book_id);
		}
		else{
			redirect('/nav/view/' . $book_id);
		}
	}

	public function destroy_review(){
		$this->bookreview->destroy_review($this->input->post());
		redirect('/nav/view/' . $this->input->post('book_id'));
	}

	public function create(){
		$current_user = $this->session->userdata('current_user');
		$errors = $this->bookreview->add($current_user['id'], $this->input->post());
		if(is_array($errors)){
			$this->session->set_flashdata('errors', $errors);
			redirect('/nav/add');
		}
		elseif($errors == TRUE)
			redirect('home');
		else
			echo 'not added';
	}

	public function view($book_id){
		$book = $this->bookreview->get_book($book_id);
		$reviews = $this->bookreview->get_book_reviews($book_id);
		$this->load->view('view', array('book'=>$book, 'reviews'=>$reviews));
	}

	public function users($id){
		$user = $this->bookreview->get_user($id);
		$reviews = $this->bookreview->get_user_reviews($id);
		$total = 0;
		foreach($reviews as $review){
			$total += $review['total_reviews'];
		}
		$this->load->view('users', array('user'=>$user, 'reviews'=>$reviews, 'total'=> $total));
	}
}