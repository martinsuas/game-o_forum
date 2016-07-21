<?php   
/**
 * Script 9.4 - view_users.php
 * View latest users registered into database.
 * @author  Martin Suarez [ms7605@rit.edu]
 */
	
	
$page_title = "Latest Users";
include( 'includes/header.html');

echo '<h1>Latest Users</h1>';

require('../game-o_forum_includes/mysqli_connect.php');

// Make query
$q = "SELECT user_id, username, DATE_FORMAT(registration_date, '%M %d, %Y') AS regd
	  FROM user
	  ORDER BY registration_date DESC
	  LIMIT 10";
	  
$r = @mysqli_query($dbc, $q);

if ($r) {
	// Table header
	echo '<table class="q_result" align="center" cellspacing="2" cellpadding="2" width="50%">
		    <tr><td align="left"><b>Name</b></td>
				<td align="left"><b>Date Registered</b>
				<td align="left"><b>Update</b>
				<td align="left"><b>Delete</b></td></tr>';
	
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		echo '<tr><td align="left">' . $row['username'] . '</td>' .
			     '<td align="left">' . $row['regd'] . '</td>' .
				 '<td align="left"><a href="edit_user.php?id=' . $row['user_id'] . '">Edit</a></td>' .
				 '<td align="left"><a href="delete_user.php?id=' . $row['user_id'] . '">Delete</a></td>' .
			  '</tr>';
	}
	
	echo '</table>';
	
	mysqli_free_result($r); // Free up resources, if any.
} else {
	echo '<p class="error">There was an issue in accessing the database.
	We apologize for this inconvenience.';
	
	echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
}

mysqli_close($dbc);
include( 'includes/footer.html' );
?>


		