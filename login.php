<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 7/25/2016
 * Time: 8:22 PM
 *
 * Processes login form submission
 */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('functions/login.inc.php');
    require( '../game-o_forum_includes/mysqli_connect.php');

    // Check log in
    list($validated, $data) = validate_login($dbc, $_POST['username'], $_POST['password']);

    if ($validated) { // Valid user data
        setcookie('user_id', $data['user_id']);
        setcookie('username', $data['username']);
        // Redirect
        redirect_user('index.php');
    } else {
        $errors = $data;
    }
}
// Create page
include('includes/user_login.inc.php');