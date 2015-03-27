<?php
	if(!$this->session->userdata('current_user')['logged_in'])
		redirect('/');
	if($this->session->flashdata('errors'))
		$errors = $this->session->flashdata('errors');
?>
<html>
<head>
	<title>View Book</title>
	<link rel='stylesheet' href='./../../assets/skeleton/css/normalize.css'>
	<link rel='stylesheet' href='./../../assets/skeleton/css/skeleton.css'>
	<style>
	h3{
		margin-bottom:5px;
	}
	h5{
		margin-bottom:5px;
	}
	li{
		list-style:none;
		margin-left:30px;
		margin-bottom:2px;
	}
	li a{
		text-decoration:none;
	}
	p{
		margin-bottom:10px;
		line-height: 110%;
	}
	form{
		margin:0;
	}
	.review{
		border:1px solid black;
		margin:10px;
		padding:10px;
	}
	.date{
		font-style:italic;
	}
	.error{
		color:red;
		font-size:14px;
	}
	</style>
</head>
<body>
	<div class='container'>
		<div class='row'>
			<p class='offset-by-ten columns one column'><a href='/home'>Home</a></p>
			<p class='one column'><a href='/dashboard/logoff'>Logout</a></p>
		</div>
		<div class='row'>
			<h3><?= $book['title'] ?></h3>
			<h5>Author: <?= $book['name'] ?></h5>
			<h5>Composite Rating: <?= $book['rating'] ?>/5</h5>
		</div>
		<div class='row'>
			<div class='seven columns'>
				<h3>Reviews:</h3>
<?php
				foreach($reviews as $review){	?>
					<div class='review'>
						<p>Rating: <?= $review['rating'] ?>/5</p>
						<p><a href='/nav/users/<?= $review['id'] ?>'><?= $review['alias'] ?></a> says: <?= $review['review'] ?></p>
						<p class='date'>Posted on <?= date_format(new Datetime($review['created_at']), 'F d, Y') ?></p>
<?php						if($this->session->userdata('current_user')['id'] == $review['user_id']){	?>
						<form action='/nav/destroy_review' method='post'>
							<input type='hidden' name='review_id' value='<?= $review['review_id'] ?>'>
							<input type='hidden' name='book_id' value='<?= $book['id'] ?>'>
							<input type='submit' value='Delete'>
						</form>
<?php						}	?>
					</div>
<?php				}	?>
			</div>
			<div class='five columns'>
				<h5>Add a Review: <?php if(isset($errors)) echo "<span class='error'>" . $errors . "</span>"; ?></h5>
				<form action='/nav/create_review/<?= $book['id'] ?>' method='post'>
					<textarea class='u-full-width' name='review'></textarea>
					<div class='row'>
						<label class='two columns'>Rating:</label>
						<select name='rating' class='two columns'>
							<option value='1'>1</option>
							<option value='2'>2</option>
							<option value='3'>3</option>
							<option value='4'>4</option>
							<option value='5'>5</option>
						</select>
						<label class='two columns'>stars.</label>
					</div>
					<input class='offset-by-five columns seven columns button-primary' type='submit' Value='Submit Review'>
				</form>
			</div>
		</div>
	</div>
</body>
</html>