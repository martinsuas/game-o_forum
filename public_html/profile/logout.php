<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 7/26/2016
 * Time: 5:39 PM
 */

$root = $_SERVER['DOCUMENT_ROOT'];

if (isset($_COOKIE['username'])) {
    setcookie('username');
    setcookie('user_id');
    setcookie('username', '', time()-3600, '/', 0, 0);
    setcookie('user_id', '', time()-3600, '/', 0, 0);
} else {
    require($root . '/includes/login.inc.php');
    redirect_user();
}

$page_title = 'Logged Out';
include($root . '/includes/header.html');

echo '<div id="c_content"><h1>Logged Out Successful</h1><p>Thank you for visiting!</p></div>';
include($root . '/includes/footer.html');
?>