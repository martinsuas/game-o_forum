<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 8/2/2016
 * Time: 6:00 PM
 *
 * Creates a new thread and verifies input.
 */

$page_title = "New Thread";
include($root . '/includes/header.html');
include($root . '/functions/form.php');
include($root . '/functions/login.php');


if ( isset($_COOKIE['username']) and is_numeric($_COOKIE['user_id']) ) {
    $username = $_COOKIE['username'];
    $user_id = $_COOKIE['user_id'];
} else {
    redirect_user();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require($root  . '/../connection/mysqli_connect.php');

    $errors = array();

    // Check for valid title
    if (empty($_POST['title'])) {
        $errors[] = "Please, enter a title for the thread.";
    } else {
        $title = mysqli_real_escape_string($_POST['title']);
    }

    // Check for valid message
    if (empty($_POST['message'])) {
        $errors[] = "Please, enter a valid message.";
    } else {
        $message = mysqli_real_escape_string($_POST['title']);
    }

    // If no errors, proceed with query
    if (empty($errors)) {
        $date = time();
        $q = "INSERT INTO thread (forum_id, user_id, title, date_created)
               VALUES ";
    }
}


?>
<!-- HTML start -->
<div id="c_content">
    <h2>Please fill in the following information to post a new message.</h2>
    <form action="new_thread.php" method="post" >
        <p>Title: <?php create_textbox('title', 100, 60) ?></p>
        <p>Message: <?php create_textbox('message', 10000, 1000) ?></p>
    </form>
</div>

<!-- HTML end -->
<?php
include($root . '/includes/footer.html');