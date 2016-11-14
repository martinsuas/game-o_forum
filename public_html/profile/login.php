<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 7/25/2016
 * Time: 8:22 PM
 *
 * Processes login form submission
 */

$root = $_SERVER['DOCUMENT_ROOT'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require($root . '/includes/login.inc.php');
    require($root  . '/../connection/mysqli_connect.php');

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
include($root . '/includes/user_login.inc.php');