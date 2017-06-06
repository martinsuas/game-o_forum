<?php   # Script 3.4 - index.php
		# Created 01/11/2016
		# Created by Martin Suarez
		# This script experiments with using multiple files.
		#
		# Script 3.7 - update #2
		# Created 02/26/2016
		# Created by Martin Suarez
		# Added functions to the website

// Adds an ad.
function create_ad() {
	echo '<p class="ad">ADVERTISEMENT!</p>';
}
$page_title = "Homepage";
include('includes/header.html');

?>
<div id="c_content">
    <h1>Welcome</h1>
    <h2>About this website...</h2>
    <p>Welcome to Game-o Forum! This sample website is created using PHP, MySQL, and will eventually include
        JavaScript. The goal of it is to apply newly learned concepts and showcase them as a portfolio
        of my current mastery of these languages. Please, be aware that this website utilizes cookies.
    </p>

    <p>All registered users can login and logout. Pre-registered users all have the password: "hello".
        Specific user features are still to be implemented. Anyone can create a user and log in into the system.
    </p>

    <p>
        Please note, website still hasn't been optimized for security and cookies are being used to keep track
        of user information, besides GETs and POSTs. A more secure version is to be implemented that will use
        sessions instead.
    </p>

    <p>
        Anyone can view the data populated in the tables, specifically the current users and the forums
        themselves, which are made of threads and messages within the threads. Please, be aware there is no
        way to add, edit, or delete messages or threads at the moment.
        Anyone can access the "Manage Users" page, but only an admin can edit or update users.
    </p>

    <p>The source code can be found <a href="https://github.com/martinsuas/game-o_forum">here on GitHub</a>. Please
        contact me if you have any questions.</p>

    <p>A lot more updates to come soon! But here are a few things I plan to implement:
    <ul>
        <li>User uploaded images to use as an avatar.</li>
        <li>Private messages and friendships between users.</li>
        <li>Increased security through more secure methods.</li>
        <li>User information that synchronizes with another table related to a game.</li>
        <li>JavaScript to make the website more dynamic and appealing.</li>
    </ul>
    </p>

</div>


<?php
include('includes/footer.html'); ?>

