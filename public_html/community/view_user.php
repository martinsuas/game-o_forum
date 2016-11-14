<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 7/27/2016
 * Time: 6:26 PM
 */
$root = $_SERVER['DOCUMENT_ROOT'];
$page_title = "User Page";

include($root . '/includes/header.html');
require($root  . '/../connection/mysqli_connect.php');

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $q = "SELECT username, first_name, middle_name, last_name, registration_date, gender
          FROM user 
          WHERE user_id=$user_id";

    $r = mysqli_query($dbc, $q);

    if ($r) {
        echo '<div id="c_content">';
        if (mysqli_num_rows($r) == 1) {
            $row = mysqli_fetch_assoc($r);
            $username = $row['username'];
            $page_title = $username;
            $first_name = $row['first_name'];
            $middle_name = $row['middle_name'];
            $last_name = $row['last_name'];
            $date = $row['registration_date'];
            $gender = $row['gender'];

            echo "<h1>$username</h1>";
            echo "<p><b>First name:</b> $first_name</p>";
            echo "<p><b>Middle name:</b> $middle_name</p>";
            echo "<p><b>Last name:</b> $last_name</p>";
            echo "<p><b>Member Since:</b> $date</p>";
            echo "<p><b>Gender:</b> $gender</p>";
        }
        echo '</div>';
    }
}

include($root . '/includes/footer.html');