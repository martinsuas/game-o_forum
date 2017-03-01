<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 7/26/2016
 * Time: 4:28 PM
 */
$page_title = "Forum";
$root = $_SERVER['DOCUMENT_ROOT'];

include('../includes/header.html');
require_once('../../connection/pdo_connect.php');


// GET checkers
if (isset($_GET['forum_id'])) {
    $forum_id = $_GET['forum_id'];
    $sql = "SELECT name, parent_id FROM forum WHERE forum_id = :forum_id";
    $params = [':forum_id' => [$forum_id, PDO::PARAM_INT]];
    $stmt = $pdo->query_param($sql, $params);
    if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $name = $row[0];
        $parent_id = $row[1];
    }
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
    $sql = "SELECT COUNT(thread_id)
          FROM thread
          WHERE thread.forum_id=:forum_id";
    $params = [':forum_id' => [$forum_id, PDO::PARAM_INT]];
    $stmt = $pdo->query_param($sql, $params);
    $row = $stmt->fetch(PDO::FETCH_BOTH);
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
$sql = "SELECT forum_id, name
      FROM forum
      WHERE parent_id = :parent_id";
$params = [':parent_id' => [$forum_id, PDO::PARAM_INT]];
$stmt = $pdo->query_param($sql, $params);

if ($stmt) {

    echo "<h1>$name</h1>";

    if ($stmt->rowCount() != 0) {
        if ($forum_id == 0) {
            echo '<h2>Main Forums:</h2>';
        } else {
            echo '<h2>Subforums:</h2>';
        }
    }

    if (isset($parent_id)) {
        echo '<a href="index.php?forum_id=' . $parent_id . '">Back</a>';
    }

    while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
        echo '<p class="forum"><a href="index.php?forum_id=' . $row['forum_id'] . '">' .
                    $row['name'] . '</a></p>';
    }
}

// Display threads, if any exist

$sql = "SELECT thread_id, title, date_created, user_id, username
      FROM thread NATURAL JOIN user
      WHERE thread.forum_id=:forum_id
      ORDER BY date_created DESC
      LIMIT :start, :display
      ";
$params = [
    ':forum_id' => [$forum_id, PDO::PARAM_INT],
    ':start' => [$start, PDO::PARAM_INT],
    ':display' => [$display, PDO::PARAM_INT]
];
$stmt = $pdo->query_param($sql, $params);

if ($stmt) {
    if ($stmt->rowCount() != 0) {
        // Table header
        echo '<table class="thread" align="center" cellspacing="2" cellpadding="2" width="100%">
		    <tr><td><b>Title</b></td>
				<td><b>Author</b>
				<td><b>Date Created</b></td></tr>';

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>' .
                '<td><a href="thread.php?thread_id=' . $row['thread_id'] . '">' .
                $row['title'] . '</a></td>' .
                '<td><a href="/community/view_user.php?user_id=' . $row['user_id'] . '">' .
                $row['username'] . '</a></td>' .
                '<td>' . $row['date_created'] . '</td>' .
                '</tr>';
        }

        echo '</table>';
        echo '</div>';

        include($root . '/includes/pagination.php');
        paginate("index.php?forum_id=$forum_id&", $page, $pages, $display);
    }
}

echo '</div>';

include($root . '/includes/footer.html');