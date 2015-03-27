<?php
	if(!$this->session->userdata('current_user')['logged_in'])
		redirect('/');
	if($this->session->flashdata('errors'))
		$errors = $this->session->flashdata('errors');
?>
<html>
<head>
	<title>Add Book and Review</title>
	<link rel='stylesheet' href='./../../assets/skeleton/css/normalize.css'>
	<link rel='stylesheet' href='./../../assets/skeleton/css/skeleton.css'>
	<style>
	.error{
		color:red;
		margin-left:5px;
	}
	</style>
</head>
<body>
	<div class='container'>
		<div class='row'>
			<div class='ten columns'>
			<h4>Add a New Book Title and a Review</h4>
			<form action='/nav/create' method='post'>
				<div class='row'>
					<label class='two columns'>Book Title:</label>
					<input class='five columns' type='text' name='title'>
					<?php if(isset($errors['title'])) echo "<span class='error'>" . $errors['title'] . "</span>"; ?>
				</div>
				<div class='row'>
					<div class='row'>
						<label class='two columns'>Author:</label>
						<label class='five columns'>Choose from the list</label>
					</div>
					<div class='row'>
						<select name='author' class='offset-by-two columns five columns'>
							<option value='0'></option>
<?php
							foreach($authors as $author){	?>
								<option value='<?= $author['id'] ?>'><?= $author['name'] ?></option>
<?php							}	?>
						</select>
						<?php if(isset($errors['author'])) echo "<span class='error'>" . $errors['author'] . "</span>"; ?>
					</div>
					<div class='row'>
						<label class='offset-by-two columns five columns'>Or add a new author:</label>
					</div>
					<div class='row'>
						<input class='offset-by-two columns five columns' type='text' name='new_author' placeholder='New Author'>
						<?php if(isset($errors['new_author'])) echo "<span class='error'>" . $errors['new_author'] . "</span>"; ?>
					</div>
				</div>
				<div class='row'>
					<label class='two columns'>Review:</label>
					<textarea class='five columns' type='text' name='review'></textarea>
					<?php if(isset($errors['review'])) echo "<span class='error'>" . $errors['review'] . "</span>"; ?>
				</div>
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
				<div class='row'>
					<input class='offset-by-eight columns four columns button-primary' type='submit' value='Add Book and Review'>
				</div>
			</form>
			</div>
			<div class='two columns'>
				<div class='row'>
					<p class='six columns'><a href='../home'>Home</a></p>
					<p class='six columns'><a href='/dashboard/logoff'>Logout</a></p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>