<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bookreview extends CI_Model{
	function get_authors(){
		return $this->db->query("SELECT id, name FROM authors ORDER BY name ASC")->result_array();
	}

	function get_books(){
		$latest = $this->db->query("SELECT books.title, books.id AS book_id, reviews.rating, users.alias, users.id AS user_id, reviews.review, reviews.created_at FROM reviews LEFT JOIN books on books.id = reviews.book_id LEFT JOIN users on users.id = reviews.user_id ORDER BY reviews.id DESC LIMIT 3")->result_array();
		$last_three = $this->db->query("SELECT book_id FROM reviews ORDER BY id DESC LIMIT 3")->result_array();
		$values = array();
		foreach($last_three as $element)
			$values[] = intval($element['book_id']);
		$books = $this->db->query("SELECT id, title FROM books WHERE id NOT IN (?,?,?)", $values)->result_array();
		return array('latest'=>$latest, 'books'=>$books);
	}

	function get_user($id){
		return $this->db->query("SELECT first_name, last_name, alias, email FROM users WHERE id=?", array($id))->result_array()[0];
	}

	function get_user_reviews($id){
		return $this->db->query("SELECT books.id as book_id, books.title, count(reviews.id) as total_reviews FROM reviews LEFT JOIN users on users.id = reviews.user_id LEFT JOIN books on books.id = reviews.book_id WHERE users.id=? GROUP BY books.id", array($id))->result_array();
	}

	function get_book($id){
		return $this->db->query("SELECT books.title, books.id, books.rating, authors.name FROM books LEFT JOIN authors ON authors.id = books.author_id WHERE books.id=?", array($id))->result_array()[0];
	}

	function get_book_reviews($id){
		return $this->db->query("SELECT reviews.rating, users.alias, users.id AS user_id, reviews.review, reviews.created_at, reviews.id AS review_id FROM reviews LEFT JOIN users on users.id = reviews.user_id LEFT JOIN books on books.id = reviews.book_id WHERE books.id = ? ORDER BY reviews.id DESC", array($id))->result_array();
	}

	function add($id, $post){
		$errors = array();
		if(empty($post['title']))
			$errors['title'] = 'Please enter the book title.';
		if($post['author'] == 0 && empty($post['new_author']))
			$errors['author'] = "Please enter the book's author.";
		elseif(!empty($post['new_author'])){
			$author = $this->db->query("SELECT * FROM authors WHERE name=?", array($post['new_author']))->result_array();
			if(count($author) > 0)
				$errors['new_author'] = 'This author already exists.';
		}
		if(!isset($errors['title']) && !isset($errors['author'])){
			$book = $this->db->query("SELECT * FROM books WHERE title=? AND author_id=?", array($post['title'], $post['author']))->result_array();
			if(count($book) > 0){
				$errors['title'] = 'This book already exists.';
			}
		}
		if(empty($post['review']))
			$errors['review'] = 'Please enter your review.';
		if(count($errors) > 0)
			return $errors;
		else{
			if($post['author'] > 0 && empty($post['new_author'])){
				$post['book_id'] = $this->add_book($post);
				return $this->add_review($id, $post);
			}
			else{
				$post['author'] = $this->add_author($post);
				$post['book_id'] = $this->add_book($post);
				return $this->add_review($id, $post);
			}
		}
	}

	function add_book($post){
		$this->db->query("INSERT INTO books (title, rating, author_id, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())", array($post['title'], $post['rating'], $post['author']));
		return mysql_insert_id();
	}

	function add_author($post){
		$this->db->query("INSERT INTO authors (name, created_at, updated_at) VALUES (?, NOW(), NOW())", array($post['new_author']));
		return mysql_insert_id();
	}

	function add_review($id, $post){
		return $this->db->query("INSERT INTO reviews (review, rating, user_id, book_id, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())", array($post['review'], $post['rating'], $id, $post['book_id']));
	}

	function create_review($book_id, $user_id, $post){
		if(empty($post['review']))
			return "Please enter a review";
		else{
			$this->db->query("INSERT INTO reviews (review, rating, user_id, book_id, created_at, updated_at) VALUES (?, ?, ?, ?,  NOW(), NOW())", array($post['review'], $post['rating'], $user_id, $book_id));
			$rating = $this->db->query("SELECT rating FROM reviews WHERE book_id=?", array($book_id))->result_array();
			$total = 0;
			foreach($rating as $review){
				$total += intval($review['rating']);
			}
			$composite = round($total/count($rating));
			$this->db->query("UPDATE books SET rating=? WHERE id=?", array($composite, $book_id));
			return true;
		}
	}

	function destroy_review($post){
		$this->db->query("DELETE FROM reviews WHERE id=?", array($post['review_id']));
		$rating = $this->db->query("SELECT rating FROM reviews WHERE book_id=?", array($post['book_id']))->result_array();
		$total = 0;
		foreach($rating as $review){
			$total += intval($review['rating']);
		}
		$composite = round($total/count($rating));
		$this->db->query("UPDATE books SET rating=? WHERE id=?", array($composite, $post['book_id']));
	}
}