<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 7/21/2016
 * Time: 3:42 PM
 *
 * This page deletes a user from a database.
 * Accessed through index.php
 */
$page_title = "Delete user";
$root = $_SERVER['DOCUMENT_ROOT'];

include($root . '/includes/header.html');


if (@$_COOKIE['username'] != 'admin') {
    echo '<h1>Access denied. Please log in as an admin.</h1>';
    include($root . '/includes/footer.html');
    exit();
}

echo '<h1>Delete User</h1>';

if ( isset($_GET['user_id']) and is_numeric($_GET['user_id'])) {
    $id = $_GET['user_id'];
}
elseif ( isset($_POST['user_id']) and is_numeric($_POST['user_id'])) {
    $id = $_POST['user_id'];
}
else {
    echo '<p class="error">This page has been accessed in error. Please go back.</p>';
    include($root . '/includes/footer.html');
    exit();
}

require_once($root  . '/../connection/mysqli_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['confirm'] == 'Yes') {
        // Delete recrod
        $q = "DELETE FROM user
              WHERE user_id=$id
              LIMIT 1";

        $r = mysqli_query($dbc, $q);
        if (mysqli_affected_rows($dbc) == 1) {
            // Print success
            echo '<p>User ' . $_POST["username"] . ' was successfully deleted.</p>';
        }
        else {
            echo '<p class"error">User ' . $_POST["username"] . ' could NOT be deleted.';

            // Debugging message
            echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>';
        }
    }
    else {
        echo '<p>User deletion cancelled. No changes were made to the database.</p>';
    }
}
else { // FORM
    $q = "SELECT username
          FROM user
          WHERE user_id=$id";
    $r = @mysqli_query($dbc, $q);

    if (mysqli_num_rows($r) == 1) {
        $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
        echo '<div id="c_content">';
        echo '<h3>Are you sure you want to delete user ' . $row['username'] . '?<h3/>';
        echo '<form action="delete_user.php" method="post">' .
                '<p><input type="radio" name="confirm" value="Yes" />Yes</p>'.
                '<p><input type="radio" name="confirm" value="No" />No</p>' .
                '<input type="submit" name="submit" value="Submit"/>    ' .
                '<input type="hidden" name="user_id" value="' . $id . '"/>' .
                '<input type="hidden" name="username" value="' . $row['username'] . '"/>' .
              '</form>';
        echo '</div>';
    }
    // Invalid userID
    else {
        echo '<p class="error">This page has been accesses due an error. Please try again or contact webmaster.';
    }

    mysqli_close($dbc);
    include($root . '/includes/footer.html');
}