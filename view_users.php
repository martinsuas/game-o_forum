<?php   
/**
 * Script 9.4 - view_users.php
 * View latest users registered into database.
 * @author  Martin Suarez [ms7605@rit.edu]
 */

$page_title = "Manage Users";
include( 'includes/header.html');

echo '<h1>Manage Users</h1>';


require('../game-o_forum_includes/mysqli_connect.php');

// Number to display per page
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
    $q = "SELECT COUNT(user_id)
          FROM user";
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

// Make query
$q = "SELECT user_id, username, DATE_FORMAT(registration_date, '%M %d, %Y') AS regd
	  FROM user
	  ORDER BY registration_date DESC
	  LIMIT $start, $display";

$r = mysqli_query($dbc, $q);

if ($r) {
    include('functions/form.php');

    echo '<div id=c_content>';

	// Table header
	echo '<table class="q_result" align="center" cellspacing="2" cellpadding="2" width="100%">
		    <tr><td><b>Name</b></td>
				<td><b>Date Registered</b>
				<td><b>Update</b>
				<td><b>Delete</b></td></tr>';
	
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		echo '<tr><td><a href="view_user.php?user_id=' . $row['user_id'] . '">'.$row['username'].'</a></td>' .
			     '<td>' . $row['regd'] . '</td>' .
				 '<td><a href="edit_user.php?user_id=' . $row['user_id'] . '">Edit</a></td>' .
				 '<td><a href="delete_user.php?user_id=' . $row['user_id'] . '">Delete</a></td>' .
			  '</tr>';
	}
	
	echo '</table>';
    echo '</div>';

    include( 'functions/pagination.php');
    paginate('view_users.php?', $page, $pages, $display);

	mysqli_free_result($r); // Free up resources, if any.
} else {
	echo '<p class="error">There was an issue in accessing the database.
	We apologize for this inconvenience.';
	
	echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
}

mysqli_close($dbc);
include( 'includes/footer.html' );
?>


		