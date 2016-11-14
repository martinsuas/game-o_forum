<?php   
/**
 * Script 9.3 - register.php
 * Creates a form to register user and attempts to add new user
 * to the forum database.
 * @author  Martin Suarez [ms7605@rit.edu]
 */
	
	
$page_title = "Register";
$root = $_SERVER['DOCUMENT_ROOT'];

include($root . '/includes/header.html');
include($root . '/includes/form.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	require($root  . '/../connection/mysqli_connect.php'); // Connect to DB
	$errors = array();

	// Check username
	if (empty($_POST['username'])) 
		$errors[] = 'Please enter a valid username.';
	else
		$username = mysqli_real_escape_string($dbc, trim($_POST['username']));

	// Check if username already exists
	if (mysqli_num_rows(mysqli_query( $dbc , "
		SELECT user_id FROM user WHERE username='$username'")) != 0)
		$errors[] = 'Username is already taken.';
		
	// Check password A
	if (empty($_POST['passA'])) 
		$errors[] = 'Please enter a valid password.';
	else {
		$passA = mysqli_real_escape_string($dbc, $_POST['passA']);
		// Check password B
		if (empty($_POST['passB'])) 
			$errors[] = 'Please re-enter the password.';
		else {
			$passB = mysqli_real_escape_string($dbc, $_POST['passB']);
			// Check password match
			if ($passA != $passB)
				$errors[] = 'Passwords do not match. Please, re-enter.';
			else
				$password = $passA;
		}
	}

	// Check email
	if (empty($_POST['email']))
		$errors[] = 'Please enter a valid email.';
	else
		$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
	
	// Check if email address already exists
	if (mysqli_num_rows(mysqli_query( $dbc , "
		SELECT user_id FROM user WHERE email='$email'")) != 0)
		$errors[] = 'Email address already exists';

	// Check gender
	if (empty($_POST['gender']))
		$errors[] = 'Please choose the closest gender you identify with.';
	else
		$gender = $_POST['gender'];

	// Check date of birth
	if (empty($_POST['dob']))
		$errors[] = 'Please enter your date of birth.';
	else
		$dob = trim($_POST['dob']);

	/* If no errors */
	if (empty($errors)) {
		// Register the user into the database

		$q = "INSERT INTO user (username, password, email, registration_date, dob, gender) 
			  VALUES ('$username', SHA1('$password'), '$email', UTC_TIMESTAMP(),  '$dob', '$gender')";
		$r = @mysqli_query($dbc, $q);

		if ($r) {
			echo '<h1>Success!</h1>
				 <p>You are now registered to Game-o Forums!</p>';
		} else {
			echo '<h1>Error:</h1>
				<p class="error">Registration unsunccessful due to a system error. We apologize for the inconvenience.</p>';
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
		}

		// Close connection and exit script
		mysqli_close($dbc);

		include($root . '/includes/footer.html');
		exit();
	}
	else {
		echo '<h1>Error</h1>
			<p class="error">Error. Please correct the following issues:</p>';
		foreach ($errors as $e)
			echo "<p> - $e<br /></p>";
	}
}
?>
<!--HTML Start-->
<div id="c_content">
<h1>Welcome to Game-o Forums!</h1>
<h2>Please enter the following information to register.</h2>
<form action="register.php" method="post">
	<p>Username: <?php create_textbox('username'); ?></p>
	<p>Password: <?php create_password_textbox('passA'); ?></p>
	<p>Confirm Password: <?php create_password_textbox('passB'); ?></p>
	<p>E-mail: <?php create_textbox('email', 60, 40, true); ?></p>
	<p>Gender: <span class="input">
		<?php 
			create_radio('gender', 'Male');
			create_radio('gender', 'Female');
			create_radio('gender', 'Other');
		?>
		</span>
	</p>
	<p>Date of birth: <?php create_date('dob') ?></p>
	<p><input type="submit" name="submit" value="Submit" /></p>
</form>
</div>
<!--HTML End-->

<?php include($root . '/includes/footer.html'); ?>

		