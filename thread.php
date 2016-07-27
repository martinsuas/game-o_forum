<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 7/27/2016
 * Time: 3:03 AM
 */


$page_title = "Forum";

include('includes/header.html');

require('../game-o_forum_includes/mysqli_connect.php');

if (isset($_GET['thread_id'])) {
    $thread_id = $_GET['thread_id'];
    $q = "SELECT title, forum_id FROM thread WHERE thread_id=thread_id";
    $r = mysqli_query($dbc, $q);
    $row = mysqli_fetch_row($r);
    $title = $row[0];
    $forum_id = $row[1];
} else {
    echo '<p class="error"><b>Thread does not exist.</b>
           <br>Please go back or try again later.</p>';
    exit();
}


if (isset($_GET['display']) and is_numeric($_GET['display'])) {
    $display = $_GET['display'];
} else {
    $display = 10;
}

// If number has already been determined
if (isset($_GET['pages']) and is_numeric($_GET['pages'])) {
    $pages = $_GET['pages'];
} else {
    // Count the number to be displayed
    $q = "SELECT COUNT(message_id)
          FROM message
          WHERE message.thread_id=$thread_id";

    $r = mysqli_query($dbc, $q);
    $row = @mysqli_fetch_row($r);
    $num_records = $row[0];

    // Calculate pages
    if ($num_records > $display) {
        $pages = ceil($num_records/$display);
    } else {
        $pages = 1;
    }
}

// Determine range of pages
if (isset($_GET['page'])) {  // Start already determined
    $page = $_GET['page'];
} else { // Determine start
    $page = 1;
}

// Calculate start
$start = (($page-1) * $display);

// Display messages:

echo '<div id="c_content">';

echo "<h1>$title</h1>";

if (isset($forum_id)) {
    echo '<a href="forum.php?forum_id=' . $forum_id . '">Back</a>';
}

$q = "SELECT message_id, message, date_posted, user_id, username
      FROM message NATURAL JOIN user
      WHERE message.thread_id=$thread_id
      LIMIT $start, $display";

$r = mysqli_query($dbc, $q);

if ($r) {
    if (mysqli_num_rows($r) != 0) {
        // Table header
        echo '<table class="message" align="center" cellspacing="2" cellpadding="2" width="100%">
		    <tr><td><b>Poster</b></td>
				<td><b>Message</b>
				<td><b>Date Posted</b></td></tr>';

        while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            echo '<tr>' .
                '<td><a href="view_user.php?user_id=' . $row['user_id'] . '">' .
                $row['username'] . '</a></td>' .
                '<td>' . $row['message'] . '</td>' .
                '<td>' . $row['date_posted'] . '</td>' .
                '</tr>';
        }

        echo '</table>';
        echo '</div>';

        include( 'functions/pagination.php');
        paginate("thread.php?thread_id=$thread_id&", $page, $pages, $display);
    }
} else {
    echo '<p class="error">There was an issue in accessing the database.
	We apologize for this inconvenience.';

    echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
}

echo '</div>';

include('includes/footer.html');