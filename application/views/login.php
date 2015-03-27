<?php
	if($this->session->flashdata('registration_errors'))
		$registration_errors = $this->session->flashdata('registration_errors');
	if($this->session->userdata('current_user')['logged_in'])
		redirect('/home');
?>
<html>
<head>
	<title>Welcome</title>
	<link rel='stylesheet' href='./../../assets/skeleton/css/normalize.css'>
	<link rel='stylesheet' href='./../../assets/skeleton/css/skeleton.css'>
	<style>
	.error{
		color:red;
	}
	</style>
</head>
<body>
	<div class='container'>
		<div class='row'>
			<h1>Welcome!</h1>
<?php
			if($this->session->flashdata('failure'))
				echo "<h5 class='error'>" . $this->session->flashdata('failure') . "</h5>";
?>
		</div>
		<div class='row'>
			<div class='six columns'>
				<form action='/dashboard/register' method='post'>
					<label>First Name: <?php if(isset($registration_errors['first_name'])) echo "<span class='error'>" . $registration_errors['first_name'] . "</span>"; ?></label>
					<input class='u-full-width' type='text' name='first_name' placeholder='First Name'>
					<label>Last Name: <?php if(isset($registration_errors['last_name'])) echo "<span class='error'>" . $registration_errors['last_name'] . "</span>"; ?></label>
					<input class='u-full-width' type='text' name='last_name' placeholder='Last Name'>
					<label>Alias: <?php if(isset($registration_errors['alias'])) echo "<span class='error'>" . $registration_errors['alias'] . "</span>"; ?></label>
					<input class='u-full-width' type='text' name='alias' placeholder='Alias'>
					<label>Email: <?php if(isset($registration_errors['email'])) echo "<span class='error'>" . $registration_errors['email'] . "</span>"; ?></label>
					<input class='u-full-width' type='text' name='email' placeholder='email@domain.com'>
					<label>Password: <?php if(isset($registration_errors['password'])) echo "<span class='error'>" . $registration_errors['password'] . "</span>"; ?></label>
					<input class='u-full-width' type='password' name='password' placeholder='At least 8 characters in length'>
					<label>Confirm Password: <?php if(isset($registration_errors['confirm_password'])) echo "<span class='error'>" . $registration_errors['confirm_password'] . "</span>"; ?></label>
					<input class='u-full-width' type='password' name='confirm_password'>
					<input class='button-primary' type='submit' value='Register'>
				</form>
			</div>
			
			<div class='six columns'>
				<form action='/dashboard/login' method='post'>
					<label>Email:</label>
					<input class='u-full-width' type='text' placeholder='email@domain.com' name='email'>
					<label>Password:</label>
					<input class='u-full-width' type='password' name='password' placeholder='Case sensitive'>
<?php
					if($this->session->flashdata('login_errors'))
						echo "<p class='error'>" . $this->session->flashdata('login_errors') . "</p>";
?>					
					<input class='button-primary' type='submit' value='Login'>
				</form>
			</div>
		</div>
	</div>
</body>
</html>