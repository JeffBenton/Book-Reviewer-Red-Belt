<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Validate extends CI_Model{
	function register($post){
		$errors = array();
		if(empty($post['first_name']))
			$errors['first_name'] = 'Please enter your first name.';
		if(empty($post['last_name']))
			$errors['last_name'] = 'Please enter your last name.';
		if(empty($post['alias']))
			$errors['alias'] = 'Please enter an alias.';
		if(!filter_var($post['email'], FILTER_VALIDATE_EMAIL))
			$errors['email'] = 'Please enter a valid email address.';
		else{
			$email = $this->db->query("SELECT * FROM users WHERE email=?", array(strtolower($post['email'])))->row();
			if(gettype($email) == 'object')
				$errors['email'] = 'An account with that email already exists';
		}
		if(empty($post['password']) || strlen($post['password']) < 8)
			$errors['password'] = 'Please enter a valid password.';
		if($post['confirm_password'] != $post['password'])
			$errors['confirm_password'] = 'Your passwords do not match';
		if(count($errors) > 0)
			return $errors;
		else{
			$queryStr = "INSERT INTO users (first_name, last_name, alias, email, password, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
			$queryArr = array(ucfirst($post['first_name']), ucfirst($post['last_name']), ucfirst($post['alias']), $post['email'], md5($post['password']));
			$this->db->query($queryStr, $queryArr);
			return mysql_insert_id();
		}
	}

	function login($post){
		$queryStr = "SELECT id, first_name, last_name, alias, email FROM users WHERE email=? AND password=?";
		$queryArr = array($post['email'], md5($post['password']));
		$user = $this->db->query($queryStr, $queryArr)->result_array();
		if(!empty($user))
			return $user[0];
		else
			return 'No user exists with those credentials';
	}
}