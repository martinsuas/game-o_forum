<?php

/*
 * Creates a pagination bar to show the results of a query. The current default pagination has the following
 * format:
 *    <<  <  1 2 3 4 5 6 7  >  >>
 * Where << is first, < is previous page, > is next, and >> is last page. If more than 7 pages, the
 * bar will adjust to show the 2 numbers that are closest to the current and use a '...' for formatting. E.g.:
 *   <<  <  1  ... 2  |3| 4 ... 19  > >>
 *
 * Parameters:
 *  $name   The name of the current page the $_GET request will be made to.
 *  $page    The current page.
 *  $pages   The number of total number of pages.
 *  $display   How many records are shown per page.
 *  $class    Assign the format to the table using CSS.
 */
function paginate($name, $page, $pages, $display, $class = "pagination") {
    // Make links to first and previous pages
    echo '<table class="pagination" align="center"><tr>';
    if ($page == 1) // If first page, no back or first buttons.
        echo '<td><<</td><td><</td>';
    else {
        echo '<td><a href="' . $name . 'pages=' . $pages . '&display=' . $display . '&page=' . 1 .
            '"><<</a></td>'; // Link to first page
        echo '<td><a href="' . $name . 'pages=' . $pages . '&display=' . $display . '&page=' . ($page - 1) .
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
                echo '<a href="' . $name . 'pages=' . $pages . '&display=' . $display . '&page=' . $i .
                    '">' . $i . '</a>'; // Link to X page
            echo '</td>';
        }
    }
    else {
        $middle_p = round($pages/2); // Used to track index of middle pages.
        $end_p = $pages; // Used to track index of last pages.
        $current_p = $page; // Used only if current page is in the middle.

        for ($i = 1; $i <=7; $i++) {

            $middle_p = round($pages/2);
            echo '<td ';
            // If current page is one of the first two pages.
            if ($page <= 2) {

                if ($i <= 3) { // First three links
                    if ($page == $i)
                        echo 'class="current"';
                    echo '>';
                    echo '<a href="' . $name . 'pages=' . $pages . '&display=' . $display . '&page=' . $i .
                        '">' .  $i . '</a>';
                } elseif ($i == 5 ) { // Middle page
                    echo '>';
                    echo '<a href="' . $name . 'pages=' . $pages . '&display=' . $display .     '&page=' . $middle_p .
                        '">' . $middle_p . '</a>';
                    $middle_p += 1; // No effect at the moment, to be used if more pages are displayed.
                } elseif ($i == 7) { // Last page
                    echo '>';
                    echo '<a href="' . $name . 'pages=' . $pages . '&display=' . $display . '&page=' . $end_p .
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
                    echo '<a href="' . $name . 'pages=' . $pages . '&display=' . $display . '&page=' . $i .
                        '">' . $i . '</a>';
                } elseif ($i > 2 and $i < 6 ) { // Middle three pages
                    if ($i == 4)
                        echo 'class="current"';
                    echo '>';
                    echo '<a href="' . $name . 'pages=' . $pages . '&display=' . $display . '&page=' . ($current_p-1).
                        '">' . ($current_p-1) . '</a>';
                    $current_p++;
                } elseif ($i == 7) { // Last page
                    echo '>';
                    echo '<a href="' . $name . 'pages=' . $pages . '&display=' . $display . '&page=' . $end_p .
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
                    echo '<a href="' . $name . 'pages=' . $pages . '&display=' . $display . '&page=' . $i .
                        '">' . $i . '</a>';
                } elseif ($i == 3 ) { // Middle page
                    echo '>';
                    echo '<a href="' . $name . 'pages=' . $pages . '&display=' . $display . '&page=' . $middle_p .
                        '">' . $middle_p . '</a>';
                    $middle_p++; // No effect at the moment, to be used if more pages are displayed.
                } elseif ($i >= 5) { // Last page
                    if ($page == $end_p-2)
                        echo 'class="current"';
                    echo '>';
                    echo '<a href="' . $name . 'pages=' . $pages . '&display=' . $display . '&page=' . ($end_p-2) .
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
        echo '<td><a href="' . $name . 'pages=' . $pages . '&display=' . $display . '&page=' . ($page + 1) .
            '">></a></td>'; // Link to next page
        echo '<td><a href="' . $name . 'pages=' . $pages . '&display=' . $display . '&page=' . $pages .
            '">>></a></td>'; // Link to last page
    }
    echo '</tr></table>';
}

?>