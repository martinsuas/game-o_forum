<?php
/**
 * Created by PhpStorm.
 * User: Martin Suarez
 * Date: 7/22/2016
 * Time: 7:07 PM
 *
 * This page allows to update a user from a database.
 * Accessed through view_users.php
 */
$page_title = "Update user";
include('includes/header.html');
include('functions/form.php');

if (@$_COOKIE['username'] != 'admin') {
    echo '<h1>Access denied. Please log in as an admin.</h1>';
    include('includes/footer.html');
    exit();
}

echo '<h1>Update User</h1>';

if ( isset($_GET['user_id']) and is_numeric($_GET['user_id'])) {
    $id = $_GET['user_id'];
}
elseif ( isset($_POST['user_id']) and is_numeric($_POST['user_id'])) {
    $id = $_POST['user_id'];
}
else {
    echo '<p class="error">This page has been accessed due an error. Please go back Nsa.</p>';
    include('includes/footer.html');
    exit();
}

require_once ('../game-o_forum_includes/mysqli_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();

    // Check for name input

    // Get name
    $first_name = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
    $middle_name = mysqli_real_escape_string($dbc, trim($_POST['middle_name']));
    $last_name = mysqli_real_escape_string($dbc, trim($_POST['last_name']));

    // Check email
    if (empty($_POST['email']))
        $errors[] = 'Please enter a valid email.';
    else
        $email = mysqli_real_escape_string($dbc, trim($_POST['email']));

    // Check if email address already exists
    if (mysqli_num_rows(mysqli_query( $dbc , "
		SELECT user_id FROM user WHERE email='$email' AND NOT(user_id=$id)")) != 0)
        $errors[] = 'Email address already exists.';

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
    if (empty($errors)) {
        // Make update query
        $q = "UPDATE user SET first_name='$first_name', middle_name='$middle_name', last_name='$last_name', 
              email='$email', dob='$dob', gender='$gender'
              WHERE user_id=$id LIMIT 1";
        $r = @mysqli_query($dbc, $q);
        if (mysqli_affected_rows($dbc) == 1) {
            // Success
            echo '<p>User information was successfully updated.</p>';
        } else {
            echo '<p class="error">System error: User information could not be updated. 
                  Apologies for the inconvenience';
            echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging messages
        }
    }
    else { // An error is found

        echo '<p class="error">User update failed. The following errors have occurred:<br/>';
        foreach($errors as $e) {
            echo "  - " . $e . '<br/>';
        }
    }
}
else { // FORM
    $q = "SELECT first_name, middle_name, last_name, email, dob, gender
          FROM user
          WHERE user_id=$id";
    $r = @mysqli_query($dbc, $q);

    if (mysqli_num_rows($r) == 1) {
        $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
        echo '<div id="c_content"></div><form action="edit_user.php" method="post">' .
                '<p>First Name: ' . update_textbox('first_name', $row['first_name']) . '</p>' .
                '<p>Middle Name: '. update_textbox('middle_name', $row['middle_name']) . '</p>' .
                '<p>Last Name: ' . update_textbox('last_name', $row['last_name']) . '</p>' .
                '<p>E-mail: ' . update_textbox('email', $row['email'], 60, 40, true) . '</p>' .
                '<p>Date of Birth: ' . update_date('dob', $row['dob']) . '</p>' .
                '<p>Gender<span class="input">' .
                    update_radio('gender', $row['gender'], 'Male') . update_radio('gender', $row['gender'], 'Female') .
                    update_radio('gender', $row['gender'], 'Other'). '</span></p>'.
                '<p><input type="submit" name="submit" value="Submit" /></p>' .
                '<input type="hidden" name="user_id" value="' . $id . '"/>' .
            '</form ></div>';
    } else {
        echo '<p class="error">This page has been accessed due an error. Please try again.</p>';
    }

    mysqli_close($dbc);
    include('includes/footer.html');
}