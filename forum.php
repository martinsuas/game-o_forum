<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 7/26/2016
 * Time: 4:28 PM
 */

$page_title = "Forum";

include('includes/header.html');

require('../game-o_forum_includes/mysqli_connect.php');

// GET checkers

if (isset($_GET['forum_id'])) {
    $forum_id = $_GET['forum_id'];
    $q = "SELECT name FROM forum WHERE forum_id=$forum_id";
    $r = mysqli_query($dbc, $q);
    $row = mysqli_fetch_row($r);
    $name = $row[0];
} else {
    $forum_id = 0; // 0 indicates the forums choice menu.
    $name = "Welcome to the forums!";
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
    $q = "SELECT COUNT(thread_id)
          FROM thread
          WHERE thread.forum_id=$forum_id";

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

// Display threads and subthreads, if any exist.

echo '<div id="c_content">';

// Make query
$q = "SELECT forum_id, name
      FROM forum
      WHERE parent_id = $forum_id";

$r = mysqli_query($dbc, $q);


if ($r) {

    echo "<h1>$name</h1>";

    if (mysqli_num_rows($r) != 0) {
        if ($forum_id == 0) {
            echo '<h2>Main Forums:</h2>';
        } else {
            echo '<h2>Subforums:</h2>';
        }
    }

    while ($row = mysqli_fetch_assoc($r)) {
        echo '<p class="forum"><a href="forum.php?forum_id=' . $row['forum_id'] . '">' .
                    $row['name'] . '</a></p>';
    }
}

// Display threads, if any exist

$q = "SELECT thread_id, title, date_created, user_id, username
      FROM thread NATURAL JOIN user
      WHERE thread.forum_id=$forum_id
      LIMIT $start, $display";

$r = mysqli_query($dbc, $q);

if ($r) {
    if (mysqli_num_rows($r) != 0) {
        // Table header
        echo '<table class="thread" align="center" cellspacing="2" cellpadding="2" width="100%">
		    <tr><td><b>Title</b></td>
				<td><b>Author</b>
				<td><b>Date Created</b></td></tr>';

        while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            echo '<tr>' .
                '<td><a href="thread.php?thread_id=' . $row['thread_id'] . '">' .
                $row['title'] . '</a></td>' .
                '<td><a href="view_user.php?user_id=' . $row['user_id'] . '">' .
                $row['username'] . '</a></td>' .
                '<td>' . $row['date_created'] . '</td>' .
                '</tr>';
        }

        echo '</table>';
        echo '</div>';

        include( 'functions/pagination.php');
        paginate("forum.php?forum_id=$forum_id&", $page, $pages, $display);
    }
} else {
    echo '<p class="error">There was an issue in accessing the database.
	We apologize for this inconvenience.';

    echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
}

echo '</div>';

include('includes/footer.html');