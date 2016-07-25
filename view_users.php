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

//echo '<p>Results per page: <select name="rpp">' .
//    update_option('rpp', )

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
	// Table header
	echo '<table class="q_result" align="center" cellspacing="2" cellpadding="2" width="50%">
		    <tr><td><b>Name</b></td>
				<td><b>Date Registered</b>
				<td><b>Update</b>
				<td><b>Delete</b></td></tr>';
	
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		echo '<tr><td>' . $row['username'] . '</td>' .
			     '<td>' . $row['regd'] . '</td>' .
				 '<td><a href="edit_user.php?user_id=' . $row['user_id'] . '">Edit</a></td>' .
				 '<td><a href="delete_user.php?user_id=' . $row['user_id'] . '">Delete</a></td>' .
			  '</tr>';
	}
	
	echo '</table>';

    ///
    /// PAGINATION
    ///

    // Make links to first and previous pages
    echo '<table class="pagination" align="center"><tr>';
    if ($page == 1) // If first page, no back or first buttons.
        echo '<td><<</td><td><</td>';
    else {
        echo '<td><a href="view_users.php?pages=' . $pages . '&display=' . $display . '&page=' . 1 .
            '"><<</a></td>'; // Link to first page
        echo '<td><a href="view_users.php?pages=' . $pages . '&display=' . $display . '&page=' . ($page - 1) .
            '"><</a></td>'; // Link to previous page
    }

    // Make page numbers
    if ($pages <= 7) {
        for ($i = 1; $i <=7; $i++) {
            echo '<td ';
            if ($page == $i)
                echo 'class="current"';
            echo '>';
            if ($i > $pages) // If empty
                echo '...';
            else // If p is valid
                echo '<a href="view_users.php?pages=' . $pages . '&display=' . $display . '&page=' . $i .
                    '">' . $i . '</a>'; // Link to X page
            echo '</td>';
        }
    }
    else {
        $middle_p = round($page/2); // Used to track index of middle pages.
        $end_p = $pages; // Used to track index of last pages.
        $current_p = $page; // Used only if current page is in the middle.

        for ($i = 1; $i <=7; $i++) {

            $middle_p = 15; //round($page/2);
            echo '<td ';
            // If current page is one of the first two pages.
            if ($page <= 2) {

                if ($i <= 3) { // First three links
                    if ($page == $i)
                        echo 'class="current"';
                    echo '>';
                    echo '<a href="view_users.php?pages=' . $pages . '&display=' . $display . '&page=' . $i .
                        '">' .  $i . '</a>';
                } elseif ($i == 5 ) { // Middle page
                    echo '>';
                    echo '<a href="view_users.php?pages=' . $pages . '&display=' . $display . '&page=' . $middle_p .
                        '">' . $middle_p . '</a>';
                    $middle_p++; // No effect at the moment, to be used if more pages are displayed.
                } elseif ($i == 7) { // Last page
                    echo '>';
                    echo '<a href="view_users.php?pages=' . $pages . '&display=' . $display . '&page=' . $end_p .
                        '">' . $end_p . '</a>';
                    $end_p++; // No effect at the moment, to be used if more pages are displayed.
                }  else {  // Dots (...) 4th and 6th
                    echo '>';
                    echo '...';
                }
            }
            // If current page is in the middle
            elseif ($page > 2 and $page < $pages-1 ) {
                if ($i == 1) { // First link
                    echo '>';
                    echo '<a href="view_users.php?pages=' . $pages . '&display=' . $display . '&page=' . $i .
                        '">' . $i . '</a>';
                } elseif ($i > 2 and $i < 6 ) { // Middle three pages
                    if ($i == 4)
                        echo 'class="current"';
                    echo '>';
                    echo '<a href="view_users.php?pages=' . $pages . '&display=' . $display . '&page=' . ($current_p-1).
                        '">' . ($current_p-1) . '</a>';
                    $current_p++;
                } elseif ($i == 7) { // Last page
                    echo '>';
                    echo '<a href="view_users.php?pages=' . $pages . '&display=' . $display . '&page=' . $end_p .
                        '">' . $end_p . '</a>';
                    $end_p++; // No effect at the moment, to be used if more pages are displayed.
                }  else {  // Dots (...) 2nd and 6th
                    echo '>';
                    echo '...';
                }
            }
            // If current page is one of the last two pages
            else {
                if ($i == 1) { // First link
                    echo '>';
                    echo '<a href="view_users.php?pages=' . $pages . '&display=' . $display . '&page=' . $i .
                        '">' . $i . '</a>';
                } elseif ($i == 3 ) { // Middle page
                    echo '>';
                    echo '<a href="view_users.php?pages=' . $pages . '&display=' . $display . '&page=' . $middle_p .
                        '">' . $middle_p . '</a>';
                    $middle_p++; // No effect at the moment, to be used if more pages are displayed.
                } elseif ($i >= 5) { // Last page
                    if ($page == $end_p-2)
                        echo 'class="current"';
                    echo '>';
                    echo '<a href="view_users.php?pages=' . $pages . '&display=' . $display . '&page=' . ($end_p-2) .
                        '">' . ($end_p-2) . '</a>';
                    $end_p++;
                }  else {  // Dots (...) 2th and 4th
                    echo '>';
                    echo '...';
                }
            }
            // Close td
            echo '</td>';
        }
    }

    // Make links to last and next pages
    if ($page == $pages) // If last page, no next or last buttons.
        echo '<td>></td><td>>></td>';
    else {
        echo '<td><a href="view_users.php?pages=' . $pages . '&display=' . $display . '&page=' . ($page + 1) .
            '">></a></td>'; // Link to next page
        echo '<td><a href="view_users.php?pages=' . $pages . '&display=' . $display . '&page=' . $pages .
            '">>></a></td>'; // Link to last page
    }
    echo '</tr></table>';


	mysqli_free_result($r); // Free up resources, if any.
} else {
	echo '<p class="error">There was an issue in accessing the database.
	We apologize for this inconvenience.';
	
	echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
}

mysqli_close($dbc);
include( 'includes/footer.html' );
?>


		