<?php   
/**
 * Script 9.7 - change_password
 * Creates a form used to let the user change their password.
 * @author  Martin Suarez [ms7605@rit.edu]
 */
	
	
$page_title = "Change Your Password";
include( 'includes/header.html');

//~~~~~~~~~~~~//
// FUNCTIONS  //
//~~~~~~~~~~~~//
/**
 * @param  string   $name  Reference name.	
 */
function create_textbox($name, $maxlength=20, $size=20, $email=false) {
	echo '<input type="';
	// Check if e-mail
	if (!$email)  echo 'text';  else echo 'email';
	// Continue building textbox
	echo '" name="' . $name 
	. '" size="' . $size . '" maxlength="' . $maxlength .'" value="';
	// Check for stickiness
	if (isset($_POST[$name])) echo $_POST[$name];
	echo '"/>';
}

function create_password_textbox($name, $maxlength=40, $size=20) {
	echo '<input type="password" name="' . $name 
	. '" size="' . $size . '" maxlength="' . $maxlength . '" />';
}

function create_date($name) {
	echo '<input type="date" name="dob" value="';
	if (isset($_POST[$name])) echo $_POST[$name];
	echo '">';
}

/**
 * @param  string   $name  Reference name.	
 * @param  string   $value Value of radio option
 */
function create_radio($name, $value) {
	echo '<input type="radio" name="' . $name . '" value="' . $value . '"';
	// Check for stickiness
	if (isset($_POST[$name]) && ($_POST[$name] == $value))
		echo 'checked="checked"';
	echo "/>$value &nbsp";
}

/**
 * @param  string   $name  Reference name.	
 * @param  string   $value Value of multiselect option
 */
function create_option($name, $value, $text) {
	echo '<option value="' . $value . '"';
	// Check for stickiness
	if (isset($_POST[$name]) && ($_POST[$name] == $value))
		echo 'selected="selected"';
	echo "/>$text";
}

//~~~~~~~~~~~~~~~~~~//
// FORM SUBMISSION  //
//~~~~~~~~~~~~~~~~~~//

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	require('../game-o_forum_includes/mysqli_connect.php'); // Connect to DB
	$errors = array();

	// Check username
	if (empty($_POST['username'])) 
		$errors[] = 'Please enter a valid username.';
	else
		$username = mysqli_real_escape_string($dbc, trim($_POST['username']));

	// Check old password
	if (empty($_POST['pass_old'])) 
		$errors[] = 'Please enter your current password.';
	else
		$password = mysqli_real_escape_string($dbc, $_POST['pass_old']);
		
	// Check password A
	if (empty($_POST['passA'])) 
		$errors[] = 'Please enter a valid new password.';
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
				$newpass = $passA;
		}
	}

	/* If no errors */
	if (empty($errors)) {
		
		// Check credentials
		$q = "SELECT user_id
			  FROM user
			  WHERE username='$username' AND password=SHA1('$password')";
		
		$r = @mysqli_query($dbc, $q);
		$num = @mysqli_num_rows($r);
		
		// If credentials are valid, update the password
		if ($num == 1) {
			// Get user_id
			$row = mysqli_fetch_array($r, MYSQLI_NUM);
			
			// Make the UPDATE
			$q = "UPDATE user
				  SET password=SHA1('$newpass')
				  WHERE user_id=$row[0]";
			$r = @mysqli_query($dbc, $q);
			
			// If update is successful 
			if (mysqli_affected_rows($dbc) == 1) {
				// Print success message
				echo '<h1>Your password was successfully updated.</h1>';
			}
			// Update is not successful
			else {
				echo '<h1>System Error</h1>
					  <p class="error">Your password could not be changed due to 
					  an error in the system. We apologize for this inconvenience.</p>';
				
				// Debugging
				echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: '
				. $q . '</p>';
			}
			
		} else { // Invalid credentials
			echo '<h1>Login Error</h1>
				  <p class="error">Invalid username or password.</p>';
		}
	}
	// If errors
	else {
		echo '<h1>Error</h1>
			<p class="error">Error. Please correct the following issues:</p>';
		foreach ($errors as $e)
			echo "<p> - $e<br /></p>";
	}
	mysqli_close($dbc);
} // End of submit conditional
?>
<!--HTML Start-->
<h1>Change your password:</h1>
<h2>Please enter the following information to update your password.</h2>
<form action="change_password.php" method="post">
	<p>Username: <?php create_textbox('username'); ?></p>
	<p>Current Password: <?php create_password_textbox('pass_old'); ?></p>
	<p>New Password: <?php create_password_textbox('passA'); ?></p>
	<p>Confirm New Password: <?php create_password_textbox('passB'); ?></p>
	<p><input type="submit" name="submit" value="Submit" /></p>
</form>
<!--HTML End-->

<?php include( 'includes/footer.html' ); ?>

		