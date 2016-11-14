<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 7/25/2016
 * Time: 12:27 AM
 */

/*
 * Redirects the user to an absolute URL
 */
function redirect_user($page = 'index.php') {
    $url = rtrim( "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']), '/\\');
    $url .= '/' . $page;
    header("Location:$url");
    exit();
}

/*
 * Validates form data, queries to database to check if valid user.
 * Returns: [$success, $errors|$results]
 *  - success   Boolean, True if success, False if failed
 *  - errors or results     Array containing all errors or results of the query.
 */
function validate_login($dbc, $username = '', $password = '' ) {
    $errors = array();

    if (empty($username)) {
        $errors[] = 'Please enter your username.';
    } else {
        $u = mysqli_real_escape_string($dbc, $username);
    }

    if (empty($password)) {
        $errors[] = 'Please enter your password.';
    } else {
        $p = mysqli_real_escape_string($dbc, $password);
    }

    if (empty($errors)) {
        $q = "SELECT user_id, username
              FROM user
              WHERE username='$u' AND password=SHA1('$p')
             ";
        $r = mysqli_query($dbc, $q);

        // If valid info
        if (mysqli_num_rows($r) == 1) {
            $row = mysqli_fetch_assoc($r);
            // Return true and the record
            return array(true, $row);
        } else {
            $errors[] = 'The email address and password information do not match those on file.';
        }
    }
    return array(false, $errors);
}




