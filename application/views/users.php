<?php
	if(!$this->session->userdata('current_user')['logged_in'])
		redirect('/');
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
	h6{
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
	</style>
</head>
<body>
	<div class='container'>
		<div class='row'>
			<p class='offset-by-seven columns one column'><a href='/home'>Home</a></p>
			<p class='three columns'><a href='/nav/add'>Add Book and Review</a></p>
			<p class='one column'><a href='/dashboard/logoff'>Logout</a></p>
		</div>
		<div class='row'>
			<div class='seven columns'>
				<h5>User Alias: <?= $user['alias'] ?></h5>
				<h6>Name: <?= $user['first_name'] . " " . $user['last_name'] ?></h6>
				<h6>Email: <?= $user['email'] ?></h6>
				<h6>Total Reviews: <?= $total ?></h6>

				<h5>Posted Reviews on the following books:</h5>
				<ul>
<?php
					foreach($reviews as $review){	?>
						<li><a href='/nav/view/<?= $review['book_id'] ?>'><?= $review['title'] . " (" . $review['total_reviews'] . ")" ?></a></li>
<?php					}	?>
				</ul>
			</div>
		</div>
	</div>
</body>
</html>