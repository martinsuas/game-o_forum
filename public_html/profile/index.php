<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 7/26/2016
 * Time: 4:26 PM
 *
 * User's home page.
 */



$page_title = "Home";
$root = $_SERVER['DOCUMENT_ROOT'];

include($root . '/includes/header.html');

require($root  . '/../connection/mysqli_connect.php');


if (isset($_GET['display']) and is_numeric($_GET['display'])) {
    $display = $_GET['display'];
} else {
    $display = 10;
}
if (isset($_COOKIE['username']) and isset($_COOKIE['user_id'])) {
    $username = $_COOKIE['username'];
    $user_id = $_COOKIE['user_id'];

    // If number has already been determined
    if (isset($_GET['pages']) and is_numeric($_GET['pages'])) {
        $pages = $_GET['pages'];
    } else {
        // Count the number to be displayed
        $q = "SELECT COUNT(thread_id)
          FROM thread
          WHERE thread.user_id=$user_id";

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

    echo '<div id="c_content">';

    echo '<h1>Welcome, ' . $username . '!</h1>';

    echo '<p>Your most recent threads: </p>';

    // Display threads, if any exist

    $q = "SELECT thread_id, title, date_created, user_id, username
      FROM thread NATURAL JOIN user
      WHERE thread.user_id = $user_id
      ORDER BY date_created DESC
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
                    '<td><a href="/forum/thread.php?thread_id=' . $row['thread_id'] . '">' .
                    $row['title'] . '</a></td>' .
                    '<td><a href="/community/view_user.php?user_id=' . $row['user_id'] . '">' .
                    $row['username'] . '</a></td>' .
                    '<td>' . $row['date_created'] . '</td>' .
                    '</tr>';
            }

            echo '</table>';

            include($root . '/includes/pagination.php');
            paginate("index.php?&", $page, $pages, $display);
        }
    } else {
        echo '<p class="error">There was an issue in accessing the database.
	        We apologize for this inconvenience.';

        echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
    }

    echo '</div>';
} else {
    require($root . '/includes/login.inc.php');
    redirect_user();
}

include($root . '/includes/footer.html');