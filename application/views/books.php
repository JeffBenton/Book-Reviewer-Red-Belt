<?php
	if(!$this->session->userdata('current_user')['logged_in'])
		redirect('/');
	$current_user = $this->session->userdata('current_user');
?>
<html>
<head>
	<title>Books Home</title>
	<link rel='stylesheet' href='./../../assets/skeleton/css/normalize.css'>
	<link rel='stylesheet' href='./../../assets/skeleton/css/skeleton.css'>
	<style>
	h5{
		margin-bottom:5px;
	}
	p{
		margin-bottom:10px;
		line-height: 110%;
	}
	.date{
		font-style:italic;
	}
	h6{
		margin-bottom:5px;
		padding:0 10px;
	}
	.books{
		height:250px;
		border:1px solid black;
		overflow:auto;
	}
	</style>
</head>
<body>
	<div class='container'>
		<div class='row'>
			<h4 class='eight columns'>Welcome, <a href='/nav/users/<?= $current_user['id'] ?>'><?= $current_user['alias'] ?>!</a></h4>
			<p class='three columns'><a href='/nav/add'>Add Book and Review</a></p>
			<p class='one column'><a href='/dashboard/logoff'>Logout</a></p>
		</div>
		<div class='row'>
			<div class='six columns'>
				<h5>Recent Book Reviews:</h5>
<?php
				foreach($latest as $review){	?>
					<div class='book'>
						<h5><a href='/nav/view/<?= $review['book_id'] ?>'><?= $review['title'] ?></a></h5>
						<div class='offset-by-one column'>
							<p>Rating: <?= $review['rating'] ?>/5</p>
							<p><a href='/nav/users/<?= $review['user_id'] ?>'><?= $review['alias'] ?></a> says: <?= $review['review'] ?></p>
							<p class='date'>Posted on <?= date_format(new Datetime($review['created_at']), 'F d, Y') ?></p>
						</div>
					</div>
<?php				}	?>
			</div>
			<div class='offset-by-one column five columns'>
				<h4>Other Books with Reviews:</h4>
				<div class='books'>
<?php
					foreach($books as $book){	?>
						<h6><a href='/nav/view/<?= $book['id'] ?>'><?= $book['title'] ?></a></h6>
<?php					}	?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>